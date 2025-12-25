<?php
/**
 * Show info notice
 * Klaro Accessibility Enhanced Version with ARIA live region
 *
 * @package Klaro
 * @since 1.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $notices ) {
	return;
}

?>
<div role="status" aria-live="polite" aria-atomic="true">
	<?php foreach ( $notices as $notice ) : ?>
		<div class="woocommerce-info"<?php echo wc_get_notice_data_attr( $notice ); ?>>
			<?php echo wc_kses_notice( $notice['notice'] ); ?>
		</div>
	<?php endforeach; ?>
</div>
