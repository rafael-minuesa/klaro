<?php
/**
 * The sidebar template file
 *
 * @package Klaro
 * @since 1.0.0
 */

if ( ! klaro_has_sidebar() ) {
	return;
}
?>

<aside id="sidebar" class="sidebar" tabindex="-1" aria-label="<?php esc_attr_e( 'Primary sidebar', 'klaro' ); ?>">
	<?php dynamic_sidebar( 'klaro-sidebar-1' ); ?>
</aside><!-- #sidebar -->
