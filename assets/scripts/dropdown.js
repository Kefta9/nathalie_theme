// délégation : un seul handler pour tous les clicks
document.addEventListener("click", (e) => {
  const li = e.target.closest(".custom-select__options li");
  if (li) {
    const select = li.closest(".custom-select");
    const hidden = select.querySelector('input[type="hidden"]');
    const label = select.querySelector(".custom-select__label");
    select
      .querySelectorAll("li")
      .forEach((el) => el.classList.remove("selected"));
    li.classList.add("selected");
    hidden.value = li.dataset.value;
    hidden.dispatchEvent(new Event("change")); // Previent le filters.js qui executera loadPhotos(true);
    label.textContent = li.textContent;
    select.classList.remove("open");
    return;
  }
  // ouvrir/fermer labels
  const label = e.target.closest(".custom-select__label");
  if (label) {
    const select = label.closest(".custom-select");
    document.querySelectorAll(".custom-select.open").forEach((s) => { // fermer les autres
      if (s !== select) s.classList.remove("open");
    });
    select.classList.toggle("open");
    return;
  }
  // clic en dehors -> fermer tout
  document
    .querySelectorAll(".custom-select.open")
    .forEach((s) => s.classList.remove("open"));
});
