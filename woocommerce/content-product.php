<?php
/**
 * The template for displaying product content within loops
 * Klaro Accessibility Enhanced Version
 *
 * @package Klaro
 * @since 1.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$product_id    = $product->get_id();
$product_name  = $product->get_name();
$product_price = $product->get_price_html();
?>

<li <?php wc_product_class( '', $product ); ?> aria-labelledby="product-title-<?php echo esc_attr( $product_id ); ?>">

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<a href="<?php echo esc_url( $product->get_permalink() ); ?>"
	   class="woocommerce-LoopProduct-link woocommerce-loop-product__link"
	   aria-labelledby="product-title-<?php echo esc_attr( $product_id ); ?>">

		<?php
		// Product thumbnail with accessible alt text
		do_action( 'woocommerce_before_shop_loop_item_title' );
		?>

		<h2 id="product-title-<?php echo esc_attr( $product_id ); ?>"
		    class="woocommerce-loop-product__title">
			<?php echo esc_html( $product_name ); ?>
		</h2>

	</a>

	<?php
	// Rating only (price handled separately below)
	woocommerce_template_loop_rating();
	?>

	<div class="product-price-wrapper">
		<?php woocommerce_template_loop_price(); ?>

		<?php if ( $product->is_on_sale() ) : ?>
			<span class="screen-reader-text">
				<?php esc_html_e( 'On sale', 'klaro' ); ?>
			</span>
		<?php endif; ?>
	</div>

	<?php
	// Add to cart button (accessibility enhanced via filter)
	do_action( 'woocommerce_after_shop_loop_item' );
	?>

</li>
