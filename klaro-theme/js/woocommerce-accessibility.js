/**
 * Klaro WooCommerce Accessibility Enhancements
 *
 * @package Klaro
 * @since 1.4.0
 */

(function($) {
	'use strict';

	/**
	 * Create ARIA live region for announcements
	 */
	function createStatusRegion() {
		if ($('#wc-accessibility-status').length) {
			return $('#wc-accessibility-status');
		}

		var region = $('<div>')
			.attr({
				'id': 'wc-accessibility-status',
				'role': 'status',
				'aria-live': 'polite',
				'aria-atomic': 'true'
			})
			.addClass('screen-reader-text')
			.appendTo('body');

		return region;
	}

	/**
	 * Announce message to screen readers
	 */
	function announce(message, assertive) {
		var region = createStatusRegion();
		var liveValue = assertive ? 'assertive' : 'polite';

		region.attr('aria-live', liveValue);
		region.text(message);

		// Clear after delay
		setTimeout(function() {
			region.text('');
		}, 3000);
	}

	/**
	 * Enhance quantity controls with +/- buttons
	 */
	function initQuantityControls() {
		$('.woocommerce .quantity').each(function() {
			var $wrapper = $(this);
			var $input = $wrapper.find('.qty');

			// Skip if already enhanced
			if ($wrapper.find('.klaro-qty-btn').length) {
				return;
			}

			var min = parseInt($input.attr('min')) || 1;
			var max = parseInt($input.attr('max')) || 9999;
			var step = parseInt($input.attr('step')) || 1;

			// Create buttons
			var $minus = $('<button>')
				.attr({
					'type': 'button',
					'aria-label': 'Decrease quantity'
				})
				.addClass('klaro-qty-btn klaro-qty-minus')
				.text('-');

			var $plus = $('<button>')
				.attr({
					'type': 'button',
					'aria-label': 'Increase quantity'
				})
				.addClass('klaro-qty-btn klaro-qty-plus')
				.text('+');

			// Insert buttons
			$input.before($minus).after($plus);

			// Event handlers
			$minus.on('click', function(e) {
				e.preventDefault();
				var currentVal = parseInt($input.val()) || min;
				if (currentVal > min) {
					var newVal = currentVal - step;
					$input.val(newVal).trigger('change');
					announce(klaroWcSettings.quantityUpdated + ' ' + newVal);
				}
			});

			$plus.on('click', function(e) {
				e.preventDefault();
				var currentVal = parseInt($input.val()) || min;
				if (currentVal < max) {
					var newVal = currentVal + step;
					$input.val(newVal).trigger('change');
					announce(klaroWcSettings.quantityUpdated + ' ' + newVal);
				}
			});
		});
	}

	/**
	 * Enhance product tabs with ARIA attributes
	 */
	function initAccessibleTabs() {
		var $tabsContainer = $('.woocommerce-tabs');
		if (!$tabsContainer.length) {
			return;
		}

		var $tabList = $tabsContainer.find('.tabs');
		var $tabs = $tabList.find('li a');
		var $panels = $tabsContainer.find('.panel');

		// Set ARIA attributes on tab list
		$tabList.attr({
			'role': 'tablist',
			'aria-label': 'Product information tabs'
		});

		$tabs.each(function(index) {
			var $tab = $(this);
			var $li = $tab.parent();
			var tabId = 'product-tab-' + index;
			var panelId = 'product-panel-' + index;
			var $panel = $panels.eq(index);
			var isActive = $li.hasClass('active');

			// Tab attributes
			$tab.attr({
				'role': 'tab',
				'id': tabId,
				'aria-controls': panelId,
				'tabindex': isActive ? '0' : '-1',
				'aria-selected': isActive ? 'true' : 'false'
			});

			// Panel attributes
			if ($panel.length) {
				$panel.attr({
					'role': 'tabpanel',
					'id': panelId,
					'aria-labelledby': tabId,
					'tabindex': '0'
				});
			}

			// Keyboard navigation
			$tab.on('keydown', function(e) {
				var currentIndex = $tabs.index($tab);
				var newIndex;

				switch (e.key) {
					case 'ArrowLeft':
						newIndex = currentIndex === 0 ? $tabs.length - 1 : currentIndex - 1;
						break;
					case 'ArrowRight':
						newIndex = currentIndex === $tabs.length - 1 ? 0 : currentIndex + 1;
						break;
					case 'Home':
						newIndex = 0;
						break;
					case 'End':
						newIndex = $tabs.length - 1;
						break;
					default:
						return;
				}

				e.preventDefault();
				$tabs.eq(newIndex).focus().click();
			});

			// Click handler
			$tab.on('click', function() {
				$tabs.each(function(i) {
					$(this).attr({
						'tabindex': i === index ? '0' : '-1',
						'aria-selected': i === index ? 'true' : 'false'
					});
				});
			});
		});
	}

	/**
	 * Enhance cart table accessibility
	 */
	function initCartAccessibility() {
		var $cartTable = $('.woocommerce-cart-form table.shop_table');
		if (!$cartTable.length) {
			return;
		}

		// Add scope to headers
		$cartTable.find('th').each(function() {
			if (!$(this).attr('scope')) {
				$(this).attr('scope', 'col');
			}
		});

		// Enhance remove buttons
		$cartTable.find('a.remove').each(function() {
			var $link = $(this);
			var productName = $link.closest('tr').find('.product-name a').text();

			if (productName && !$link.attr('aria-label')) {
				$link.attr('aria-label', 'Remove ' + productName + ' from cart');
			}
		});
	}

	/**
	 * Enhance checkout form accessibility
	 */
	function initCheckoutAccessibility() {
		var $checkoutForm = $('.woocommerce-checkout');
		if (!$checkoutForm.length) {
			return;
		}

		// Announce errors
		$(document.body).on('checkout_error', function() {
			var $errors = $('.woocommerce-error li');
			if ($errors.length > 0) {
				var message = $errors.length + ' validation errors. Please review the form.';
				announce(message, true);
				$errors.first().focus();
			}
		});
	}

	/**
	 * Enhance product gallery accessibility
	 */
	function initGalleryAccessibility() {
		var $gallery = $('.woocommerce-product-gallery');
		if (!$gallery.length) {
			return;
		}

		// Add keyboard navigation for thumbnails
		$gallery.find('.flex-control-thumbs img').each(function(index) {
			var $thumb = $(this);

			$thumb.attr({
				'tabindex': '0',
				'role': 'button',
				'aria-label': 'View image ' + (index + 1)
			});

			$thumb.on('keydown', function(e) {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					$thumb.click();
					announce('Product image updated');
				}
			});
		});
	}

	/**
	 * Enhance variation select accessibility
	 */
	function initVariantAccessibility() {
		var $variations = $('.variations');
		if (!$variations.length) {
			return;
		}

		$variations.find('select').each(function() {
			var $select = $(this);
			var $label = $select.closest('tr').find('label');

			$select.on('change', function() {
				var selectedOption = $select.find('option:selected').text();
				if ($label.length && selectedOption) {
					announce($label.text() + ' changed to ' + selectedOption);
				}
			});
		});
	}

	/**
	 * Announce add to cart success
	 */
	function initAddToCartAnnouncements() {
		// AJAX add to cart
		$(document.body).on('added_to_cart', function(e, fragments, cartHash, $button) {
			var productName = $button.closest('li.product').find('.woocommerce-loop-product__title').text();
			if (!productName) {
				productName = 'Product';
			}
			announce(productName + ' ' + klaroWcSettings.addedToCartMessage);
		});

		// Cart updated
		$(document.body).on('updated_cart_totals', function() {
			announce(klaroWcSettings.cartUpdatedMessage);
		});

		// Item removed
		$(document.body).on('removed_from_cart', function() {
			announce(klaroWcSettings.removedFromCartMessage);
		});
	}

	/**
	 * Initialize all enhancements
	 */
	function init() {
		createStatusRegion();
		initQuantityControls();
		initAccessibleTabs();
		initCartAccessibility();
		initCheckoutAccessibility();
		initGalleryAccessibility();
		initVariantAccessibility();
		initAddToCartAnnouncements();
	}

	// Initialize on DOM ready
	$(document).ready(init);

	// Re-initialize after AJAX updates
	$(document.body).on('updated_cart_totals wc_fragments_refreshed', function() {
		initQuantityControls();
		initCartAccessibility();
	});

	$(document.body).on('updated_checkout', function() {
		initCheckoutAccessibility();
	});

})(jQuery);
