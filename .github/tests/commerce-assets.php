<?php
/**
 * Integration regressions for the commerce asset loader.
 *
 * On a disposable site with this checkout active and WooCommerce enabled:
 * wp eval-file .github/tests/commerce-assets.php
 *
 * Uses real block rendering and asset queues; changes only request-local state.
 *
 * @package Klaro
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	exit;
}

if ( ! function_exists( 'klaro_maybe_enqueue_commerce_assets' ) || ! class_exists( 'WooCommerce' ) ) {
	WP_CLI::error( 'Activate this Klaro checkout and WooCommerce first.' );
}

/**
 * Fail the command if a regression is found.
 *
 * @param bool   $condition Expected condition.
 * @param string $message   Failure description.
 */
function klaro_asset_test_assert( $condition, $message ) {
	if ( ! $condition ) {
		WP_CLI::error( $message );
	}
}

/**
 * Start an ordinary page with fresh asset queues.
 *
 * @param bool $late Whether head styles have already printed.
 */
function klaro_asset_test_reset( $late = true ) {
	// phpcs:disable WordPress.WP.GlobalVariablesOverride.Prohibited -- Isolate request state between CLI integration cases.
	$GLOBALS['wp_query']        = new WP_Query();
	$GLOBALS['wp_query']->posts = array();
	$GLOBALS['wp_styles']       = new WP_Styles();
	$GLOBALS['wp_scripts']      = new WP_Scripts();
	wp_register_style( 'klaro-style', get_stylesheet_uri(), array(), 'test' );
	$GLOBALS['wp_actions']['wp_print_styles'] = $late ? 1 : 0;
	// phpcs:enable WordPress.WP.GlobalVariablesOverride.Prohibited
}

add_shortcode( 'klaro_renamed_products', 'WC_Shortcodes::products' );
add_shortcode( 'klaro_renamed_url', array( 'WC_Shortcodes', 'product_add_to_cart_url' ) );
klaro_asset_test_assert( klaro_content_has_commerce( '[klaro_renamed_products]' ), 'Renamed product shortcode was missed.' );
klaro_asset_test_assert( ! klaro_content_has_commerce( '[klaro_renamed_url]' ), 'A URL-only shortcode must not load commerce markup assets.' );
klaro_asset_test_assert( ! klaro_content_has_commerce( '<p>Ordinary content</p>' ), 'Ordinary content was mistaken for commerce.' );

klaro_asset_test_reset();
klaro_maybe_enqueue_commerce_assets();
klaro_asset_test_assert( ! wp_script_is( 'klaro-woocommerce-accessibility', 'enqueued' ), 'Ordinary page enqueued commerce assets.' );

// Real dynamic blocks model Mini-Cart rendering children once for assets,
// discarding that HTML, then producing the visible outer block.
register_block_type(
	'woocommerce/klaro-asset-test-inner',
	array(
		'render_callback' => static function () {
						return '<p>Inner commerce</p>'; },
	)
);
register_block_type(
	'woocommerce/klaro-asset-test-outer',
	array(
		'render_callback' => static function () {
			do_blocks( '<!-- wp:woocommerce/klaro-asset-test-inner /-->' );
			return '<p>Visible commerce</p>';
		},
	)
);

klaro_asset_test_reset();
$klaro_test_html = do_blocks( '<!-- wp:woocommerce/klaro-asset-test-outer /-->' );
klaro_asset_test_assert( 1 === substr_count( $klaro_test_html, 'klaro-woocommerce-css' ), 'CSS was lost in a discarded nested render.' );
klaro_asset_test_assert( strpos( $klaro_test_html, 'klaro-woocommerce-css' ) < strpos( $klaro_test_html, 'Visible commerce' ), 'Late CSS must precede the visible commerce markup.' );
klaro_asset_test_assert( wp_script_is( 'klaro-woocommerce-accessibility', 'enqueued' ), 'Late commerce script was not queued.' );
klaro_asset_test_assert( 0 === klaro_commerce_block_depth(), 'Nested rendering left an unbalanced depth.' );

$klaro_test_html = do_blocks( '<!-- wp:woocommerce/klaro-asset-test-outer /-->' );
klaro_asset_test_assert( false === strpos( $klaro_test_html, 'klaro-woocommerce-css' ), 'Repeated commerce duplicated the stylesheet.' );
klaro_asset_test_assert( 1 === substr_count( wp_scripts()->get_data( 'klaro-woocommerce-accessibility', 'data' ), 'var klaroWcSettings' ), 'Repeated commerce duplicated localization.' );

klaro_asset_test_reset( false );
$GLOBALS['wp_query']->posts = array(
	new WP_Post(
		(object) array(
			'post_content'  => '[products]',
			'post_password' => '',
		)
	),
);
klaro_maybe_enqueue_commerce_assets();
klaro_asset_test_assert( wp_style_is( 'klaro-woocommerce', 'enqueued' ), 'Stored commerce was not enqueued before head styles.' );
klaro_asset_test_assert( ! wp_style_is( 'klaro-woocommerce', 'done' ), 'Look-ahead prematurely printed CSS.' );

WP_CLI::success( 'Commerce asset integration regressions passed.' );
