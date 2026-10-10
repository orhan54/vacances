<?php

require_once 'middleware/Csrf.php';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Vacances</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-indigo-100 via-white to-purple-100 flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        <!-- Logo / titre -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600 shadow-lg mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-800">
                Bon retour !
            </h1>

            <p class="text-gray-500 mt-2">
                Connectez-vous à votre compte
            </p>
        </div>

        <!-- Carte connexion -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">

            <form action="index.php?controller=user&action=authenticate" method="post" class="space-y-6">

                <input type="hidden" name="csrf_token"
                    value="<?= htmlspecialchars(Csrf::getToken(), ENT_QUOTES, 'UTF-8') ?>">

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse email
                    </label>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1a3 3 0 006 0v-1a10 10 0 10-20 0v1a3 3 0 006 0v-1" />
                            </svg>
                        </div>

                        <input type="email" id="email" name="email" required autocomplete="email"
                            placeholder="exemple@email.com" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   focus:border-indigo-500 transition duration-200
                                   text-gray-800 placeholder-gray-400">
                    </div>
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="mp" class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe
                    </label>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>

                        <input type="password" id="mp" name="mp" required autocomplete="current-password"
                            placeholder="Votre mot de passe" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   focus:border-indigo-500 transition duration-200
                                   text-gray-800 placeholder-gray-400">
                    </div>
                </div>

                <!-- Bouton -->
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700
                           text-white font-semibold py-3 px-4 rounded-xl
                           shadow-md hover:shadow-lg
                           transition-all duration-200
                           focus:outline-none focus:ring-2
                           focus:ring-indigo-500 focus:ring-offset-2">

                    Se connecter
                </button>

            </form>

            <!-- Séparation -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>

                <div class="relative flex justify-center">
                    <span class="bg-white px-4 text-sm text-gray-400">
                        Nouveau sur Vacances ?
                    </span>
                </div>
            </div>

            <!-- Inscription -->
            <a href="index.php?controller=user&action=register" class="block w-full text-center border-2 border-indigo-600
                      text-indigo-600 hover:bg-indigo-600 hover:text-white
                      font-semibold py-3 px-4 rounded-xl
                      transition-all duration-200">
                Créer un compte
            </a>

        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-400 mt-6">
            © 2026 Vacances — Tous droits réservés
        </p>

    </div>

</body>

</html>