<?php

$reservations = $reservations ?? [];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mes réservations</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-gray-100">

    <!-- Header -->
    <header class="bg-indigo-950 text-white shadow-lg">

        <div class="max-w-6xl mx-auto px-6 py-5 flex items-center justify-between">

            <a href="index.php?controller=auth&action=welcome"
                class="flex items-center gap-2 text-indigo-100 hover:text-white transition">

                <i data-lucide="arrow-left" class="w-5 h-5"></i>

                <span>Retour à l'accueil</span>

            </a>

            <div class="flex items-center gap-2">

                <i data-lucide="calendar-check" class="w-6 h-6 text-amber-300">
                </i>

                <span class="font-semibold">
                    Mes réservations
                </span>

            </div>

        </div>

    </header>


    <!-- Contenu -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-10">

        <!-- Titre -->
        <div class="text-center mb-10">

            <p class="text-indigo-600 font-semibold uppercase tracking-wider text-sm mb-2">
                Mon espace
            </p>

            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">
                Mes réservations
            </h1>

            <p class="mt-3 text-gray-600">
                Retrouvez ici toutes vos réservations et leur statut.
            </p>

        </div>


        <?php if (empty($reservations)): ?>

            <!-- Aucune réservation -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-10 sm:p-14 text-center max-w-xl mx-auto">

                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-indigo-50 flex items-center justify-center">

                    <i data-lucide="calendar-x" class="w-10 h-10 text-indigo-500">
                    </i>

                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-3">
                    Aucune réservation
                </h2>

                <p class="text-gray-500 mb-7">
                    Vous n'avez encore effectué aucune réservation.
                    Découvrez nos lieux disponibles et trouvez celui qui vous correspond.
                </p>

                <a href="index.php?controller=lieu&action=index"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-0.5 transition">

                    <i data-lucide="map-pin" class="w-5 h-5"></i>

                    Découvrir les lieux

                </a>

            </div>


        <?php else: ?>

            <!-- Nombre de réservations -->
            <div class="flex items-center gap-2 mb-6 text-gray-600">

                <i data-lucide="calendar-days" class="w-5 h-5 text-indigo-600">
                </i>

                <span>
                    <?= count($reservations) ?>
                    réservation
                    <?= count($reservations) > 1 ? 's' : '' ?>
                </span>

            </div>


            <!-- Liste des réservations -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <?php foreach ($reservations as $reservation): ?>

                    <?php
                    $status = $reservation->getReservationStatus();

                    $dateDebut = $reservation->getReservationDateDebut();
                    $dateFin = $reservation->getReservationDateFin();
                    ?>

                    <article
                        class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition">

                        <!-- En-tête carte -->
                        <div class="bg-gradient-to-r from-indigo-950 to-indigo-800 text-white p-6">

                            <div class="flex items-start justify-between gap-4">

                                <div>

                                    <div class="flex items-center gap-2 text-indigo-200 text-sm mb-2">

                                        <i data-lucide="calendar-check" class="w-4 h-4">
                                        </i>

                                        <span>
                                            Réservation
                                        </span>

                                    </div>

                                    <h2 class="text-xl font-bold">
                                        Votre réservation
                                    </h2>

                                </div>


                                <?php if ($status === 'confirmee'): ?>

                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-green-500/20 text-green-200 border border-green-400/30 text-sm font-semibold">

                                        <span class="w-2 h-2 rounded-full bg-green-400"></span>

                                        Confirmée

                                    </span>

                                <?php elseif ($status === 'annulee'): ?>

                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-500/20 text-red-200 border border-red-400/30 text-sm font-semibold">

                                        <span class="w-2 h-2 rounded-full bg-red-400"></span>

                                        Annulée

                                    </span>

                                <?php else: ?>

                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gray-500/20 text-gray-200 border border-gray-400/30 text-sm font-semibold">

                                        <?= htmlspecialchars($status) ?>

                                    </span>

                                <?php endif; ?>

                            </div>

                        </div>


                        <!-- Informations -->
                        <div class="p-6">

                            <!-- Dates -->
                            <div class="space-y-4">

                                <div class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50">

                                    <div
                                        class="w-11 h-11 rounded-xl bg-indigo-100 flex items-center justify-center flex-shrink-0">

                                        <i data-lucide="calendar-plus" class="w-5 h-5 text-indigo-600">
                                        </i>

                                    </div>

                                    <div>

                                        <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">
                                            Date de début
                                        </p>

                                        <p class="text-gray-900 font-semibold mt-1">
                                            <?= htmlspecialchars($dateDebut->format('d/m/Y')) ?>
                                        </p>

                                        <p class="text-sm text-gray-500">
                                            <?= htmlspecialchars($dateDebut->format('H:i')) ?>
                                        </p>

                                    </div>

                                </div>


                                <div class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50">

                                    <div
                                        class="w-11 h-11 rounded-xl bg-indigo-100 flex items-center justify-center flex-shrink-0">

                                        <i data-lucide="calendar-minus" class="w-5 h-5 text-indigo-600">
                                        </i>

                                    </div>

                                    <div>

                                        <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">
                                            Date de fin
                                        </p>

                                        <p class="text-gray-900 font-semibold mt-1">
                                            <?= htmlspecialchars($dateFin->format('d/m/Y')) ?>
                                        </p>

                                        <p class="text-sm text-gray-500">
                                            <?= htmlspecialchars($dateFin->format('H:i')) ?>
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <!-- ID réservation -->
                            <div class="mt-5 flex items-center justify-between text-sm">

                                <span class="text-gray-500">
                                    Réservation n°
                                </span>

                                <span class="font-semibold text-gray-700">
                                    <?= htmlspecialchars((string) $reservation->getReservationId()) ?>
                                </span>

                            </div>


                            <!-- Action -->
                            <?php if ($status === 'confirmee'): ?>

                                <div class="border-t border-gray-100 mt-6 pt-6">

                                    <form method="POST" action="index.php?controller=reservation&action=cancel"
                                        onsubmit="return confirm('Voulez-vous vraiment annuler cette réservation ?');">

                                        <input type="hidden" name="id"
                                            value="<?= htmlspecialchars((string) $reservation->getReservationId()) ?>">

                                        <button type="submit"
                                            class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-red-200 text-red-600 font-semibold hover:bg-red-50 hover:border-red-300 transition">

                                            <i data-lucide="calendar-x" class="w-5 h-5">
                                            </i>

                                            Annuler la réservation

                                        </button>

                                    </form>

                                </div>

                            <?php elseif ($status === 'annulee'): ?>

                                <div class="mt-6 p-4 rounded-xl bg-red-50 border border-red-100">

                                    <div class="flex items-center gap-3">

                                        <i data-lucide="circle-x" class="w-5 h-5 text-red-500">
                                        </i>

                                        <p class="text-sm text-red-700 font-medium">
                                            Cette réservation a été annulée.
                                        </p>

                                    </div>

                                </div>

                            <?php endif; ?>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>


            <!-- Retour aux lieux -->
            <div class="text-center mt-10">

                <a href="index.php?controller=lieu&action=index"
                    class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-800 transition">

                    <i data-lucide="map-pin" class="w-5 h-5">
                    </i>

                    Découvrir d'autres lieux

                </a>

            </div>

        <?php endif; ?>

    </main>


    <script>
        lucide.createIcons();
    </script>

</body>

</html>