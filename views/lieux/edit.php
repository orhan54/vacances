<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Modifier le lieu</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100 text-gray-800">

    <!-- En-tête -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-5 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Modifier un lieu
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Modifiez les informations du lieu sélectionné.
                </p>
            </div>

            <a href="index.php?controller=lieu&action=index" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300
                       text-gray-700 bg-white hover:bg-gray-50 transition">
                ← Retour aux lieux
            </a>
        </div>
    </header>


    <!-- Contenu -->
    <main class="max-w-4xl mx-auto px-6 py-10">

        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

            <!-- Titre de la carte -->
            <div class="px-8 py-6 border-b border-gray-200 bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-900">
                    Informations du lieu
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Mettez à jour les informations puis validez les modifications.
                </p>
            </div>


            <!-- Formulaire -->
            <form action="index.php?controller=lieu&action=update" method="post" class="p-8 space-y-6">

                <!-- Identifiant -->
                <input type="hidden" name="id" value="<?= htmlspecialchars((string) $lieu->getLieuId()) ?>">


                <!-- Nom -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom du lieu
                    </label>

                    <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($lieu->getLieuNom()) ?>" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300
                               focus:outline-none focus:ring-2 focus:ring-indigo-500
                               focus:border-indigo-500 transition">
                </div>


                <!-- Adresse + CP -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="md:col-span-2">
                        <label for="adresse" class="block text-sm font-medium text-gray-700 mb-2">
                            Adresse
                        </label>

                        <input type="text" id="adresse" name="adresse"
                            value="<?= htmlspecialchars($lieu->getLieuAdresse()) ?>" required class="w-full px-4 py-3 rounded-lg border border-gray-300
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   focus:border-indigo-500 transition">
                    </div>

                    <div>
                        <label for="cp" class="block text-sm font-medium text-gray-700 mb-2">
                            Code postal
                        </label>

                        <input type="text" id="cp" name="cp" value="<?= htmlspecialchars($lieu->getLieuCp()) ?>"
                            required class="w-full px-4 py-3 rounded-lg border border-gray-300
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   focus:border-indigo-500 transition">
                    </div>

                </div>


                <!-- Téléphone -->
                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                        Téléphone
                    </label>

                    <input type="text" id="telephone" name="telephone"
                        value="<?= htmlspecialchars($lieu->getLieuTelephone()) ?>" required class="w-full px-4 py-3 rounded-lg border border-gray-300
                               focus:outline-none focus:ring-2 focus:ring-indigo-500
                               focus:border-indigo-500 transition">
                </div>


                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>

                    <textarea id="description" name="description" rows="5" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300
                               focus:outline-none focus:ring-2 focus:ring-indigo-500
                               focus:border-indigo-500 transition resize-y"><?= htmlspecialchars($lieu->getLieuDescription()) ?></textarea>
                </div>


                <!-- Prix -->
                <div>
                    <label for="prix" class="block text-sm font-medium text-gray-700 mb-2">
                        Prix
                    </label>

                    <div class="relative">
                        <input type="number" id="prix" name="prix" step="0.01" min="0"
                            value="<?= htmlspecialchars((string) $lieu->getLieuPrix()) ?>" required class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-300
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   focus:border-indigo-500 transition">

                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                            €
                        </span>
                    </div>
                </div>


                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Image du lieu
                    </label>

                    <input type="text" id="image" name="image" value="<?= htmlspecialchars($lieu->getLieuImage()) ?>"
                        placeholder="exemple.jpg" class="w-full px-4 py-3 rounded-lg border border-gray-300
                               focus:outline-none focus:ring-2 focus:ring-indigo-500
                               focus:border-indigo-500 transition">

                    <p class="mt-2 text-sm text-gray-500">
                        Indiquez le nom de l'image présente dans le dossier
                        <span class="font-medium text-gray-700">public/images/</span>.
                    </p>
                </div>


                <!-- Aperçu image -->
                <?php if (!empty($lieu->getLieuImage())): ?>

                    <div class="border border-gray-200 rounded-xl p-5 bg-gray-50">

                        <h3 class="text-sm font-semibold text-gray-700 mb-3">
                            Image actuelle
                        </h3>

                        <div class="flex justify-center">

                            <img src="<?= htmlspecialchars($lieu->getLieuImage()) ?>"
                                alt="<?= htmlspecialchars($lieu->getLieuNom()) ?>"
                                class="max-h-64 w-auto rounded-lg shadow-md object-cover">

                        </div>

                    </div>

                <?php endif; ?>


                <!-- Séparateur -->
                <div class="border-t border-gray-200 pt-6"></div>


                <!-- Boutons -->
                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

                    <a href="index.php?controller=lieu&action=index" class="px-6 py-3 rounded-lg border border-gray-300
                               text-gray-700 bg-white text-center
                               hover:bg-gray-50 transition">
                        Annuler
                    </a>

                    <button type="submit" class="px-6 py-3 rounded-lg bg-indigo-600 text-white
                               font-medium hover:bg-indigo-700
                               focus:outline-none focus:ring-2 focus:ring-indigo-500
                               transition shadow-sm">
                        Enregistrer les modifications
                    </button>

                </div>

            </form>

        </div>

    </main>

</body>

</html>