<?php
/**
 * The sidebar template file
 *
 * @package Klaro
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>

<aside id="sidebar" class="sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Primary sidebar', 'klaro' ); ?>">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #sidebar -->
