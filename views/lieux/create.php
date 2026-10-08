<?php

require_once __DIR__ . '/../../middleware/Auth.php';

// Double sécurité côté vue.
// Le contrôleur protège déjà cette page avec Auth::exigerAdmin().
Auth::exigerAdmin();

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administration - Créer un lieu</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body class="bg-gray-50 text-gray-900 min-h-screen">

    <!-- HEADER ADMIN -->

    <header class="bg-gray-900 text-white">

        <div class="max-w-5xl mx-auto px-6 py-5">

            <div class="flex items-center justify-between">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">

                        <i data-lucide="shield-check" class="w-5 h-5"></i>

                    </div>

                    <div>

                        <p class="text-xs uppercase tracking-wider text-gray-400">
                            Administration
                        </p>

                        <h1 class="text-xl font-semibold">
                            Gestion des lieux
                        </h1>

                    </div>

                </div>


                <a href="index.php?controller=lieu&action=index"
                    class="inline-flex items-center gap-2 text-gray-300 hover:text-white transition">

                    <i data-lucide="arrow-left" class="w-5 h-5"></i>

                    Retour aux lieux

                </a>

            </div>

        </div>

    </header>


    <!-- CONTENU -->

    <main class="max-w-5xl mx-auto px-6 py-10">

        <!-- TITRE -->

        <div class="mb-8">

            <div class="flex items-center gap-3 mb-2">

                <div class="w-10 h-10 rounded-xl bg-gray-900 text-white flex items-center justify-center">

                    <i data-lucide="plus" class="w-5 h-5"></i>

                </div>

                <h2 class="text-3xl font-bold">
                    Créer un lieu
                </h2>

            </div>

            <p class="text-gray-500">
                Ajoutez un nouveau lieu à la plateforme.
            </p>

        </div>


        <!-- FORMULAIRE -->

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">

            <form action="index.php?controller=lieu&action=store" method="post" enctype="multipart/form-data"
                class="space-y-6">

                <!-- NOM -->

                <div>

                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom du lieu
                    </label>

                    <div class="relative">

                        <i data-lucide="building-2"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>

                        <input type="text" id="nom" name="nom" required placeholder="Ex. Château de Nancy"
                            class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">

                    </div>

                </div>


                <!-- ADRESSE -->

                <div>

                    <label for="adresse" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse
                    </label>

                    <div class="relative">

                        <i data-lucide="map-pin"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>

                        <input type="text" id="adresse" name="adresse" required placeholder="Ex. 1 Place Stanislas"
                            class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">

                    </div>

                </div>


                <!-- CODE POSTAL -->

                <div>

                    <label for="cp" class="block text-sm font-medium text-gray-700 mb-2">
                        Code postal
                    </label>

                    <div class="relative">

                        <i data-lucide="map" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>

                        <input type="text" id="cp" name="cp" required placeholder="Ex. 54000"
                            class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">

                    </div>

                </div>


                <!-- TELEPHONE -->

                <div>

                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                        Téléphone
                    </label>

                    <div class="relative">

                        <i data-lucide="phone"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>

                        <input type="text" id="telephone" name="telephone" required placeholder="Ex. 03 83 00 00 00"
                            class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">

                    </div>

                </div>


                <!-- DESCRIPTION -->

                <div>

                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>

                    <div class="relative">

                        <i data-lucide="file-text" class="absolute left-3 top-3 w-5 h-5 text-gray-400"></i>

                        <textarea id="description" name="description" rows="6" required
                            placeholder="Décrivez le lieu..."
                            class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent resize-y"></textarea>

                    </div>

                </div>


                <!-- PRIX -->

                <div>

                    <label for="prix" class="block text-sm font-medium text-gray-700 mb-2">
                        Prix
                    </label>

                    <div class="relative">

                        <i data-lucide="euro"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>

                        <input type="text" id="prix" name="prix" required placeholder="Ex. 150"
                            class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">

                    </div>

                </div>


                <!-- IMAGE -->

                <div>

                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Image du lieu
                    </label>

                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 hover:border-gray-500 transition">

                        <div class="flex flex-col items-center justify-center text-center">

                            <i data-lucide="image-plus" class="w-10 h-10 text-gray-400 mb-3"></i>

                            <p class="font-medium text-gray-700">
                                Ajouter une image
                            </p>

                            <p class="text-sm text-gray-500 mt-1 mb-4">
                                JPG, PNG ou WEBP — 5 Mo maximum
                            </p>

                            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" required
                                class="block w-full max-w-md text-sm text-gray-600
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-lg file:border-0
                                file:bg-gray-900 file:text-white
                                hover:file:bg-gray-800">

                        </div>

                    </div>

                </div>


                <!-- ACTIONS -->

                <div class="flex flex-col sm:flex-row gap-3 pt-4">

                    <a href="index.php?controller=lieu&action=index"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-gray-300 hover:bg-gray-100 transition">

                        <i data-lucide="x" class="w-5 h-5"></i>

                        Annuler

                    </a>


                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-gray-900 text-white hover:bg-gray-800 transition">

                        <i data-lucide="plus" class="w-5 h-5"></i>

                        Créer le lieu

                    </button>

                </div>

            </form>

        </div>

    </main>


    <!-- LUCIDE -->

    <script>
        lucide.createIcons();
    </script>

</body>

</html>