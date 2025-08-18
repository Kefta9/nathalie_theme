// Ouvre la modal contact au clic sur le lien du menu
const contactLinks = document.querySelectorAll(
  'a[href="#contact-modal"], a[href="#"]'
);
contactLinks.forEach((link) => {
  link.addEventListener("click", function (e) {
    e.preventDefault();
    const modal = document.querySelector(".modal-contact");
    if (modal) {
      modal.style.display = "block";
    }
  });
});