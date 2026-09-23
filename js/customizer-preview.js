/**
 * Klaro Customizer live preview
 *
 * Applies the postMessage typography settings to the preview without a
 * reload. The values land on the same custom properties the theme's inline
 * Customizer CSS sets on :root, so the toolbar text sizes scale with them.
 *
 * @package Klaro
 * @since 2.8.0
 */
( function( api ) {
	'use strict';

	if ( ! api ) {
		return;
	}

	api( 'klaro_font_size', function( value ) {
		value.bind( function( to ) {
			var size = Math.min( 36, Math.max( 14, parseInt( to, 10 ) || 18 ) );
			document.documentElement.style.setProperty( '--font-size-base', size + 'px' );
		} );
	} );

	api( 'klaro_line_height', function( value ) {
		value.bind( function( to ) {
			var height = Math.min( 3, Math.max( 1.2, parseFloat( to ) || 1.8 ) );
			document.documentElement.style.setProperty( '--line-height-base', String( height ) );
		} );
	} );
}( window.wp && window.wp.customize ) );
