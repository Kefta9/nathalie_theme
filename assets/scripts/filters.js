let currentPage = 1;
const perPage = 8;

function loadPhotos(reset = false) { // reset = true remplace le contenu, false ajoute à la fin
  const categorie = document.querySelector("input[name='categorie']").value; // valeur renvoyé par dataset.value du dropdown.js
  const format = document.querySelector("input[name='format']").value;
  const order = document.querySelector("input[name='order']").value;

  fetch(nathalie_ajax.ajax_url, { // défini dans wp_localize_script
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({ 
      action: "load_more_photos", // action à exécuter
      nonce: nathalie_ajax.nonce,
      page: currentPage,
      categorie: categorie,
      format: format,
      order: order,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      const grid = document.querySelector(".other-photos__grid");
      if (data.success) { 
        if (reset) { // Si changement de filtre, on remplace le contenu
          grid.innerHTML = data.data;
        } else {
          grid.insertAdjacentHTML("beforeend", data.data);
        }
      } else if (data.data === "no_more") {
        document.getElementById("load-more").style.display = "none";
      }
    });
}

// Bouton charger plus
document.getElementById("load-more").addEventListener("click", () => {
  currentPage++;
  loadPhotos();
});

// Changement de filtres
document
  .querySelectorAll(".photo-gallery__filters input[type=hidden]")
  .forEach((input) => {
    input.addEventListener("change", () => {
      currentPage = 1;
      loadPhotos(true); // recharge avec reset car changement de filtre
      document.getElementById("load-more").style.display = "block";
    });
});
