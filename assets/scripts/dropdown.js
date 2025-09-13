// Dropdown

document.querySelectorAll(".custom-select").forEach(function (select) {
  const label = select.querySelector(".custom-select__label");
  const options = select.querySelector(".custom-select__options");
  const hiddenInput = select.querySelector('input[type="hidden"]');
  let currentValue = hiddenInput.value;

  // Ouvre/ferme la liste
  label.addEventListener("click", function (e) {
    e.stopPropagation();
    document
      .querySelectorAll(".custom-select.open")
      .forEach(function (openSelect) {
        if (openSelect !== select) openSelect.classList.remove("open");
      });
    select.classList.toggle("open");
  });

  // Sélection d'une option
  options.querySelectorAll("li").forEach(function (li) {
    li.addEventListener("click", function (e) {
      e.stopPropagation();
      options.querySelectorAll("li").forEach(function (el) {
        el.classList.remove("selected");
      });
      li.classList.add("selected");
      label.textContent = li.textContent;
      label.classList.add("selected");
      hiddenInput.value = li.getAttribute("data-value");
      select.classList.remove("open");
    });
    // Marquer l'option sélectionnée au chargement
    if (li.getAttribute("data-value") === currentValue) {
      li.classList.add("selected");
      label.textContent = li.textContent;
      label.classList.add("selected");
    }
  });
});

// Fermer si clic en dehors
document.addEventListener("click", function () {
  document.querySelectorAll(".custom-select.open").forEach(function (select) {
    select.classList.remove("open");
  });
});
