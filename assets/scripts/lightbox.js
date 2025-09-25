let lightbox;
let currentPhotoIndex = 0; // Index de la photo actuellement affichée
let photos = [];

// Initialisation de la lightbox
function initLightbox() {
  if (lightbox) lightbox.remove();

  lightbox = document.createElement('div');
  lightbox.className = 'lightbox';
  lightbox.innerHTML = `
    <button class="lightbox__close" aria-label="Fermer la lightbox">×</button>
      <div class="lightbox__content">
        <a href="#" class="lightbox__link">
          <img src="" alt="" class="lightbox__img">
        </a>
        <div class="lightbox__infos">
          <span class="lightbox__ref"></span>
          <span class="lightbox__category"></span>
        </div>
      </div>
    <button class="lightbox__prev" aria-label="Image précédente">
      <img src="${nathalie_theme.templateUrl}/assets/images/prev.svg" alt="Précédent">
    </button>
    <button class="lightbox__next" aria-label="Image suivante">
      <img src="${nathalie_theme.templateUrl}/assets/images/next.svg" alt="Suivant">
    </button>
  `;
  document.body.appendChild(lightbox);

  updatePhotos();
}

// Mettre à jour la liste des photos
function updatePhotos() { // Récupère toutes les photos actuelles
  const photoBlocks = document.querySelectorAll('.photo-block');
  photos = Array.from(photoBlocks).map(block => ({
    image: block.dataset.fullImage,
    title: block.querySelector('.photo-block__title')?.textContent || '',
    category: block.dataset.category || '',
    ref: block.querySelector('.photo-block__ref')?.textContent || '',
    link: block.querySelector('.photo-block__fullscreen')?.href || '#'
  }));
}

// Afficher une photo dans la lightbox
function showLightbox(index) {
  if (index < 0 || index >= photos.length) return;
  currentPhotoIndex = index;

  const photo = photos[index];
  lightbox.querySelector('.lightbox__img').src = photo.image;
  lightbox.querySelector('.lightbox__img').alt = photo.title;
  lightbox.querySelector('.lightbox__ref').textContent = photo.ref;
  lightbox.querySelector('.lightbox__category').textContent = photo.category;
  lightbox.querySelector('.lightbox__link').href = photo.link;

  lightbox.classList.add('lightbox--visible');
  document.body.style.overflow = 'hidden';
}

// Fermer la lightbox
function closeLightbox() {
  lightbox.classList.remove('lightbox--visible');
  document.body.style.overflow = '';
}

// Navigation
function showNextPhoto() {
  showLightbox((currentPhotoIndex + 1) % photos.length);
}
function showPrevPhoto() {
  showLightbox((currentPhotoIndex - 1 + photos.length) % photos.length);
}

// Écouteurs globaux
document.addEventListener('click', e => {
  const eyeBtn = e.target.closest('.photo-block__eye');
  if (eyeBtn) {
    e.preventDefault(); // Empêche le comportement par défaut du lien
    updatePhotos();
    const photoBlock = eyeBtn.closest('.photo-block');
    const index = Array.from(document.querySelectorAll('.photo-block')).indexOf(photoBlock); // Trouve l'index de la photo cliquée
    if (index !== -1) showLightbox(index); // Affiche la lightbox avec la photo correspondante
  }

  if (e.target.closest('.lightbox__next')) showNextPhoto();
  if (e.target.closest('.lightbox__prev')) showPrevPhoto();

  if (lightbox?.classList.contains('lightbox--visible')) {
    if (e.target === lightbox || e.target.closest('.lightbox__close')) {
      closeLightbox();
    }
  }
});

// Observer AJAX
const observer = new MutationObserver(() => updatePhotos()); // Met à jour la liste des photos si des éléments sont ajoutés/supprimés
document.addEventListener('DOMContentLoaded', () => {
  initLightbox();
  const photoGrid = document.querySelector('.other-photos__grid');
  if (photoGrid) observer.observe(photoGrid, { childList: true, subtree: true }); // Observe les changements dans la grille de photos
});
