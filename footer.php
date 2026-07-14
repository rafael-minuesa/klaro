<?php
/**
 * The footer template file
 *
 * @package Klaro
 * @since 1.0.0
 */
?>

	<footer id="site-footer" class="site-footer" tabindex="-1">

		<?php if ( is_active_sidebar( 'klaro-footer-1' ) ) : ?>
			<aside class="footer-widgets" aria-label="<?php esc_attr_e( 'Footer widgets', 'klaro' ); ?>">
				<?php dynamic_sidebar( 'klaro-footer-1' ); ?>
			</aside>
		<?php endif; ?>

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer', 'klaro' ); ?>">
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

<?php
/*
 * Daltonization filters for the accessibility toolbar's color vision modes.
 * Single matrix per deficiency: the Vienot simulation and the per-type error
 * redistribution (Simon-Liedtke & Farup) compose into one linear transform,
 * applied in linearRGB to match the gamma-removed reference pipeline.
 * White and black are preserved exactly (each matrix row sums to 1).
 */
?>
<svg class="klaro-filter-defs" width="0" height="0" aria-hidden="true" focusable="false" style="position:absolute">
	<defs>
		<filter id="klaro-daltonize-protanopia" color-interpolation-filters="linearRGB">
			<feColorMatrix type="matrix" values="1 0 0 0 0  0.4100531 0.5899469 0 0 0  0.5851272 -0.5851272 1 0 0  0 0 0 1 0" />
		</filter>
		<filter id="klaro-daltonize-deuteranopia" color-interpolation-filters="linearRGB">
			<feColorMatrix type="matrix" values="1.4378779 -0.4378779 0 0 0  0 1 0 0 0  -0.2036067 0.2036067 1 0 0  0 0 0 1 0" />
		</filter>
		<filter id="klaro-daltonize-tritanopia" color-interpolation-filters="linearRGB">
			<feColorMatrix type="matrix" values="1 -0.7391354 0.7391354 0 0  0 0.5143542 0.4856458 0 0  0 0 1 0 0  0 0 0 1 0" />
		</filter>
	</defs>
</svg>

<?php wp_footer(); ?>

</body>
</html>
