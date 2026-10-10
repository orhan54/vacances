<?php

require_once __DIR__ . '/../../middleware/Csrf.php';

$lieu = $lieu ?? null;
$reservations = $reservations ?? [];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Réserver un lieu</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-gray-100">

    <!-- Header -->
    <header class="bg-indigo-950 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-6 py-5 flex items-center justify-between">

            <a href="index.php?controller=lieu&action=index"
                class="flex items-center gap-2 text-indigo-100 hover:text-white transition">

                <i data-lucide="arrow-left" class="w-5 h-5"></i>

                <span>Retour aux lieux</span>

            </a>

            <div class="flex items-center gap-2">
                <i data-lucide="calendar-check" class="w-6 h-6 text-amber-300"></i>

                <span class="font-semibold">
                    Réservation
                </span>
            </div>

        </div>
    </header>


    <?php if ($lieu !== null): ?>

        <main class="max-w-4xl mx-auto px-4 sm:px-6 py-10">

            <!-- Titre -->
            <div class="text-center mb-8">

                <p class="text-indigo-600 font-semibold uppercase tracking-wider text-sm mb-2">
                    Nouvelle réservation
                </p>

                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">
                    Réserver ce lieu
                </h1>

                <p class="mt-3 text-gray-600">
                    Choisissez vos dates pour effectuer votre réservation.
                </p>

            </div>


            <!-- Carte principale -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">

                <!-- Informations du lieu -->
                <div class="bg-gradient-to-r from-indigo-950 to-indigo-800 text-white p-7 sm:p-8">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">

                        <div>

                            <div class="flex items-center gap-2 text-indigo-200 text-sm mb-2">

                                <i data-lucide="map-pin" class="w-4 h-4"></i>

                                <span>Lieu sélectionné</span>

                            </div>

                            <h2 class="text-2xl sm:text-3xl font-bold">
                                <?= htmlspecialchars($lieu->getLieuNom()) ?>
                            </h2>

                            <p class="mt-2 text-indigo-200">
                                <?= htmlspecialchars($lieu->getLieuAdresse()) ?>
                            </p>

                        </div>

                        <div class="hidden sm:flex w-16 h-16 rounded-2xl bg-white/10 items-center justify-center">

                            <i data-lucide="calendar-days" class="w-8 h-8 text-amber-300"></i>

                        </div>

                    </div>

                </div>


                <!-- Formulaire -->
                <div class="p-6 sm:p-8">

                    <form method="POST" action="index.php?controller=reservation&action=store" class="space-y-7">
                        <input type="hidden" name="csrf_token"
                            value="<?= htmlspecialchars(Csrf::getToken(), ENT_QUOTES, 'UTF-8') ?>">

                        <input type="hidden" name="id_lieu" value="<?= htmlspecialchars((string) $lieu->getLieuId()) ?>">


                        <!-- Dates -->
                        <div>

                            <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                Choisissez vos dates
                            </h3>

                            <p class="text-sm text-gray-500 mb-5">
                                Sélectionnez une date de début et une date de fin.
                            </p>


                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <!-- Date début -->
                                <div>

                                    <label for="reservation_date_debut"
                                        class="block text-sm font-semibold text-gray-700 mb-2">

                                        Date de début

                                    </label>

                                    <div class="relative">

                                        <i data-lucide="calendar"
                                            class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-indigo-500 pointer-events-none">
                                        </i>

                                        <input type="text" id="reservation_date_debut" name="reservation_date_debut"
                                            placeholder="Choisir une date" autocomplete="off" required
                                            class="w-full pl-12 pr-4 py-3.5 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">

                                    </div>

                                </div>


                                <!-- Date fin -->
                                <div>

                                    <label for="reservation_date_fin"
                                        class="block text-sm font-semibold text-gray-700 mb-2">

                                        Date de fin

                                    </label>

                                    <div class="relative">

                                        <i data-lucide="calendar-check"
                                            class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-indigo-500 pointer-events-none">
                                        </i>

                                        <input type="text" id="reservation_date_fin" name="reservation_date_fin"
                                            placeholder="Choisir une date" autocomplete="off" required
                                            class="w-full pl-12 pr-4 py-3.5 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- Information -->
                        <div class="flex gap-3 p-4 rounded-xl bg-indigo-50 border border-indigo-100">

                            <i data-lucide="info" class="w-5 h-5 text-indigo-600 flex-shrink-0 mt-0.5">
                            </i>

                            <p class="text-sm text-indigo-900">
                                Les dates déjà réservées ne pourront pas être sélectionnées.
                                Vérifiez vos dates avant de confirmer.
                            </p>

                        </div>


                        <!-- Boutons -->
                        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-2">

                            <a href="index.php?controller=lieu&action=show&id=<?= $lieu->getLieuId() ?>"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl border border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition">

                                <i data-lucide="arrow-left" class="w-5 h-5"></i>

                                Annuler

                            </a>


                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-0.5 transition">

                                <i data-lucide="calendar-check" class="w-5 h-5"></i>

                                Confirmer la réservation

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </main>

    <?php else: ?>

        <!-- Erreur -->
        <main class="min-h-[70vh] flex items-center justify-center px-4">

            <div class="text-center bg-white rounded-3xl shadow-xl p-10 max-w-md w-full">

                <div class="w-16 h-16 mx-auto mb-5 rounded-full bg-red-100 flex items-center justify-center">

                    <i data-lucide="map-pin-off" class="w-8 h-8 text-red-500"></i>

                </div>

                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                    Lieu introuvable
                </h1>

                <p class="text-gray-500 mb-6">
                    Le lieu que vous souhaitez réserver n'existe pas ou n'est plus disponible.
                </p>

                <a href="index.php?controller=lieu&action=index"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">

                    <i data-lucide="map" class="w-5 h-5"></i>

                    Retour aux lieux

                </a>

            </div>

        </main>

    <?php endif; ?>


    <!-- Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        window.reservations = <?= json_encode($reservations) ?>;
    </script>

    <script src="public/js/reservations/App.js"></script>

    <script>
        lucide.createIcons();
    </script>

</body>

</html>