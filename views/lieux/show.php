<?php

require_once __DIR__ . '/../../middleware/Auth.php';
require_once __DIR__ . '/../../models/dao/LikeDAO.php';
require_once __DIR__ . '/../../models/dao/CommenterDAO.php';

$likeDAO = new LikeDAO();
$commenterDAO = new CommenterDAO();

$userId = $_SESSION['user_id'] ?? null;
$isAdmin = Auth::estAdmin();

// Récupération des likes

$nombreLikes = $likeDAO->countByLieu($lieu->getLieuId());

$userLike = false;

if ($userId !== null) {
    $userLike = $likeDAO->exists(
        (int) $userId,
        $lieu->getLieuId()
    );
}

// Récupération des commentaires

$commentaires = $commenterDAO->findByLieu(
    $lieu->getLieuId()
);

// Cache

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($lieu->getLieuNom()) ?>
    </title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body class="bg-gray-100 min-h-screen">

    <!-- HEADER -->

    <header class="bg-white border-b shadow-sm">

        <div class="max-w-6xl mx-auto px-6 py-4">

            <div class="flex items-center justify-between">

                <a href="index.php?controller=lieu&action=index"
                    class="flex items-center gap-2 text-gray-700 hover:text-black transition">

                    <i data-lucide="arrow-left" class="w-5 h-5"></i>

                    <span class="font-medium">
                        Retour aux lieux
                    </span>

                </a>

            </div>

        </div>

    </header>


    <!-- CONTENU -->

    <main class="max-w-6xl mx-auto px-6 py-10">

        <!-- INFORMATIONS DU LIEU -->

        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

            <!-- Image -->

            <div class="w-full h-96 bg-gray-200">

                <?php if (!empty($lieu->getLieuImage())): ?>

                    <img src="<?= htmlspecialchars($lieu->getLieuImage()) ?>"
                        alt="<?= htmlspecialchars($lieu->getLieuNom()) ?>" class="w-full h-full object-cover">

                <?php else: ?>

                    <div class="w-full h-full flex items-center justify-center text-gray-400">

                        <i data-lucide="image-off" class="w-16 h-16"></i>

                    </div>

                <?php endif; ?>

            </div>


            <!-- Informations -->

            <div class="p-8">

                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">

                    <div>

                        <h1 class="text-3xl font-bold text-gray-900">

                            <?= htmlspecialchars($lieu->getLieuNom()) ?>

                        </h1>

                        <div class="mt-3 flex items-center gap-2 text-gray-600">

                            <i data-lucide="map-pin" class="w-5 h-5"></i>

                            <span>

                                <?= htmlspecialchars($lieu->getLieuAdresse()) ?>

                                -

                                <?= htmlspecialchars($lieu->getLieuCp()) ?>

                            </span>

                        </div>

                    </div>


                    <!-- Prix -->

                    <div class="text-left md:text-right">

                        <p class="text-3xl font-bold text-gray-900">

                            <?= number_format(
                                $lieu->getLieuPrix(),
                                2,
                                ',',
                                ' '
                            ) ?>

                            €

                        </p>

                        <p class="text-sm text-gray-500">
                            par jour
                        </p>

                    </div>

                </div>


                <!-- Description -->

                <div class="mt-8">

                    <h2 class="text-xl font-semibold text-gray-900 mb-3">

                        Description

                    </h2>

                    <p class="text-gray-600 leading-relaxed">

                        <?= nl2br(
                            htmlspecialchars(
                                $lieu->getLieuDescription()
                            )
                        ) ?>

                    </p>

                </div>


                <!-- Téléphone -->

                <?php if (!empty($lieu->getLieuTelephone())): ?>

                    <div class="mt-6 flex items-center gap-2 text-gray-600">

                        <i data-lucide="phone" class="w-5 h-5"></i>

                        <span>

                            <?= htmlspecialchars(
                                $lieu->getLieuTelephone()
                            ) ?>

                        </span>

                    </div>

                <?php endif; ?>


                <!-- LIKE -->

                <div class="mt-8 pt-6 border-t">

                    <form method="post" action="index.php?controller=like&action=toggle" class="inline-flex">

                        <input type="hidden" name="id_lieu" value="<?= $lieu->getLieuId() ?>">

                        <input type="hidden" name="redirect" value="show">

                        <?php if ($userId !== null): ?>

                            <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-xl border transition
                                <?= $userLike
                                    ? 'bg-red-50 border-red-200 text-red-600'
                                    : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50'
                                    ?>">

                                <i data-lucide="heart" class="w-5 h-5 <?= $userLike ? 'fill-current' : '' ?>"></i>

                                <span>
                                    <?= $nombreLikes ?>
                                </span>

                            </button>

                        <?php else: ?>

                            <div class="flex items-center gap-2 text-gray-500">

                                <i data-lucide="heart" class="w-5 h-5"></i>

                                <span>
                                    <?= $nombreLikes ?>
                                </span>

                            </div>

                        <?php endif; ?>

                    </form>

                </div>

            </div>

        </div>


        <!-- RÉSERVATION -->

        <div class="mt-8 bg-white rounded-2xl shadow-sm border p-8">

            <div class="flex items-center gap-3 mb-6">

                <div class="p-3 bg-gray-100 rounded-xl">

                    <i data-lucide="calendar-days" class="w-6 h-6 text-gray-700"></i>

                </div>

                <div>

                    <h2 class="text-xl font-semibold text-gray-900">

                        Réserver ce lieu

                    </h2>

                    <p class="text-sm text-gray-500">

                        Choisissez vos dates de réservation.

                    </p>

                </div>

            </div>


            <?php if ($userId !== null): ?>

                <a href="index.php?controller=reservation&action=create&id_lieu=<?= $lieu->getLieuId() ?>"
                    class="inline-flex items-center gap-2 bg-gray-900 text-white px-5 py-3 rounded-xl hover:bg-gray-800 transition">

                    <i data-lucide="calendar-plus" class="w-5 h-5"></i>

                    Réserver ce lieu

                </a>

            <?php else: ?>

                <a href="index.php?controller=user&action=login"
                    class="inline-flex items-center gap-2 bg-gray-900 text-white px-5 py-3 rounded-xl hover:bg-gray-800 transition">

                    <i data-lucide="log-in" class="w-5 h-5"></i>

                    Connectez-vous pour réserver

                </a>

            <?php endif; ?>

        </div>


        <!-- COMMENTAIRES -->

        <div class="mt-8 bg-white rounded-2xl shadow-sm border p-8">

            <div class="flex items-center justify-between mb-8">

                <div>

                    <h2 class="text-2xl font-bold text-gray-900">

                        Avis des utilisateurs

                    </h2>

                    <p class="text-gray-500 mt-1">

                        Découvrez les avis laissés sur ce lieu.

                    </p>

                </div>

                <div class="flex items-center gap-2 text-gray-500">

                    <i data-lucide="message-square" class="w-5 h-5"></i>

                    <span>

                        <?= count($commentaires) ?>

                        avis

                    </span>

                </div>

            </div>


            <!-- Liste des commentaires -->

            <?php if (!empty($commentaires)): ?>

                <div class="space-y-6">

                    <?php foreach ($commentaires as $commentaire): ?>

                        <div class="border rounded-xl p-6">

                            <!-- Informations du commentaire -->

                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">

                                <div>

                                    <p class="font-semibold text-gray-900">

                                        <?= htmlspecialchars(
                                            $commentaire->getUserPrenom()
                                        ) ?>

                                        <?= htmlspecialchars(
                                            substr(
                                                $commentaire->getUserNom(),
                                                0,
                                                1
                                            )
                                        ) ?>.

                                    </p>

                                    <p class="text-sm text-gray-500 mt-1">

                                        <?= $commentaire
                                            ->getCommenterCreatedAt()
                                            ->format('d/m/Y à H:i')
                                            ?>

                                    </p>

                                </div>


                                <!-- Note -->

                                <div class="flex items-center gap-1">

                                    <?php for ($i = 1; $i <= 5; $i++): ?>

                                        <i data-lucide="star" class="w-5 h-5
                                            <?= $i <= $commentaire->getNote()
                                                ? 'fill-current text-yellow-400'
                                                : 'text-gray-300'
                                                ?>"></i>

                                    <?php endfor; ?>

                                    <span class="ml-2 text-sm font-medium text-gray-600">

                                        <?= $commentaire->getNote() ?>/5

                                    </span>

                                </div>

                            </div>


                            <!-- Contenu du commentaire -->

                            <p class="mt-5 text-gray-700 leading-relaxed">

                                <?= nl2br(
                                    htmlspecialchars(
                                        $commentaire->getCommenterContenu()
                                    )
                                ) ?>

                            </p>


                            <!-- Actions du commentaire -->

                            <?php if (
                                $userId !== null
                                && (int) $userId === $commentaire->getUserId()
                            ): ?>

                                <div class="mt-6 pt-5 border-t">

                                    <!-- Modifier son commentaire -->

                                    <form method="post" action="index.php?controller=commenter&action=update" class="space-y-4">

                                        <input type="hidden" name="id_lieu" value="<?= $lieu->getLieuId() ?>">

                                        <input type="hidden" name="note" value="<?= $commentaire->getNote() ?>" class="note-input">


                                        <!-- Modifier la note -->

                                        <div>

                                            <p class="text-sm font-medium text-gray-700 mb-2">

                                                Modifier votre note :

                                            </p>

                                            <div class="flex items-center gap-1">

                                                <?php for ($i = 1; $i <= 5; $i++): ?>

                                                    <button type="button" class="note-button p-1" data-note="<?= $i ?>"
                                                        data-target="<?= $commentaire->getUserId() ?>-<?= $commentaire->getLieuId() ?>"
                                                        aria-label="Donner <?= $i ?> étoile<?= $i > 1 ? 's' : '' ?>">

                                                        <i data-lucide="star" class="w-6 h-6 transition
                                                            <?= $i <= $commentaire->getNote()
                                                                ? 'fill-current text-yellow-400'
                                                                : 'text-gray-300'
                                                                ?>"></i>

                                                    </button>

                                                <?php endfor; ?>

                                            </div>

                                        </div>


                                        <!-- Modifier le commentaire -->

                                        <textarea name="commentaire" rows="4" required
                                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-300"><?= htmlspecialchars(
                                                $commentaire->getCommenterContenu()
                                            ) ?></textarea>


                                        <button type="submit"
                                            class="inline-flex items-center gap-2 bg-gray-900 text-white px-5 py-2.5 rounded-xl hover:bg-gray-800 transition">

                                            <i data-lucide="save" class="w-4 h-4"></i>

                                            Modifier

                                        </button>

                                    </form>


                                    <!-- Supprimer son commentaire -->

                                    <form method="post" action="index.php?controller=commenter&action=delete" class="mt-3"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer votre commentaire ?');">

                                        <input type="hidden" name="id_lieu" value="<?= $lieu->getLieuId() ?>">

                                        <input type="hidden" name="id_user" value="<?= $commentaire->getUserId() ?>">

                                        <button type="submit"
                                            class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 transition">

                                            <i data-lucide="trash-2" class="w-4 h-4"></i>

                                            Supprimer

                                        </button>

                                    </form>

                                </div>


                            <?php elseif ($isAdmin): ?>

                                <!-- Suppression admin -->

                                <div class="mt-6 pt-5 border-t">

                                    <form method="post" action="index.php?controller=commenter&action=delete"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer ce commentaire ?');">

                                        <input type="hidden" name="id_lieu" value="<?= $lieu->getLieuId() ?>">

                                        <input type="hidden" name="id_user" value="<?= $commentaire->getUserId() ?>">

                                        <button type="submit"
                                            class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 transition">

                                            <i data-lucide="trash-2" class="w-4 h-4"></i>

                                            Supprimer

                                        </button>

                                    </form>

                                </div>

                            <?php endif; ?>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php else: ?>

                <div class="text-center py-10 text-gray-500">

                    <i data-lucide="message-circle" class="w-10 h-10 mx-auto mb-3"></i>

                    <p>
                        Aucun avis pour le moment.
                    </p>

                </div>

            <?php endif; ?>


            <!-- Ajouter un commentaire -->

            <?php if ($userId !== null): ?>

                <div class="mt-10 pt-8 border-t">

                    <h3 class="text-xl font-semibold text-gray-900 mb-6">

                        Laisser un avis

                    </h3>


                    <form method="post" action="index.php?controller=commenter&action=store" class="space-y-5">

                        <input type="hidden" name="id_lieu" value="<?= $lieu->getLieuId() ?>">

                        <input type="hidden" name="note" id="note" value="5">


                        <!-- Note -->

                        <div id="note-container">

                            <div class="flex items-center gap-2 mb-2">

                                <p class="text-sm font-medium text-gray-700">

                                    Votre note :

                                </p>

                                <span id="note-value" class="font-semibold text-gray-900">
                                    5
                                </span>

                                <span class="text-gray-500">
                                    /5
                                </span>

                            </div>


                            <div class="flex items-center gap-1">

                                <?php for ($i = 1; $i <= 5; $i++): ?>

                                    <button type="button" class="note-button p-1" data-note="<?= $i ?>"
                                        aria-label="Donner <?= $i ?> étoile<?= $i > 1 ? 's' : '' ?>">

                                        <i data-lucide="star" class="w-7 h-7 transition
                                            <?= $i <= 5
                                                ? 'fill-current text-yellow-400'
                                                : 'text-gray-300'
                                                ?>"></i>

                                    </button>

                                <?php endfor; ?>

                            </div>

                        </div>


                        <!-- Commentaire -->

                        <div>

                            <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-2">

                                Votre commentaire

                            </label>

                            <textarea id="commentaire" name="commentaire" rows="5" required
                                placeholder="Partagez votre expérience..."
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-300"></textarea>

                        </div>


                        <!-- Bouton -->

                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-gray-900 text-white px-6 py-3 rounded-xl hover:bg-gray-800 transition">

                            <i data-lucide="send" class="w-5 h-5"></i>

                            Publier mon avis

                        </button>

                    </form>

                </div>

            <?php else: ?>

                <div class="mt-10 pt-8 border-t text-center">

                    <p class="text-gray-500 mb-4">

                        Connectez-vous pour laisser un avis.

                    </p>

                    <a href="index.php?controller=user&action=login"
                        class="inline-flex items-center gap-2 bg-gray-900 text-white px-5 py-3 rounded-xl hover:bg-gray-800 transition">

                        <i data-lucide="log-in" class="w-5 h-5"></i>

                        Se connecter

                    </a>

                </div>

            <?php endif; ?>

        </div>

    </main>


    <!-- Lucide -->

    <script>
        lucide.createIcons();
    </script>

    <!-- JavaScript commentaires -->

    <script src="public/JS/commentaires/App.js"></script>

</body>

</html>