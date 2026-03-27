/**
 * Klaro Navigation Accessibility
 *
 * Adds aria-expanded support and keyboard navigation for submenus.
 *
 * @package Klaro
 * @since 2.2.0
 */
(function() {
	'use strict';

	function klaroInitNavigation() {
		var nav = document.getElementById( 'primary-navigation' );
		if ( ! nav ) {
			return;
		}

		var parentLinks = nav.querySelectorAll( '.menu-item-has-children > a' );
		var i;

		// Initialize aria-expanded on all parent menu item links.
		for ( i = 0; i < parentLinks.length; i++ ) {
			parentLinks[ i ].setAttribute( 'aria-expanded', 'false' );
		}

		// Toggle submenu on click.
		// First click opens submenu, second click follows the link.
		nav.addEventListener( 'click', function( event ) {
			var link = event.target.closest( '.menu-item-has-children > a' );
			if ( ! link ) {
				return;
			}

			var expanded = link.getAttribute( 'aria-expanded' ) === 'true';
			if ( ! expanded ) {
				event.preventDefault();
				klaroCloseAllSubmenus( nav );
				link.setAttribute( 'aria-expanded', 'true' );
			}
		});

		// Keyboard support.
		nav.addEventListener( 'keydown', function( event ) {
			// Escape closes the current submenu and returns focus to parent.
			if ( event.key === 'Escape' ) {
				var openParent = event.target.closest( '.menu-item-has-children' );
				if ( ! openParent ) {
					return;
				}

				var parentLink = openParent.querySelector( ':scope > a' );
				if ( parentLink && parentLink.getAttribute( 'aria-expanded' ) === 'true' ) {
					parentLink.setAttribute( 'aria-expanded', 'false' );
					parentLink.focus();
					event.preventDefault();
				}
			}
		});

		// Close all submenus when clicking outside the navigation.
		document.addEventListener( 'click', function( event ) {
			if ( ! nav.contains( event.target ) ) {
				klaroCloseAllSubmenus( nav );
			}
		});
	}

	/**
	 * Close all open submenus within a navigation element.
	 */
	function klaroCloseAllSubmenus( nav ) {
		var expanded = nav.querySelectorAll( 'a[aria-expanded="true"]' );
		var i;
		for ( i = 0; i < expanded.length; i++ ) {
			expanded[ i ].setAttribute( 'aria-expanded', 'false' );
		}
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', klaroInitNavigation );
	} else {
		klaroInitNavigation();
	}
})();
