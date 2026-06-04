/**
 * Klaro Navigation Accessibility
 *
 * Implements submenus as a proper button-controlled disclosure:
 * - Each submenu gets a real <button> toggle with aria-expanded state.
 * - The parent link stays a plain navigable link.
 * - Open state persists on the list item, so submenu items are reachable
 *   both forwards (Tab) and backwards (Shift + Tab).
 * - Escape closes the open submenu and restores focus to its toggle.
 * - Clicking outside the navigation closes all submenus.
 *
 * @package Klaro
 * @since 2.3.0
 */
(function() {
	'use strict';

	var TEXT = window.klaroNavText || {};
	var EXPAND_LABEL = TEXT.expand || 'Show submenu';
	var COLLAPSE_LABEL = TEXT.collapse || 'Hide submenu';

	function klaroInitNavigation() {
		var nav = document.getElementById( 'primary-navigation' );
		if ( ! nav ) {
			return;
		}

		var parents = nav.querySelectorAll( '.menu-item-has-children' );
		var i;

		for ( i = 0; i < parents.length; i++ ) {
			klaroSetupToggle( parents[ i ] );
		}

		// Escape closes the submenu that currently contains focus.
		nav.addEventListener( 'keydown', function( event ) {
			if ( event.key !== 'Escape' && event.key !== 'Esc' ) {
				return;
			}

			var openItem = event.target.closest( '.menu-item-has-children.submenu-open' );
			if ( ! openItem ) {
				return;
			}

			var toggle = openItem.querySelector( ':scope > .submenu-toggle' );
			klaroCloseSubmenu( openItem );
			if ( toggle ) {
				toggle.focus();
			}
			event.preventDefault();
		});

		// Close all submenus when clicking outside the navigation.
		document.addEventListener( 'click', function( event ) {
			if ( ! nav.contains( event.target ) ) {
				klaroCloseAllSubmenus( nav );
			}
		});
	}

	/**
	 * Insert a toggle button for one submenu parent item.
	 *
	 * @param {HTMLElement} item The .menu-item-has-children list item.
	 */
	function klaroSetupToggle( item ) {
		var link = item.querySelector( ':scope > a' );
		var submenu = item.querySelector( ':scope > .sub-menu' );
		if ( ! link || ! submenu ) {
			return;
		}

		var label = link.textContent.trim();
		var button = document.createElement( 'button' );
		button.type = 'button';
		button.className = 'submenu-toggle';
		button.setAttribute( 'aria-expanded', 'false' );
		button.innerHTML = '<span class="screen-reader-text">' +
			klaroEscape( EXPAND_LABEL + ' ' + label ) + '</span>';

		// Place the toggle right after the parent link, before the submenu.
		link.parentNode.insertBefore( button, submenu );

		button.addEventListener( 'click', function() {
			var expanded = item.classList.contains( 'submenu-open' );
			// Close sibling submenus at the same level first.
			klaroCloseSiblings( item );
			if ( expanded ) {
				klaroCloseSubmenu( item );
			} else {
				klaroOpenSubmenu( item );
			}
		});
	}

	function klaroOpenSubmenu( item ) {
		var button = item.querySelector( ':scope > .submenu-toggle' );
		var link = item.querySelector( ':scope > a' );
		item.classList.add( 'submenu-open' );
		if ( button ) {
			button.setAttribute( 'aria-expanded', 'true' );
			klaroSetLabel( button, COLLAPSE_LABEL, link );
		}
	}

	function klaroCloseSubmenu( item ) {
		var button = item.querySelector( ':scope > .submenu-toggle' );
		var link = item.querySelector( ':scope > a' );
		item.classList.remove( 'submenu-open' );
		if ( button ) {
			button.setAttribute( 'aria-expanded', 'false' );
			klaroSetLabel( button, EXPAND_LABEL, link );
		}
		// Also close any nested open submenus.
		var nestedOpen = item.querySelectorAll( '.menu-item-has-children.submenu-open' );
		var i;
		for ( i = 0; i < nestedOpen.length; i++ ) {
			klaroCloseSubmenu( nestedOpen[ i ] );
		}
	}

	function klaroCloseSiblings( item ) {
		var parentList = item.parentNode;
		if ( ! parentList ) {
			return;
		}
		var siblings = parentList.children;
		var i;
		for ( i = 0; i < siblings.length; i++ ) {
			if ( siblings[ i ] !== item && siblings[ i ].classList.contains( 'submenu-open' ) ) {
				klaroCloseSubmenu( siblings[ i ] );
			}
		}
	}

	function klaroCloseAllSubmenus( nav ) {
		var open = nav.querySelectorAll( '.menu-item-has-children.submenu-open' );
		var i;
		for ( i = 0; i < open.length; i++ ) {
			klaroCloseSubmenu( open[ i ] );
		}
	}

	function klaroSetLabel( button, action, link ) {
		var label = link ? link.textContent.trim() : '';
		var sr = button.querySelector( '.screen-reader-text' );
		if ( sr ) {
			sr.textContent = action + ' ' + label;
		}
	}

	function klaroEscape( str ) {
		var div = document.createElement( 'div' );
		div.textContent = str;
		return div.innerHTML;
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', klaroInitNavigation );
	} else {
		klaroInitNavigation();
	}
})();
