<?php
/**
 * The Template for displaying product archives
 * Klaro Accessibility Enhanced Version
 *
 * @package Klaro
 * @since 1.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<?php klaro_breadcrumbs(); ?>

<?php do_action( 'woocommerce_before_main_content' ); ?>

<header class="woocommerce-products-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title">
			<?php woocommerce_page_title(); ?>
		</h1>
	<?php endif; ?>

	<?php do_action( 'woocommerce_archive_description' ); ?>
</header>

<?php if ( woocommerce_product_loop() ) : ?>

	<nav id="shop-filters" class="shop-controls" aria-label="<?php esc_attr_e( 'Shop controls', 'klaro' ); ?>">
		<?php do_action( 'woocommerce_before_shop_loop' ); ?>
	</nav>

	<section id="products-list" aria-label="<?php esc_attr_e( 'Products', 'klaro' ); ?>">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Products list', 'klaro' ); ?></h2>

		<?php
		woocommerce_product_loop_start();

		if ( wc_get_loop_prop( 'total' ) ) {
			while ( have_posts() ) {
				the_post();
				do_action( 'woocommerce_shop_loop' );
				wc_get_template_part( 'content', 'product' );
			}
		}

		woocommerce_product_loop_end();
		?>
	</section>

	<?php do_action( 'woocommerce_after_shop_loop' ); ?>

<?php else : ?>
	<?php do_action( 'woocommerce_no_products_found' ); ?>
<?php endif; ?>

<?php
do_action( 'woocommerce_after_main_content' );
do_action( 'woocommerce_sidebar' );
get_footer( 'shop' );
