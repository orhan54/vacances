<?php

require_once __DIR__ . '/../../middleware/Auth.php';
require_once __DIR__ . '/../../middleware/Csrf.php';

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: 0');

?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lieux</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body class="bg-gray-50 text-gray-900 min-h-screen">

    <!-- HEADER -->

    <header class="bg-white border-b border-gray-200">

        <div class="max-w-7xl mx-auto px-6 py-6">

            <div class="flex items-center justify-between">

                <div>

                    <h1 class="text-3xl font-bold">
                        Nos lieux
                    </h1>

                    <p class="text-gray-500 mt-1">
                        Découvrez nos lieux disponibles
                    </p>

                </div>

                <a href="index.php?controller=user&action=welcome"
                    class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">

                    <i data-lucide="arrow-left" class="w-5 h-5"></i>

                    Accueil

                </a>

            </div>

        </div>

    </header>


    <!-- CONTENU -->

    <main class="max-w-7xl mx-auto px-6 py-10">

        <?php if (empty($lieux)): ?>

            <!-- AUCUN LIEU -->

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-10 text-center">

                <i data-lucide="map-pin-off" class="w-12 h-12 mx-auto text-gray-400 mb-4"></i>

                <h2 class="text-xl font-semibold mb-2">
                    Aucun lieu disponible
                </h2>

                <p class="text-gray-500">
                    Aucun lieu n'est actuellement enregistré.
                </p>

            </div>

        <?php else: ?>

            <!-- GRILLE DES LIEUX -->

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <?php foreach ($lieux as $lieu): ?>

                    <?php

                    $lieuId = $lieu->getLieuId();

                    $nombreLikes = $likes[$lieuId]['count'];
                    $estLike = $likes[$lieuId]['liked'];

                    $moyenne = $ratings[$lieuId]['moyenne'] ?? null;
                    $nombreAvis = $ratings[$lieuId]['nombre'] ?? 0;

                    ?>

                    <article
                        class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-200 hover:shadow-lg transition duration-300">

                        <!-- IMAGE -->

                        <?php if (!empty($lieu->getLieuImage())): ?>

                            <div class="relative">

                                <img src="<?= htmlspecialchars($lieu->getLieuImage()) ?>"
                                    alt="<?= htmlspecialchars($lieu->getLieuNom()) ?>" class="w-full h-56 object-cover">

                                <!-- COMPTEUR LIKE -->

                                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-full px-3 py-2 shadow-sm">

                                    <div class="flex items-center gap-1.5">

                                        <i data-lucide="heart" class="w-4 h-4 <?= $estLike ? 'fill-current' : '' ?>"></i>

                                        <span class="text-sm font-medium">
                                            <?= $nombreLikes ?>
                                        </span>

                                    </div>

                                </div>

                            </div>

                        <?php else: ?>

                            <div class="w-full h-56 bg-gray-100 flex items-center justify-center">

                                <i data-lucide="image-off" class="w-12 h-12 text-gray-400"></i>

                            </div>

                        <?php endif; ?>


                        <!-- CONTENU -->

                        <div class="p-6">

                            <!-- TITRE -->

                            <h2 class="text-xl font-bold mb-2">

                                <?= htmlspecialchars($lieu->getLieuNom()) ?>

                            </h2>


                            <!-- ADRESSE -->

                            <div class="flex items-start gap-2 text-gray-500 mb-4">

                                <i data-lucide="map-pin" class="w-4 h-4 mt-1 flex-shrink-0"></i>

                                <span>
                                    <?= htmlspecialchars($lieu->getLieuAdresse()) ?>
                                </span>

                            </div>


                            <!-- DESCRIPTION -->

                            <p class="text-gray-600 text-sm leading-relaxed mb-5 line-clamp-3">
                                <?= htmlspecialchars($lieu->getLieuDescription()) ?>
                            </p>


                            <!-- PRIX -->

                            <div class="mb-5">

                                <!-- Prix -->
                                <div class="flex items-center gap-2">
                                    <i data-lucide="euro" class="w-5 h-5 text-gray-700"></i>

                                    <span class="font-semibold">
                                        <?= htmlspecialchars((string) $lieu->getLieuPrix()) ?> €
                                        <span class="text-gray-500 font-normal text-sm">/ jour</span>
                                    </span>
                                </div>

                                <!-- Note -->
                                <div class="flex items-center gap-2 mt-2 text-sm">

                                    <?php if ($moyenne !== null): ?>

                                        <i data-lucide="star" class="w-4 h-4 text-amber-400 fill-current">
                                        </i>

                                        <span class="font-semibold text-gray-800">
                                            <?= number_format($moyenne, 1, ',', ' ') ?> / 5
                                        </span>

                                        <span class="text-gray-500">
                                            · <?= $nombreAvis ?> avis
                                        </span>

                                    <?php else: ?>

                                        <i data-lucide="star" class="w-4 h-4 text-gray-400">
                                        </i>

                                        <span class="text-gray-500">
                                            Aucun avis
                                        </span>

                                    <?php endif; ?>

                                </div>

                            </div>


                            <!-- LIKE -->

                            <?php if (Auth::estConnecte()): ?>

                                <form action="index.php?controller=like&action=toggle" method="POST" class="mb-4">

                                    <input type="hidden" name="csrf_token"
                                        value="<?= htmlspecialchars(Csrf::getToken(), ENT_QUOTES, 'UTF-8') ?>">

                                    <input type="hidden" name="id_lieu" value="<?= $lieuId ?>">

                                    <input type="hidden" name="redirect" value="index">

                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 transition">

                                        <i data-lucide="heart" class="w-5 h-5 <?= $estLike ? 'fill-current' : '' ?>"></i>

                                        <span>
                                            <?= $estLike ? 'Retirer le like' : 'Liker ce lieu' ?>
                                        </span>

                                        <span>
                                            (
                                            <?= $nombreLikes ?>)
                                        </span>

                                    </button>

                                </form>

                            <?php endif; ?>


                            <!-- VOIR LE BIEN -->

                            <a href="index.php?controller=lieu&action=show&id=<?= $lieuId ?>"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gray-900 text-white hover:bg-gray-800 transition">

                                <i data-lucide="eye" class="w-5 h-5"></i>

                                Voir le bien

                            </a>


                            <!-- ADMIN -->

                            <?php if (Auth::estAdmin()): ?>

                                <div class="flex gap-3 mt-4">

                                    <!-- MODIFIER -->

                                    <a href="index.php?controller=lieu&action=edit&id=<?= $lieuId ?>"
                                        class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 transition">

                                        <i data-lucide="pencil" class="w-4 h-4"></i>

                                        Modifier

                                    </a>


                                    <!-- SUPPRIMER -->

                                    <form action="index.php?controller=lieu&action=delete" method="POST" class="flex-1">

                                        <input type="hidden" name="csrf_token"
                                            value="<?= htmlspecialchars(Csrf::getToken(), ENT_QUOTES, 'UTF-8') ?>">

                                        <input type="hidden" name="id" value="<?= $lieuId ?>">

                                        <button type="submit"
                                            class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-xl border border-red-300 text-red-600 hover:bg-red-50 transition">

                                            <i data-lucide="trash-2" class="w-4 h-4"></i>

                                            Supprimer

                                        </button>

                                    </form>

                                </div>

                            <?php endif; ?>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </main>


    <!-- LUCIDE -->

    <script>
        lucide.createIcons();

        window.addEventListener('pageshow', function (event) {

            if (event.persisted) {
                window.location.reload();
            }

        });
    </script>

</body>

</html>