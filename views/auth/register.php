<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Vacances</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-indigo-100 via-white to-purple-100 flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-2xl">

        <!-- Logo / titre -->
        <div class="text-center mb-8">

            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600 shadow-lg mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3
                             M12 14a4 4 0 100-8 4 4 0 000 8z
                             M4 20a8 8 0 0116 0" />
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-800">
                Créer votre compte
            </h1>

            <p class="text-gray-500 mt-2">
                Rejoignez-nous et profitez de toutes les fonctionnalités
            </p>

        </div>

        <!-- Carte inscription -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">

            <form action="index.php?controller=user&action=store" method="post" class="space-y-6">

                <!-- Prénom / Nom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">
                            Prénom
                        </label>

                        <input type="text" id="prenom" name="prenom" required autocomplete="given-name"
                            placeholder="Votre prénom" class="w-full px-4 py-3 border border-gray-300 rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   focus:border-indigo-500 transition duration-200
                                   text-gray-800 placeholder-gray-400">
                    </div>

                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom
                        </label>

                        <input type="text" id="nom" name="nom" required autocomplete="family-name"
                            placeholder="Votre nom" class="w-full px-4 py-3 border border-gray-300 rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   focus:border-indigo-500 transition duration-200
                                   text-gray-800 placeholder-gray-400">
                    </div>

                </div>

                <!-- Adresse -->
                <div>
                    <label for="adresse" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse
                    </label>

                    <input type="text" id="adresse" name="adresse" required autocomplete="street-address"
                        placeholder="Ex : 12 rue des Fleurs" class="w-full px-4 py-3 border border-gray-300 rounded-xl
                               focus:outline-none focus:ring-2 focus:ring-indigo-500
                               focus:border-indigo-500 transition duration-200
                               text-gray-800 placeholder-gray-400">
                </div>

                <!-- Code postal / Téléphone -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label for="cp" class="block text-sm font-medium text-gray-700 mb-2">
                            Code postal
                        </label>

                        <input type="text" id="cp" name="cp" required inputmode="numeric" autocomplete="postal-code"
                            placeholder="54000" class="w-full px-4 py-3 border border-gray-300 rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   focus:border-indigo-500 transition duration-200
                                   text-gray-800 placeholder-gray-400">
                    </div>

                    <div>
                        <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                            Téléphone
                        </label>

                        <input type="tel" id="telephone" name="telephone" required autocomplete="tel"
                            placeholder="06 12 34 56 78" class="w-full px-4 py-3 border border-gray-300 rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   focus:border-indigo-500 transition duration-200
                                   text-gray-800 placeholder-gray-400">
                    </div>

                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse email
                    </label>

                    <input type="email" id="email" name="email" required autocomplete="email"
                        placeholder="exemple@email.com" class="w-full px-4 py-3 border border-gray-300 rounded-xl
                               focus:outline-none focus:ring-2 focus:ring-indigo-500
                               focus:border-indigo-500 transition duration-200
                               text-gray-800 placeholder-gray-400">
                </div>

                <!-- Mot de passe / Confirmation -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label for="mp" class="block text-sm font-medium text-gray-700 mb-2">
                            Mot de passe
                        </label>

                        <input type="password" id="mp" name="mp" required autocomplete="new-password"
                            placeholder="Votre mot de passe" class="w-full px-4 py-3 border border-gray-300 rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   focus:border-indigo-500 transition duration-200
                                   text-gray-800 placeholder-gray-400">
                    </div>

                    <div>
                        <label for="mp_confirm" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmer le mot de passe
                        </label>

                        <input type="password" id="mp_confirm" name="mp_confirm" required autocomplete="new-password"
                            placeholder="Confirmez votre mot de passe" class="w-full px-4 py-3 border border-gray-300 rounded-xl
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

                    Créer mon compte
                </button>

            </form>

            <!-- Séparation -->
            <div class="relative my-6">

                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>

                <div class="relative flex justify-center">
                    <span class="bg-white px-4 text-sm text-gray-400">
                        Vous avez déjà un compte ?
                    </span>
                </div>

            </div>

            <!-- Connexion -->
            <a href="index.php?controller=user&action=login" class="block w-full text-center border-2 border-indigo-600
                      text-indigo-600 hover:bg-indigo-600 hover:text-white
                      font-semibold py-3 px-4 rounded-xl
                      transition-all duration-200">
                Se connecter
            </a>

        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-400 mt-6">
            © 2026 Vacances — Tous droits réservés
        </p>

    </div>

</body>

</html>