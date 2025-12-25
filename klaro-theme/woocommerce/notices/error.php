<?php
/**
 * Show error notice
 * Klaro Accessibility Enhanced Version with ARIA alert
 *
 * @package Klaro
 * @since 1.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $notices ) {
	return;
}

?>
<div role="alert" aria-live="assertive" aria-atomic="true">
	<ul class="woocommerce-error" role="list">
		<?php foreach ( $notices as $notice ) : ?>
			<li<?php echo wc_get_notice_data_attr( $notice ); ?>>
				<?php echo wc_kses_notice( $notice['notice'] ); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
