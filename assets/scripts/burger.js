// Fonctionnement du menu hamburger
const hamburger = document.querySelector(".hamburger");
const navMenu = document.querySelector(".nav-menu");

if (hamburger && navMenu) {
  hamburger.addEventListener("click", function () {
    navMenu.classList.toggle("open");
    hamburger.classList.toggle("active");
  });
}