<?php
/**
 * The footer template file
 *
 * @package Klaro
 * @since 1.0.0
 */
?>

	<footer id="site-footer" class="site-footer">

		<?php if ( is_active_sidebar( 'klaro-footer-1' ) ) : ?>
			<aside class="footer-widgets" aria-label="<?php esc_attr_e( 'Footer widgets', 'klaro' ); ?>">
				<?php dynamic_sidebar( 'klaro-footer-1' ); ?>
			</aside>
		<?php endif; ?>

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Navigation', 'klaro' ); ?>">
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
			<p class="site-credit">
				<?php
				$klaro_footer_credit = get_theme_mod( 'klaro_footer_credit', '' );
				if ( $klaro_footer_credit ) {
					echo wp_kses_post( $klaro_footer_credit );
				} else {
					$klaro_allowed_html = array(
						'a' => array(
							'href' => array(),
						),
					);
					printf(
						/* translators: 1: Theme name with link, 2: WordPress with link */
						wp_kses( __( 'Powered by %1$s and %2$s', 'klaro' ), $klaro_allowed_html ),
						'<a href="' . esc_url( __( 'https://github.com/rafael-minuesa/klaro', 'klaro' ) ) . '">Klaro</a>',
						'<a href="' . esc_url( __( 'https://wordpress.org/', 'klaro' ) ) . '">WordPress</a>'
					);
				}
				?>
			</p>
			<?php
			$klaro_a11y_url = get_theme_mod( 'klaro_accessibility_link_url', '' );
			if ( get_theme_mod( 'klaro_show_accessibility_link', false ) && $klaro_a11y_url ) :
				$klaro_a11y_text = get_theme_mod( 'klaro_accessibility_link_text', __( 'Accessibility Statement', 'klaro' ) );
				?>
				<p class="site-accessibility-link">
					<a href="<?php echo esc_url( $klaro_a11y_url ); ?>">
						<?php echo esc_html( $klaro_a11y_text ); ?>
					</a>
				</p>
			<?php endif; ?>
		</div><!-- .site-info -->

	</footer><!-- #site-footer -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
