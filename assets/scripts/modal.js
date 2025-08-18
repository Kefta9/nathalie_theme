// Gestion ouverture/fermeture de la modale contact
const contactLinks = document.querySelectorAll('a[href="#modal-contact"]');
const modal = document.getElementById("modal-contact");
const overlay = modal;

contactLinks.forEach((link) => {
  link.addEventListener("click", function (e) {
    e.preventDefault();
    if (modal) {
      modal.setAttribute("aria-hidden", "false");
      modal.style.display = "flex";
    }
  });
});

if (overlay) {
  overlay.addEventListener("click", function (e) {
    if (e.target === overlay) {
      modal.setAttribute("aria-hidden", "true");
      modal.style.display = "none";
    }
  });
}