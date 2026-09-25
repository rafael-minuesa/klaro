<?php
/**
 * Load Klaro's commerce enhancements only where commerce is used.
 *
 * @package Klaro
 */

/**
 * Identify registered WooCommerce shortcodes, including renamed core tags.
 *
 * @param string $tag Shortcode tag.
 * @return bool
 */
function klaro_is_commerce_shortcode( $tag ) {
	global $shortcode_tags;

	$callback = isset( $shortcode_tags[ $tag ] ) ? $shortcode_tags[ $tag ] : null;
	// This shortcode returns a URL, not markup; never prepend CSS to it.
	if ( 'WC_Shortcodes::product_add_to_cart_url' === $callback || ( is_array( $callback ) && 'product_add_to_cart_url' === $callback[1] ) ) {
		return false;
	}

	if ( is_array( $callback ) ) {
		$callback = is_object( $callback[0] ) ? get_class( $callback[0] ) : $callback[0];
	}

	return is_string( $callback ) && ( 'WC_Shortcodes' === $callback || 0 === strpos( $callback, 'WC_Shortcodes::' ) );
}

/**
 * Look ahead without executing shortcodes or rendering blocks twice.
 * Synced blocks and dynamic content are also covered by the render hooks below.
 *
 * @param string $content Stored post content.
 * @return bool
 */
function klaro_content_has_commerce( $content ) {
	if ( false !== strpos( $content, '<!-- wp:woocommerce/' ) ) {
		return true;
	}

	global $shortcode_tags;
	foreach ( array_keys( $shortcode_tags ) as $tag ) {
		if ( klaro_is_commerce_shortcode( $tag ) && has_shortcode( $content, $tag ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Preload on commerce routes and content visible in the main query.
 */
function klaro_maybe_enqueue_commerce_assets() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$needed = is_woocommerce() || is_cart() || is_checkout() || is_account_page();
	if ( ! $needed ) {
		global $wp_query;
		foreach ( (array) $wp_query->posts as $queried_post ) {
			if ( $queried_post instanceof WP_Post && ! post_password_required( $queried_post ) && klaro_content_has_commerce( $queried_post->post_content ) ) {
				$needed = true;
				break;
			}
		}
	}

	/**
	 * Allow custom templates/integrations to request assets before wp_head.
	 *
	 * @param bool $needed Whether the route or queried content uses commerce.
	 */
	if ( apply_filters( 'klaro_needs_commerce_assets', $needed ) ) {
		klaro_woocommerce_scripts();
	}
}
add_action( 'wp_enqueue_scripts', 'klaro_maybe_enqueue_commerce_assets', 20 );

/**
 * Enqueue at render time for commerce not discoverable before the head.
 *
 * Print late CSS before the component, rather than leaving it unprinted or
 * waiting for the footer. WP tracks printed handles, so this happens once.
 * The caller must capture this output when running inside a content filter.
 */
function klaro_render_commerce_assets() {
	if ( ! class_exists( 'WooCommerce' ) || is_admin() || is_feed() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || wp_doing_ajax() ) {
		return;
	}

	klaro_woocommerce_scripts();
	if ( did_action( 'wp_print_styles' ) && ! wp_style_is( 'klaro-woocommerce', 'done' ) ) {
		wp_print_styles( array( 'klaro-woocommerce' ) );
	}
}

/**
 * Track nested commerce rendering, including Mini-Cart's discarded pre-render.
 *
 * @param int $change One on entry, minus one on exit, zero to read.
 * @return int
 */
function klaro_commerce_block_depth( $change = 0 ) {
	static $depth = 0;
	$depth        = max( 0, $depth + $change );
	return $depth;
}

/**
 * Defer CSS output until the outer commerce block returns its visible markup.
 *
 * @param array $block Parsed block being rendered.
 * @return array
 */
function klaro_commerce_block_start( $block ) {
	if ( ! empty( $block['blockName'] ) && 0 === strpos( $block['blockName'], 'woocommerce/' ) ) {
		klaro_commerce_block_depth( 1 );
	}
	return $block;
}
add_filter( 'render_block_data', 'klaro_commerce_block_start', 100 );

/**
 * Preserve commerce in nested/synced blocks and shortcode widgets/templates.
 *
 * @param string       $content Rendered HTML.
 * @param array|string $source  Parsed block or shortcode tag.
 * @return string
 */
function klaro_render_commerce_content( $content, $source ) {
	$is_commerce = is_array( $source )
		? ( ! empty( $source['blockName'] ) && 0 === strpos( $source['blockName'], 'woocommerce/' ) )
		: klaro_is_commerce_shortcode( $source );

	if ( $is_commerce && is_array( $source ) ) {
		klaro_commerce_block_depth( -1 );
	}

	if ( $is_commerce && 0 === klaro_commerce_block_depth() && '' !== trim( $content ) ) {
		ob_start();
		klaro_render_commerce_assets();
		$content = ob_get_clean() . $content;
	}

	return $content;
}
add_filter( 'render_block', 'klaro_render_commerce_content', 10, 2 );
add_filter( 'do_shortcode_tag', 'klaro_render_commerce_content', 10, 2 );

/**
 * Cover classic WooCommerce widgets only when they are actually displayed.
 *
 * @param array|false $instance Widget settings, or false if hidden.
 * @param WP_Widget   $widget   Widget object.
 * @return array|false
 */
function klaro_commerce_widget_assets( $instance, $widget ) {
	if ( false !== $instance && is_a( $widget, 'WC_Widget' ) ) {
		klaro_render_commerce_assets();
	}
	return $instance;
}
add_filter( 'widget_display_callback', 'klaro_commerce_widget_assets', 100, 2 );

// Also cover mini-carts and product templates called directly by integrations.
add_action( 'woocommerce_before_mini_cart', 'klaro_render_commerce_assets' );
add_action( 'woocommerce_before_shop_loop', 'klaro_render_commerce_assets' );
add_action( 'woocommerce_before_single_product', 'klaro_render_commerce_assets' );
