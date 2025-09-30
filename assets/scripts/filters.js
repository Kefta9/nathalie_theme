function loadPhotos(reset = false) {
  const categorie = document.querySelector("input[name='categorie']").value;
  const format = document.querySelector("input[name='format']").value;
  const order = document.querySelector("input[name='order']").value;
  
  // Récupérer les IDs des photos déjà affichées (sauf si reset)
  let excludeIds = [];
  if (!reset) {
    const photoBlocks = document.querySelectorAll('.photo-block[data-photo-id]');
    excludeIds = Array.from(photoBlocks).map(block => block.dataset.photoId);
  }

  fetch(nathalie_ajax.ajax_url, {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({
      action: "load_more_photos",
      nonce: nathalie_ajax.nonce,
      categorie: categorie,
      format: format,
      order: order,
      exclude: excludeIds.join(','),
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      const grid = document.querySelector(".other-photos__grid");
      const loadMoreBtn = document.getElementById("load-more");
      
      if (data.success) {
        if (data.data === "no_more") {
          // Plus de photos à charger
          loadMoreBtn.style.display = "none";
        } else {
          if (reset) {
            // Si changement de filtre, on remplace le contenu
            grid.innerHTML = data.data;
            loadMoreBtn.style.display = "block";
          } else {
            // Sinon on ajoute à la fin
            grid.insertAdjacentHTML("beforeend", data.data);
          }
        }
      }
    });
}

// Bouton charger plus
const loadMoreBtn = document.getElementById("load-more");
if (loadMoreBtn) {
  loadMoreBtn.addEventListener("click", () => {
    loadPhotos();
  });
}

// Changement de filtres
document
  .querySelectorAll(".photo-gallery__filters input[type=hidden]")
  .forEach((input) => {
    input.addEventListener("change", () => {
      loadPhotos(true);
    });
  });
