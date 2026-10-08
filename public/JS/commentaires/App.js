// Ajouter un commentaire

const noteInput = document.getElementById("note");
const noteValue = document.getElementById("note-value");
const noteContainer = document.getElementById("note-container");

if (noteContainer && noteInput && noteValue) {
  const buttons = noteContainer.querySelectorAll(".note-button");

  buttons.forEach((button) => {
    button.addEventListener("click", () => {
      const note = parseInt(button.dataset.note);

      noteInput.value = note;
      noteValue.textContent = note;

      buttons.forEach((button, index) => {
        const icon = button.querySelector("svg");

        if (!icon) {
          return;
        }

        if (index < note) {
          icon.classList.add("fill-current");
          icon.classList.remove("text-gray-300");
        } else {
          icon.classList.remove("fill-current");
          icon.classList.add("text-gray-300");
        }
      });
    });
  });
}

// Modifier un commentaire

const modificationButtons = document.querySelectorAll(
  ".note-button[data-target]",
);

modificationButtons.forEach((button) => {
  button.addEventListener("click", () => {
    const note = parseInt(button.dataset.note);

    const form = button.closest("form");

    if (!form) {
      return;
    }

    const input = form.querySelector(".note-input");

    if (!input) {
      return;
    }

    input.value = note;

    const buttons = form.querySelectorAll(".note-button");

    buttons.forEach((button, index) => {
      const icon = button.querySelector("svg");

      if (!icon) {
        return;
      }

      if (index < note) {
        icon.classList.add("fill-current");
        icon.classList.remove("text-gray-300");
      } else {
        icon.classList.remove("fill-current");
        icon.classList.add("text-gray-300");
      }
    });
  });
});
