// Gestion ouverture/fermeture de la modale contact
const contactLinks = document.querySelectorAll('a[href="#modal-contact"]');
const modal = document.getElementById("modal-contact");
const overlay = modal;

// Fonction pour remplir le champ "Réf. photo" dans CF7
function fillReferenceField(ref) {
  const refInput = document.querySelector('input[name="reference-photo"]');
  if (refInput) {
    refInput.value = ref;
  }
}

contactLinks.forEach((link) => {
  link.addEventListener("click", function (e) {
    e.preventDefault();
    if (modal) {
      modal.setAttribute("aria-hidden", "false");
      modal.style.display = "flex";

      // Récupère la réf depuis l'attribut data-ref
      const ref = link.getAttribute("data-ref");
      if (ref) {
        fillReferenceField(ref);
      }
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
