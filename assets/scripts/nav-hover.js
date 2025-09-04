document.addEventListener('DOMContentLoaded', () => {
  const preview = document.querySelector('.nav-preview-single');
  if (!preview) return;

  const defaultSrc = preview.getAttribute('data-default') || preview.src;

  document.querySelectorAll('.nav-link').forEach(link => {
    const hoverSrc = link.getAttribute('data-thumbnail-hover');

    link.addEventListener('mouseenter', () => {
      if (hoverSrc) preview.src = hoverSrc;
    });

    link.addEventListener('mouseleave', () => {
      preview.src = defaultSrc;
    });
  });
});
