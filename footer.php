<?php
// Footer du thème Nathalie Mota
?>
<footer class="site-footer">
    <nav class="footer-nav">
        <?php
        wp_nav_menu([
            'theme_location' => 'footer_menu',
            'container'      => false,
            'menu_class'     => 'footer-menu',
        ]);
        ?>
        <p class="footer-copyright">Tous droits réservés</p>
    </nav>
</footer>
<?php get_template_part('templates-part/modal_contact'); ?>
<?php wp_footer(); ?>
</body>
</html>
