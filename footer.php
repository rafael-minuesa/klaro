<?php
/**
 * The footer template file
 *
 * @package Klaro
 * @since 1.0.0
 */
?>

    <footer id="site-footer" class="site-footer" role="contentinfo">
        
        <?php if ( is_active_sidebar( 'klaro-footer-1' ) ) : ?>
            <aside class="footer-widgets" role="complementary" aria-label="<?php esc_attr_e( 'Footer widgets', 'klaro' ); ?>">
                <?php dynamic_sidebar( 'klaro-footer-1' ); ?>
            </aside>
        <?php endif; ?>

        <?php if ( has_nav_menu( 'footer' ) ) : ?>
            <nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Navigation', 'klaro' ); ?>">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer',
                        'menu_id'        => 'footer-menu',
                        'menu_class'     => 'footer-menu',
                        'depth'          => 1,
                        'container'      => false,
                    )
                );
                ?>
            </nav><!-- .footer-navigation -->
        <?php endif; ?>

        <div class="site-info">
            <p>
                <?php
                printf(
                    /* translators: 1: Theme name, 2: WordPress */
                    esc_html__( 'Powered by %1$s and %2$s', 'klaro' ),
                    '<a href="' . esc_url( __( 'https://github.com/rafael-minuesa/klaro', 'klaro' ) ) . '">Klaro</a>',
                    '<a href="' . esc_url( __( 'https://wordpress.org/', 'klaro' ) ) . '">WordPress</a>'
                );
                ?>
            </p>
            <p>
                <a href="<?php echo esc_url( home_url( '/accessibility-statement/' ) ); ?>">
                    <?php esc_html_e( 'Accessibility Statement', 'klaro' ); ?>
                </a>
            </p>
        </div><!-- .site-info -->

    </footer><!-- #site-footer -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
