<?php

require_once __DIR__ . '/../../middleware/Auth.php';
require_once __DIR__ . '/../../middleware/Csrf.php';

$isConnected = Auth::estConnecte();

$prenom = $_SESSION['user_prenom'] ?? null;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vacances - Accueil</title>

    <link rel="stylesheet" href="public/css/auth/style.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen welcome-page">

    <!-- Background -->
    <div class="welcome-background">

        <!-- Overlay sombre -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Contenu -->
        <main class="relative z-10 flex min-h-screen items-center justify-center px-6 py-12">

            <div class="w-full max-w-2xl text-center text-white">

                <!-- Titre -->
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl md:text-6xl">

                    <?php if ($isConnected && $prenom): ?>

                        Bienvenue
                        <span class="text-amber-300">
                            <?= htmlspecialchars($prenom) ?>
                        </span>

                    <?php else: ?>

                        Bienvenue
                        <span class="text-amber-300">
                            sur Vacances
                        </span>

                    <?php endif; ?>

                </h1>

                <!-- Accroche -->
                <h2 class="mt-6 text-xl font-medium sm:text-2xl md:text-3xl">
                    Prêt à trouver votre prochaine destination ?
                </h2>

                <!-- Description -->
                <p class="mx-auto mt-5 max-w-xl text-base leading-relaxed text-gray-200 sm:text-lg">
                    Découvrez nos lieux et choisissez l'endroit idéal
                    pour votre prochain séjour.
                </p>

                <!-- Boutons -->
                <div class="mx-auto mt-10 flex w-full max-w-md flex-col gap-4">

                    <!-- Découvrir les lieux -->
                    <a href="index.php?controller=lieu&action=index"
                        class="flex items-center justify-center gap-3 rounded-xl bg-amber-400 px-6 py-4 text-base font-semibold text-gray-900 shadow-lg transition duration-300 hover:-translate-y-0.5 hover:bg-amber-300 hover:shadow-xl">

                        <i data-lucide="map-pin" class="h-5 w-5"></i>

                        <span>Découvrir les lieux</span>

                    </a>


                    <?php if ($isConnected): ?>

                        <!-- Mes réservations -->
                        <a href="index.php?controller=reservation&action=index"
                            class="flex items-center justify-center gap-3 rounded-xl bg-white/15 px-6 py-4 text-base font-semibold text-white shadow-lg ring-1 ring-white/30 backdrop-blur-sm transition duration-300 hover:-translate-y-0.5 hover:bg-white/25">

                            <i data-lucide="calendar-days" class="h-5 w-5"></i>

                            <span>Mes réservations</span>

                        </a>


                        <!-- Gestion des lieux - Admin uniquement -->
                        <?php if (Auth::estAdmin()): ?>

                            <a href="index.php?controller=lieu&action=create"
                                class="flex items-center justify-center gap-3 rounded-xl bg-white/15 px-6 py-4 text-base font-semibold text-white shadow-lg ring-1 ring-white/30 backdrop-blur-sm transition duration-300 hover:-translate-y-0.5 hover:bg-white/25">

                                <i data-lucide="settings" class="h-5 w-5"></i>

                                <span>Gérer les lieux</span>

                            </a>

                        <?php endif; ?>


                        <!-- Déconnexion protégée par CSRF -->
                        <form method="POST" action="index.php?controller=user&action=logout">

                            <input type="hidden" name="csrf_token"
                                value="<?= htmlspecialchars(Csrf::getToken(), ENT_QUOTES, 'UTF-8') ?>">

                            <button type="submit"
                                class="mt-2 flex w-full items-center justify-center gap-3 rounded-xl border border-white/30 bg-black/20 px-6 py-3.5 text-sm font-medium text-gray-200 backdrop-blur-sm transition duration-300 hover:bg-red-500/80 hover:text-white">
                                <i data-lucide="log-out" class="h-5 w-5"></i>

                                <span>Se déconnecter</span>
                            </button>

                        </form>



                    <?php else: ?>

                        <!-- Connexion -->
                        <a href="index.php?controller=user&action=login"
                            class="flex items-center justify-center gap-3 rounded-xl bg-white/15 px-6 py-4 text-base font-semibold text-white shadow-lg ring-1 ring-white/30 backdrop-blur-sm transition duration-300 hover:-translate-y-0.5 hover:bg-white/25">

                            <i data-lucide="log-in" class="h-5 w-5"></i>

                            <span>Se connecter</span>

                        </a>

                    <?php endif; ?>

                </div>

            </div>

        </main>

    </div>

    <!-- Initialisation des icônes Lucide -->
    <script>
        lucide.createIcons();
    </script>

</body>

</html>