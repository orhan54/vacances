// Récupération des réservations envoyées par PHP
const reservations = window.reservations || [];

// Tableau contenant les périodes indisponibles
const datesIndisponibles = [];

reservations.forEach((reservation) => {
  const debut = reservation.reservation_date_debut.split(" ")[0];
  const fin = reservation.reservation_date_fin.split(" ")[0];

  datesIndisponibles.push({
    from: debut,
    to: fin,
  });
});

// Configuration du calendrier
flatpickr("#reservation_date_debut", {
  dateFormat: "Y-m-d",
  minDate: "today",
  disable: datesIndisponibles,
});

flatpickr("#reservation_date_fin", {
  dateFormat: "Y-m-d",
  minDate: "today",
  disable: datesIndisponibles,
});
