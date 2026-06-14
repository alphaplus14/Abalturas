/**
 * Mini-carrito del header — contador, vista previa y sincronización Store API.
 */
(function () {
	'use strict';

	var cfg = window.abalturasHeaderCart || {};
	var i18n = cfg.i18n || {};

	var BADGE_ID = 'abalturas-header-cart-badge';
	var BADGE_SEL = '#' + BADGE_ID;
	var ROOT_SEL = '#abalturas-header-mini-cart';
	var TOGGLE_SEL = '#abalturas-header-cart-toggle';
	var PANEL_SEL = '#abalturas-header-mini-cart-panel';
	var CONTENT_SEL = '#abalturas-header-mini-cart-content';
	var CONTENT_FRAGMENT_SEL = '#abalturas-header-mini-cart-content';
	var BADGE_CLASS =
		'absolute right-1 top-1 flex h-[18px] min-w-[18px] items-center justify-center rounded-full bg-safety px-1 text-[10px] font-bold leading-none text-white ring-2 ring-white xl:right-1.5 xl:top-1.5';

	function formatCount(count) {
		count = parseInt(count, 10) || 0;
		return count > 99 ? '99+' : String(count);
	}

	function getRoot() {
		return document.querySelector(ROOT_SEL);
	}

	function getToggle() {
		return document.querySelector(TOGGLE_SEL);
	}

	function getPanel() {
		return document.querySelector(PANEL_SEL);
	}

	function getContent() {
		return document.querySelector(CONTENT_SEL);
	}

	function getBadge() {
		return document.getElementById(BADGE_ID);
	}

	function cartTitle(count) {
		if (count === 1 && i18n.titleSingular) {
			return i18n.titleSingular.replace('%d', String(count));
		}
		if (i18n.titlePlural) {
			return i18n.titlePlural.replace('%d', String(count));
		}
		return 'Carrito (' + count + ')';
	}

	function formatStoreMoney(amount, prices) {
		prices = prices || {};
		var minor = parseInt(prices.currency_minor_unit, 10);
		if (isNaN(minor)) {
			minor = 0;
		}
		var value = (parseInt(amount, 10) || 0) / Math.pow(10, minor);
		var thousand = prices.currency_thousand_separator || '.';
		var decimal = prices.currency_decimal_separator || ',';
		var decimals = parseInt(prices.currency_minor_unit, 10) || 0;
		var parts = value.toFixed(decimals).split('.');
		parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousand);
		var formatted = parts.join(decimal);
		var prefix = prices.currency_prefix || prices.currency_symbol || '$';
		var suffix = prices.currency_suffix || '';
		return (prefix + ' ' + formatted + suffix).trim();
	}

	function escapeHtml(text) {
		return String(text)
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;');
	}

	function buildPanelHtmlFromStoreCart(cart) {
		if (!cart || !cart.items || !cart.items.length) {
			return (
				'<div class="abalturas-header-mini-cart__empty">' +
				'<p class="abalturas-header-mini-cart__empty-text">' +
				escapeHtml(i18n.empty || 'Tu carrito está vacío') +
				'</p>' +
				'<a class="abalturas-header-mini-cart__btn abalturas-header-mini-cart__btn--primary" href="' +
				escapeHtml(cfg.shopUrl || '/') +
				'">' +
				escapeHtml(i18n.viewProducts || 'Ver productos') +
				'</a></div>'
			);
		}

		var maxItems = parseInt(cfg.maxItems, 10) || 4;
		var visible = cart.items.slice(0, maxItems);
		var remaining = Math.max(0, cart.items.length - visible.length);
		var count = parseInt(cart.items_count, 10) || cart.items.length;
		var html =
			'<div class="abalturas-header-mini-cart__head"><p class="abalturas-header-mini-cart__title">' +
			escapeHtml(cartTitle(count)) +
			'</p></div><ul class="abalturas-header-mini-cart__items" role="list">';

		visible.forEach(function (item) {
			var image = item.images && item.images[0] ? item.images[0].thumbnail || item.images[0].src : '';
			var prices = item.prices || {};
			var unitPrice = formatStoreMoney(prices.price, prices);
			var lineTotal = formatStoreMoney(item.totals && item.totals.line_subtotal, prices);
			var qtyLabel = (i18n.qty || '%1$s × %2$s')
				.replace('%1$s', String(item.quantity))
				.replace('%2$s', unitPrice)
				.replace('%s', String(item.quantity));

			html += '<li class="abalturas-header-mini-cart__item">';
			html += '<div class="abalturas-header-mini-cart__thumb">';
			if (image) {
				if (item.permalink) {
					html +=
						'<a href="' +
						escapeHtml(item.permalink) +
						'" tabindex="-1"><img class="abalturas-header-mini-cart__thumb-img" src="' +
						escapeHtml(image) +
						'" alt="" loading="lazy" decoding="async" /></a>';
				} else {
					html +=
						'<img class="abalturas-header-mini-cart__thumb-img" src="' +
						escapeHtml(image) +
						'" alt="" loading="lazy" decoding="async" />';
				}
			}
			html += '</div><div class="abalturas-header-mini-cart__meta"><p class="abalturas-header-mini-cart__name">';
			if (item.permalink) {
				html +=
					'<a href="' +
					escapeHtml(item.permalink) +
					'">' +
					escapeHtml(item.name) +
					'</a>';
			} else {
				html += escapeHtml(item.name);
			}
			html +=
				'</p><p class="abalturas-header-mini-cart__qty">' +
				escapeHtml(qtyLabel) +
				'</p></div><div class="abalturas-header-mini-cart__line-total">' +
				escapeHtml(lineTotal) +
				'</div></li>';
		});

		html += '</ul>';

		if (remaining > 0) {
			html +=
				'<p class="abalturas-header-mini-cart__more">' +
				escapeHtml((i18n.more || '+%d productos más en tu carrito').replace('%d', String(remaining))) +
				'</p>';
		}

		var subtotal = formatStoreMoney(cart.totals && cart.totals.total_items, cart.totals || {});

		html +=
			'<div class="abalturas-header-mini-cart__footer"><div class="abalturas-header-mini-cart__subtotal">' +
			'<span class="abalturas-header-mini-cart__subtotal-label">' +
			escapeHtml(i18n.subtotal || 'Subtotal (sin envío)') +
			'</span><span class="abalturas-header-mini-cart__subtotal-value">' +
			escapeHtml(subtotal) +
			'</span></div><div class="abalturas-header-mini-cart__actions">' +
			'<a class="abalturas-header-mini-cart__btn abalturas-header-mini-cart__btn--secondary" href="' +
			escapeHtml(cfg.cartUrl || '/') +
			'">' +
			escapeHtml(i18n.viewCart || 'Ver carrito') +
			'</a><a class="abalturas-header-mini-cart__btn abalturas-header-mini-cart__btn--primary" href="' +
			escapeHtml(cfg.checkoutUrl || '/') +
			'">' +
			escapeHtml(i18n.checkout || 'Finalizar compra') +
			'</a></div></div>';

		return html;
	}

	function setPanelHtml(html) {
		var content = getContent();
		if (content && typeof html === 'string') {
			content.innerHTML = html;
		}
	}

	function updateHeaderCartCount(count) {
		var toggle = getToggle();
		if (!toggle) {
			return;
		}

		count = parseInt(count, 10) || 0;
		var badge = getBadge();

		if (!badge) {
			badge = document.createElement('span');
			badge.id = BADGE_ID;
			badge.className = BADGE_CLASS;
			toggle.appendChild(badge);
		}

		if (count <= 0) {
			badge.hidden = true;
			badge.textContent = '';
			return;
		}

		badge.hidden = false;
		badge.textContent = formatCount(count);
	}

	function setMiniCartOpen(open) {
		var root = getRoot();
		var panel = getPanel();
		var toggle = getToggle();
		if (!root || !panel || !toggle) {
			return;
		}

		root.classList.toggle('is-open', !!open);
		panel.hidden = !open;
		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
	}

	function countFromPayload(data) {
		if (!data || typeof data !== 'object') {
			return null;
		}
		if (typeof data.itemsCount === 'number') {
			return data.itemsCount;
		}
		if (typeof data.items_count === 'number') {
			return data.items_count;
		}
		return null;
	}

	function syncMiniCartFromPayload(data) {
		var count = countFromPayload(data);
		if (count !== null) {
			updateHeaderCartCount(count);
		}
		if (data && data.items) {
			setPanelHtml(buildPanelHtmlFromStoreCart(data));
		}
	}

	function getStoreApiUrl() {
		if (window.wcSettings && window.wcSettings.storeApi && window.wcSettings.storeApi.namespace) {
			return window.location.origin + '/wp-json/' + window.wcSettings.storeApi.namespace + '/cart';
		}
		return window.location.origin + '/wp-json/wc/store/v1/cart';
	}

	function getStoreApiNonce() {
		if (window.wcSettings && window.wcSettings.storeApiNonce) {
			return window.wcSettings.storeApiNonce;
		}
		return '';
	}

	function fetchCartData() {
		var headers = { Accept: 'application/json' };
		var nonce = getStoreApiNonce();
		if (nonce) {
			headers.Nonce = nonce;
		}

		return window
			.fetch(getStoreApiUrl(), {
				credentials: 'same-origin',
				headers: headers,
			})
			.then(function (response) {
				if (!response.ok) {
					return null;
				}
				return response.json();
			})
			.then(function (data) {
				if (data) {
					syncMiniCartFromPayload(data);
				}
			})
			.catch(function () {});
	}

	function initMiniCartToggle() {
		var root = getRoot();
		var toggle = getToggle();
		var panel = getPanel();
		if (!root || !toggle || !panel) {
			return;
		}

		toggle.addEventListener('click', function (event) {
			event.preventDefault();
			event.stopPropagation();
			setMiniCartOpen(panel.hidden);
		});

		document.addEventListener('click', function (event) {
			if (!root.classList.contains('is-open')) {
				return;
			}
			if (root.contains(event.target)) {
				return;
			}
			setMiniCartOpen(false);
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && root.classList.contains('is-open')) {
				setMiniCartOpen(false);
				toggle.focus();
			}
		});

		panel.addEventListener('click', function (event) {
			var link = event.target && event.target.closest ? event.target.closest('a[href]') : null;
			if (link) {
				setMiniCartOpen(false);
			}
		});
	}

	function initBlocksStoreSubscribe() {
		var wpData = window.wp && window.wp.data;
		var cartStore = window.wc && window.wc.wcBlocksData && window.wc.wcBlocksData.cartStore;
		if (!wpData || !cartStore || typeof wpData.subscribe !== 'function') {
			return;
		}

		var lastSignature = '';

		wpData.subscribe(
			function () {
				var cart = wpData.select(cartStore).getCartData();
				if (!cart) {
					return;
				}
				var signature =
					String(cart.items_count) +
					':' +
					String(cart.totals && cart.totals.total_items) +
					':' +
					(cart.items ? cart.items.length : 0);
				if (signature === lastSignature) {
					return;
				}
				lastSignature = signature;
				syncMiniCartFromPayload(cart);
			},
			cartStore
		);

		var initial = wpData.select(cartStore).getCartData();
		if (initial) {
			syncMiniCartFromPayload(initial);
		}
	}

	function initFetchHook() {
		if (!window.fetch || window.fetch._abalturasCartHook) {
			return;
		}

		var nativeFetch = window.fetch.bind(window);

		window.fetch = function () {
			return nativeFetch.apply(window, arguments).then(function (response) {
				try {
					var req = arguments[0];
					var url = typeof req === 'string' ? req : req && req.url ? req.url : '';
					if (url.indexOf('/wc/store/v1/cart') !== -1 && response.ok) {
						response
							.clone()
							.json()
							.then(function (data) {
								syncMiniCartFromPayload(data);
							})
							.catch(function () {});
					}
				} catch (e) {
					// Sin bloqueo del fetch original.
				}
				return response;
			});
		};

		window.fetch._abalturasCartHook = true;
	}

	function initDocumentEvents() {
		['wc-blocks_added_to_cart', 'wc-blocks_removed_from_cart'].forEach(function (name) {
			document.body.addEventListener(name, function () {
				fetchCartData();
			});
		});
	}

	function initJQueryEvents() {
		if (!window.jQuery) {
			return;
		}

		window.jQuery(document.body).on(
			'added_to_cart removed_from_cart updated_cart_totals wc_fragments_refreshed',
			function (event, fragments) {
				if (fragments) {
					if (fragments[BADGE_SEL]) {
						var tmp = document.createElement('div');
						tmp.innerHTML = fragments[BADGE_SEL];
						var span = tmp.firstElementChild;
						if (span) {
							updateHeaderCartCount(span.hidden ? 0 : parseInt(span.textContent, 10) || 0);
						}
					}
					if (fragments[CONTENT_FRAGMENT_SEL]) {
						var wrap = document.createElement('div');
						wrap.innerHTML = fragments[CONTENT_FRAGMENT_SEL];
						var content = wrap.firstElementChild;
						if (content) {
							setPanelHtml(content.innerHTML);
						}
					}
					return;
				}
				fetchCartData();
			}
		);
	}

	function init() {
		initMiniCartToggle();
		initFetchHook();
		initDocumentEvents();
		initJQueryEvents();

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', initBlocksStoreSubscribe);
		} else {
			initBlocksStoreSubscribe();
		}
	}

	init();
})();
