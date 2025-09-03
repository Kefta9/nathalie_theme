document.querySelectorAll('.nav-link').forEach(link => {
  const mainImg = document.querySelector('.nav-preview-single');
  const defaultSrc = link.getAttribute('data-thumbnail-default');
  const hoverSrc = link.getAttribute('data-thumbnail-hover');

  link.addEventListener('mouseenter', () => {
    if (hoverSrc) mainImg.src = hoverSrc;
  });

  link.addEventListener('mouseleave', () => {
    if (defaultSrc) mainImg.src = defaultSrc;
  });
});
