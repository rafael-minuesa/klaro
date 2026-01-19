<?php
/**
 * The sidebar template file
 *
 * @package Klaro
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'klaro-sidebar-1' ) ) {
    return;
}
?>

<aside id="sidebar" class="sidebar" aria-label="<?php esc_attr_e( 'Primary sidebar', 'klaro' ); ?>">
    <?php dynamic_sidebar( 'klaro-sidebar-1' ); ?>
</aside><!-- #sidebar -->
