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
		if ($('#klaro-wc-accessibility-status').length) {
			return $('#klaro-wc-accessibility-status');
		}

		var region = $('<div>')
			.attr({
				'id': 'klaro-wc-accessibility-status',
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
	 * Read the quantity constraints from the input as they are right now.
	 * Variation changes rewrite min, max and step on the input, so nothing
	 * is captured at set-up time. A missing or invalid minimum means 0, a
	 * missing maximum means no maximum, and a missing or non-numeric step
	 * (WooCommerce's "any") means 1.
	 */
	function readQuantityBounds($input) {
		var min = parseFloat($input.attr('min'));
		var max = parseFloat($input.attr('max'));
		var step = parseFloat($input.attr('step'));
		var stepAttr = String($input.attr('step') || '');
		var decimals = stepAttr.indexOf('.') !== -1 ? stepAttr.split('.')[1].length : 0;

		return {
			min: isNaN(min) ? 0 : min,
			max: isNaN(max) ? Infinity : max,
			step: isNaN(step) || step <= 0 ? 1 : step,
			decimals: decimals
		};
	}

	/**
	 * Reflect the current value against the bounds on the two buttons, so a
	 * button at a limit is announced as unavailable but stays focusable.
	 */
	function updateQuantityButtonState($input, $minus, $plus) {
		var bounds = readQuantityBounds($input);
		var current = parseFloat($input.val());
		if (isNaN(current)) {
			current = bounds.min;
		}
		$minus.attr('aria-disabled', current <= bounds.min ? 'true' : 'false');
		$plus.attr('aria-disabled', current >= bounds.max ? 'true' : 'false');
	}

	/**
	 * Enhance quantity controls with +/- buttons
	 */
	function initQuantityControls() {
		$('.woocommerce .quantity').each(function() {
			var $wrapper = $(this);
			var $input = $wrapper.find('.qty');

			// Skip if already enhanced, or if there is nothing a visitor can
			// change: hidden inputs (sold individually), read-only or disabled.
			if (!$input.length || $wrapper.find('.klaro-qty-btn').length) {
				return;
			}
			if ($input.attr('type') === 'hidden' || $input.prop('readOnly') || $input.prop('disabled')) {
				return;
			}

			// Create buttons
			var $minus = $('<button>')
				.attr({
					'type': 'button',
					'aria-label': klaroWcSettings.decreaseQuantity
				})
				.addClass('klaro-qty-btn klaro-qty-minus')
				.text('-');

			var $plus = $('<button>')
				.attr({
					'type': 'button',
					'aria-label': klaroWcSettings.increaseQuantity
				})
				.addClass('klaro-qty-btn klaro-qty-plus')
				.text('+');

			// Insert buttons
			$input.before($minus).after($plus);

			function change(direction) {
				var bounds = readQuantityBounds($input);
				var current = parseFloat($input.val());
				if (isNaN(current)) {
					current = bounds.min;
				}

				// Step, then clamp into the allowed range, so a step that
				// would overshoot lands exactly on the limit.
				var next = Math.min(bounds.max, Math.max(bounds.min, current + direction * bounds.step));
				next = parseFloat(next.toFixed(bounds.decimals));

				if (next === current) {
					announce(direction < 0 ? klaroWcSettings.quantityMinimum : klaroWcSettings.quantityMaximum);
					updateQuantityButtonState($input, $minus, $plus);
					return;
				}

				$input.val(next).trigger('change');
				announce(klaroWcSettings.quantityUpdated + ' ' + next);
				updateQuantityButtonState($input, $minus, $plus);
			}

			$minus.on('click', function(e) {
				e.preventDefault();
				change(-1);
			});

			$plus.on('click', function(e) {
				e.preventDefault();
				change(1);
			});

			// Typed values and variation changes move the bounds or the value.
			$input.on('change input', function() {
				updateQuantityButtonState($input, $minus, $plus);
			});
			$input.closest('form').on('found_variation reset_data', function() {
				updateQuantityButtonState($input, $minus, $plus);
			});

			updateQuantityButtonState($input, $minus, $plus);
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

		// Set ARIA attributes on tab list
		$tabList.attr({
			'role': 'tablist',
			'aria-label': klaroWcSettings.productTabs
		});

		$tabs.each(function(index) {
			var $tab = $(this);
			var $li = $tab.parent();
			var tabId = 'klaro-product-tab-' + index;
			var isActive = $li.hasClass('active');

			// Find the panel using the tab's href (WooCommerce convention)
			var panelSelector = $tab.attr('href');
			var $panel = panelSelector ? $(panelSelector) : $();
			var panelId = $panel.length ? $panel.attr('id') : '';

			// Tab attributes
			$tab.attr({
				'role': 'tab',
				'id': tabId,
				'aria-controls': panelId,
				'tabindex': isActive ? '0' : '-1',
				'aria-selected': isActive ? 'true' : 'false'
			});

			// Panel attributes — preserve existing ID
			if ($panel.length) {
				$panel.attr({
					'role': 'tabpanel',
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
				$link.attr('aria-label', klaroWcSettings.removeFromCart.replace('%s', productName));
			}
		});
	}

	/**
	 * Enhance checkout form accessibility.
	 *
	 * Called again after every updated_checkout, so the handler is bound
	 * once under a namespace instead of stacking a copy per update.
	 */
	function initCheckoutAccessibility() {
		var $checkoutForm = $('.woocommerce-checkout');
		if (!$checkoutForm.length) {
			return;
		}

		$(document.body).off('checkout_error.klaro').on('checkout_error.klaro', function() {
			var $errorList = $('.woocommerce-error').first();
			var $errors = $errorList.find('li');
			if (!$errors.length) {
				return;
			}

			announce(klaroWcSettings.checkoutErrors.replace('%s', $errors.length), true);

			// WooCommerce focuses the error list itself when it carries
			// tabindex="-1" (the theme's notice template does). Only step in
			// when focus did not land inside the list, and then move it to
			// the list rather than to a list item, which is not focusable.
			if (!$.contains($errorList[0], document.activeElement) && document.activeElement !== $errorList[0]) {
				$errorList.attr('tabindex', '-1').trigger('focus');
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

		// Wrap each thumbnail in a real button so it is natively keyboard
		// operable instead of a clickable image with role="button"
		$gallery.find('.flex-control-thumbs img').each(function(index) {
			var $thumb = $(this);

			if ($thumb.parent().hasClass('klaro-thumb-btn')) {
				return;
			}

			$thumb.wrap(
				$('<button>').attr({
					'type': 'button',
					'class': 'klaro-thumb-btn',
					'aria-label': klaroWcSettings.viewImage.replace('%s', index + 1)
				})
			);

			$thumb.parent().on('click', function(e) {
				if (e.target === $thumb[0]) {
					// FlexSlider handles the image click; just announce it
					announce(klaroWcSettings.imageUpdated);
				} else {
					// Keyboard activation lands on the button; forward to the
					// image so FlexSlider switches the slide
					$thumb.trigger('click');
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
					announce($label.text() + ' ' + klaroWcSettings.changedTo + ' ' + selectedOption);
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
				productName = klaroWcSettings.genericProduct;
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
	 * Make the classic checkout skip-link targets focusable. The IDs come from
	 * WooCommerce's form-checkout.php, which the theme does not override, so
	 * the tabindex is added here. Re-run after updated_checkout is not needed:
	 * WooCommerce replaces the contents of #order_review, not the element.
	 */
	function initSkipTargets() {
		$('#customer_details, #order_review').each(function() {
			if (!$(this).attr('tabindex')) {
				$(this).attr('tabindex', '-1');
			}
		});
	}

	/**
	 * Initialize all enhancements
	 */
	function init() {
		createStatusRegion();
		initSkipTargets();
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
