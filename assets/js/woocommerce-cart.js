/**
 * Carrito Abalturas — stepper de cantidad, barra móvil y microinteracciones.
 */
(function ($) {
	'use strict';

	var cfg = window.abalturasCart || {};

	function pulseQty($stepper) {
		$stepper.addClass('is-pulse');
		window.setTimeout(function () {
			$stepper.removeClass('is-pulse');
		}, 350);
	}

	function getQtyBounds($input) {
		var min = parseFloat($input.attr('min'));
		var max = parseFloat($input.attr('max'));
		if (isNaN(min)) min = 0;
		if (isNaN(max) || max < 0) max = 9999;
		return { min: min, max: max };
	}

	function bindQtySteppers() {
		$(document).on('click', '.abalturas-qty-stepper__btn', function () {
			var $btn = $(this);
			var $stepper = $btn.closest('.abalturas-qty-stepper');
			var $input = $stepper.find('.qty').first();
			if (!$input.length) return;

			var bounds = getQtyBounds($input);
			var val = parseFloat($input.val());
			if (isNaN(val)) val = bounds.min || 0;

			if ($btn.data('action') === 'plus') {
				val = Math.min(bounds.max, val + 1);
			} else {
				val = Math.max(bounds.min, val - 1);
			}

			$input.val(val).trigger('change');
			pulseQty($stepper);
		});
	}

	function bindFormUpdating() {
		var $form = $('.abalturas-cart__form');
		if (!$form.length) return;

		$form.on('submit', function () {
			$form.addClass('is-updating');
			$form.find('.abalturas-cart-item').addClass('is-updating');
		});

		$form.on('change', '.qty', function () {
			var $item = $(this).closest('.abalturas-cart-item');
			$item.addClass('is-updating');
			window.setTimeout(function () {
				$item.removeClass('is-updating');
			}, 400);
		});
	}

	function syncMobileBar() {
		var $bar = $('#abalturas-cart-mobile-bar');
		if (!$bar.length) return;

		var $desktopTotal = $('.abalturas-cart-totals .order-total td').first();
		var $mobileAmount = $bar.find('.abalturas-cart-mobile-bar__amount');

		if ($desktopTotal.length && $mobileAmount.length) {
			$mobileAmount.html($desktopTotal.html());
		}

		if (window.matchMedia('(max-width: 1023px)').matches && $('.abalturas-cart-item').length) {
			$bar.prop('hidden', false).addClass('is-visible');
		} else {
			$bar.removeClass('is-visible');
		}
	}

	function hideBlockLineItemTotals() {
		var selector =
			'.wc-block-cart__main .wc-block-cart-items__header-total, ' +
			'.wc-block-cart__main .wc-block-cart-item__total';

		$(selector).each(function () {
			var el = this;
			el.setAttribute('hidden', 'hidden');
			el.setAttribute('aria-hidden', 'true');
			el.style.setProperty('display', 'none', 'important');
		});
	}

	function relabelFreeShippingLabels() {
		var i18n = cfg.i18n || {};
		var quote = i18n.shippingQuote || 'A cotizar';
		var freePattern = /^(gratis|free|envío gratuito|envio gratuito|free shipping)$/i;

		$(
			'.wp-block-woocommerce-cart-order-summary-shipping-block .wc-block-components-totals-item__value, ' +
			'.wp-block-woocommerce-checkout-order-summary-shipping-block .wc-block-components-totals-item__value, ' +
			'.wc-block-components-shipping-rates-control .wc-block-components-radio-control__secondary-label, ' +
			'.wc-block-checkout__shipping-option--free'
		).each(function () {
			var $el = $(this);
			var text = $el.text().replace(/\s+/g, ' ').trim();

			if ($el.hasClass('wc-block-checkout__shipping-option--free') || freePattern.test(text)) {
				$el
					.text(quote)
					.removeClass('wc-block-checkout__shipping-option--free')
					.addClass('abalturas-cart-shipping-quote-value');
			}
		});
	}

	function relabelBlockTotals() {
		hideBlockLineItemTotals();
		var i18n = cfg.i18n || {};
		var $title = $('.wc-block-cart__totals-title');
		if ($title.length && i18n.summaryTitle) {
			$title.text(i18n.summaryTitle);
		}

		$(
			'.wp-block-woocommerce-cart-order-summary-shipping-block .wc-block-components-totals-item, ' +
			'.wp-block-woocommerce-checkout-order-summary-shipping-block .wc-block-components-totals-item'
		).each(function () {
			var $row = $(this);
			var $shippingLabel = $row.find('.wc-block-components-totals-item__label').first();
			var $shippingValue = $row.find('.wc-block-components-totals-item__value').first();

			if ($shippingLabel.length && i18n.shipping) {
				$shippingLabel.text(i18n.shipping);
			}
			if ($shippingValue.length && i18n.shippingQuote) {
				$shippingValue.text(i18n.shippingQuote).addClass('abalturas-cart-shipping-quote-value');
			}
		});

		$('.wc-block-components-totals-footer-item .wc-block-components-totals-item__label').each(function () {
			if (i18n.total) {
				$(this).text(i18n.total);
			}
		});

		relabelCheckoutShippingOptions(i18n);
		relabelFreeShippingLabels();
		renderBlockShippingNotice(i18n);
	}

	function relabelCheckoutShippingOptions(i18n) {
		if (!i18n.shippingQuote) {
			return;
		}

		$('.wc-block-checkout__shipping-option--free').each(function () {
			$(this)
				.text(i18n.shippingQuote)
				.removeClass('wc-block-checkout__shipping-option--free')
				.addClass('abalturas-cart-shipping-quote-value');
		});

		relabelFreeShippingLabels();
	}

	function observeBlockShippingRelabel() {
		var root = document.querySelector('.wc-block-cart, .wc-block-checkout');
		if (!root || typeof MutationObserver === 'undefined') {
			return;
		}

		var timer = null;
		var observer = new MutationObserver(function () {
			window.clearTimeout(timer);
			timer = window.setTimeout(relabelFreeShippingLabels, 40);
		});

		observer.observe(root, { childList: true, subtree: true, characterData: true });
	}

	function buildShippingInfoElement(i18n) {
		i18n = i18n || cfg.i18n || {};
		var $box = $('<div class="abalturas-cart-shipping-info" role="note" />');

		if (i18n.shippingInfoTitle) {
			$box.append(
				$('<p class="abalturas-cart-shipping-info__title" />').text(i18n.shippingInfoTitle)
			);
		}

		var $list = $('<ul class="abalturas-cart-shipping-info__list" />');

		if (i18n.shippingNote) {
			$list.append(
				$('<li class="abalturas-cart-shipping-info__item" />').text(i18n.shippingNote)
			);
		}

		if (i18n.shippingDelivery) {
			$list.append(
				$('<li class="abalturas-cart-shipping-info__item abalturas-cart-shipping-info__item--delivery" />').text(
					i18n.shippingDelivery
				)
			);
		}

		if ($list.children().length) {
			$box.append($list);
		}

		return $box;
	}

	function renderBlockShippingNotice(i18n) {
		i18n = i18n || cfg.i18n || {};
		if (!i18n.shippingNote && !i18n.shippingDelivery) {
			return;
		}

		$(
			'.wp-block-woocommerce-cart-order-summary-shipping-block, ' +
			'.wp-block-woocommerce-checkout-order-summary-shipping-block'
		).each(function () {
			var $shippingBlock = $(this);
			var $existing = $shippingBlock.next('.abalturas-cart-shipping-info, .abalturas-cart-shipping-notice--block');

			if ($existing.length) {
				if ($existing.hasClass('abalturas-cart-shipping-info')) {
					return;
				}
				$existing.remove();
			}

			$shippingBlock.after(buildShippingInfoElement(i18n));
		});
	}

	function observeBlockTotals() {
		var sidebar = document.querySelector('.wc-block-cart__sidebar, .wc-block-checkout__sidebar');
		if (!sidebar || typeof MutationObserver === 'undefined') {
			return;
		}

		var timer = null;
		var observer = new MutationObserver(function () {
			window.clearTimeout(timer);
			timer = window.setTimeout(relabelBlockTotals, 60);
		});

		observer.observe(sidebar, { childList: true, subtree: true, characterData: true });

		var shippingStep = document.querySelector('.wc-block-checkout__shipping-fields, .wc-block-components-shipping-rates-control');
		if (shippingStep) {
			var shippingTimer = null;
			var shippingObserver = new MutationObserver(function () {
				window.clearTimeout(shippingTimer);
				shippingTimer = window.setTimeout(relabelBlockTotals, 60);
			});
			shippingObserver.observe(shippingStep, { childList: true, subtree: true, characterData: true });
		}
	}

	function placeContinueShopping() {
		var $link = $('.abalturas-cart-continue-shopping').first();
		var $main = $('.wc-block-cart__main').first();
		if (!$link.length || !$main.length) {
			return;
		}
		if (!$main.has($link).length) {
			$main.append($link);
		}
	}

	function observeContinueShoppingPlacement() {
		var main = document.querySelector('.wc-block-cart__main');
		if (!main || typeof MutationObserver === 'undefined') {
			return;
		}

		var timer = null;
		var observer = new MutationObserver(function () {
			window.clearTimeout(timer);
			timer = window.setTimeout(placeContinueShopping, 40);
		});

		observer.observe(main, { childList: true });
	}

	function observeBlockLineItems() {
		var main = document.querySelector('.wc-block-cart__main');
		if (!main || typeof MutationObserver === 'undefined') {
			return;
		}

		var timer = null;
		var observer = new MutationObserver(function () {
			window.clearTimeout(timer);
			timer = window.setTimeout(hideBlockLineItemTotals, 40);
		});

		observer.observe(main, { childList: true, subtree: true });
	}

	function initBlockCartUx() {
		if (!$('.wc-block-cart').length) {
			return;
		}

		hideBlockLineItemTotals();
		relabelFreeShippingLabels();
		observeBlockLineItems();
		observeBlockShippingRelabel();
		placeContinueShopping();
		observeContinueShoppingPlacement();
	}

	function initBlockCheckoutUx() {
		if (!$('.wc-block-checkout').length) {
			return;
		}

		relabelFreeShippingLabels();
		observeBlockShippingRelabel();
		placeCheckoutBackToCart();
		observeCheckoutBackToCartPlacement();
		relabelBlockTotals();
		observeBlockTotals();
	}

	function buildBackToCartElement() {
		var i18n = cfg.i18n || {};
		if (!cfg.cartUrl || !i18n.backToCart) {
			return null;
		}

		return $('<p class="abalturas-checkout-back-to-cart abalturas-checkout-back-to-cart--sidebar" />').append(
			$('<a class="abalturas-checkout-back-to-cart__btn" />')
				.attr('href', cfg.cartUrl)
				.append($('<span class="abalturas-checkout-back-to-cart__arrow" aria-hidden="true">←</span>'))
				.append(document.createTextNode(i18n.backToCart))
		);
	}

	function placeCheckoutBackToCart() {
		var $summary = $('.wp-block-woocommerce-checkout-order-summary-block').first();
		if (!$summary.length || $summary.find('.abalturas-checkout-back-to-cart--sidebar').length) {
			return;
		}

		var $button = buildBackToCartElement();
		if ($button) {
			$summary.append($button);
		}
	}

	function observeCheckoutBackToCartPlacement() {
		var summary = document.querySelector('.wp-block-woocommerce-checkout-order-summary-block');
		if (!summary || typeof MutationObserver === 'undefined') {
			return;
		}

		var timer = null;
		var observer = new MutationObserver(function () {
			window.clearTimeout(timer);
			timer = window.setTimeout(placeCheckoutBackToCart, 40);
		});

		observer.observe(summary, { childList: true, subtree: true });
	}

	function subscribeBlockCartStore() {
		if (!window.wp || !window.wp.data || typeof window.wp.data.subscribe !== 'function') {
			return;
		}

		if (!$('.wc-block-cart, .wc-block-checkout').length) {
			return;
		}

		var previousSignature = '';
		window.wp.data.subscribe(function () {
			var store = window.wp.data.select('wc/store/cart');
			if (!store || typeof store.getCartData !== 'function') {
				return;
			}
			var cart = store.getCartData();
			if (!cart) {
				return;
			}
			var signature = String(cart.items_count) + ':' + String(cart.totals && cart.totals.total_price);
			if (signature === previousSignature) {
				return;
			}
			previousSignature = signature;
			window.setTimeout(hideBlockLineItemTotals, 80);
			window.setTimeout(relabelBlockTotals, 120);
			window.setTimeout(placeCheckoutBackToCart, 120);
		});
	}

	function init() {
		bindQtySteppers();
		bindFormUpdating();
		syncMobileBar();
		initBlockCartUx();
		initBlockCheckoutUx();
		relabelBlockTotals();
		observeBlockTotals();
		placeCheckoutBackToCart();
		subscribeBlockCartStore();

		$(window).on('resize orientationchange', syncMobileBar);

		$(document.body).on('updated_cart_totals updated_wc_div', function () {
			syncMobileBar();
			placeContinueShopping();
			hideBlockLineItemTotals();
			relabelBlockTotals();
		});
	}

	$(init);
})(jQuery);
