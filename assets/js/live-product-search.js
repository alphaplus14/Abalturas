/**
 * Búsqueda predictiva de productos — dropdown AJAX.
 */
(function () {
	'use strict';

	var cfg = window.abalturasLiveSearch || {};
	var MIN_CHARS = cfg.minChars || 2;
	var DEBOUNCE_MS = cfg.debounce || 300;

	function escapeHtml(text) {
		return String(text)
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;');
	}

	function debounce(fn, wait) {
		var timer;
		return function () {
			var context = this;
			var args = arguments;
			clearTimeout(timer);
			timer = setTimeout(function () {
				fn.apply(context, args);
			}, wait);
		};
	}

	function initLiveSearch(root) {
		var input = root.querySelector('[data-abalturas-live-search-input]');
		var dropdown = root.querySelector('.abalturas-live-search__dropdown');
		var list = root.querySelector('[data-live-search-list]');
		var status = root.querySelector('[data-live-search-status]');
		var viewAll = root.querySelector('[data-live-search-view-all]');
		var spinner = root.querySelector('.abalturas-live-search__spinner');
		var form = root.querySelector('.abalturas-live-search__form');

		if (!input || !dropdown || !list || !status || !viewAll) {
			return;
		}

		var activeController = null;
		var lastTerm = '';

		function setExpanded(open) {
			input.setAttribute('aria-expanded', open ? 'true' : 'false');
			dropdown.hidden = !open;
			root.classList.toggle('is-open', open);
		}

		function setLoading(loading) {
			root.classList.toggle('is-loading', loading);
			if (spinner) {
				spinner.hidden = !loading;
			}
		}

		function clearResults() {
			list.innerHTML = '';
			status.hidden = true;
			status.textContent = '';
			viewAll.hidden = true;
		}

		function closeDropdown() {
			setExpanded(false);
			setLoading(false);
		}

		function renderItems(items, searchUrl) {
			clearResults();

			if (!items.length) {
				status.textContent = cfg.i18n && cfg.i18n.empty ? cfg.i18n.empty : 'No se encontraron productos';
				status.hidden = false;
				viewAll.hidden = true;
				return;
			}

			items.forEach(function (item) {
				var li = document.createElement('li');
				li.className = 'abalturas-live-search__item';
				li.setAttribute('role', 'option');

				var link = document.createElement('a');
				link.className = 'abalturas-live-search__link';
				link.href = item.url || '#';

				var imageWrap = document.createElement('span');
				imageWrap.className = 'abalturas-live-search__thumb';
				if (item.image) {
					var img = document.createElement('img');
					img.src = item.image;
					img.alt = '';
					img.width = 48;
					img.height = 48;
					img.loading = 'lazy';
					img.decoding = 'async';
					imageWrap.appendChild(img);
				}

				var body = document.createElement('span');
				body.className = 'abalturas-live-search__body';

				var name = document.createElement('span');
				name.className = 'abalturas-live-search__name';
				name.textContent = item.name || '';

				var price = document.createElement('span');
				price.className = 'abalturas-live-search__price';
				price.innerHTML = item.price_html || '';

				body.appendChild(name);
				body.appendChild(price);
				link.appendChild(imageWrap);
				link.appendChild(body);
				li.appendChild(link);
				list.appendChild(li);
			});

			viewAll.href = searchUrl || '#';
			viewAll.hidden = false;
		}

		function fetchResults(term) {
			if (activeController) {
				activeController.abort();
			}

			activeController = new AbortController();
			setLoading(true);
			setExpanded(true);
			status.textContent = cfg.i18n && cfg.i18n.loading ? cfg.i18n.loading : 'Buscando…';
			status.hidden = false;
			list.innerHTML = '';
			viewAll.hidden = true;

			var url = new URL(cfg.ajaxUrl, window.location.origin);
			url.searchParams.set('action', cfg.action || 'abalturas_live_product_search');
			url.searchParams.set('nonce', cfg.nonce || '');
			url.searchParams.set('term', term);

			fetch(url.toString(), {
				method: 'GET',
				credentials: 'same-origin',
				signal: activeController.signal,
			})
				.then(function (response) {
					if (!response.ok) {
						throw new Error('Network error');
					}
					return response.json();
				})
				.then(function (json) {
					setLoading(false);
					if (!json || !json.success) {
						renderItems([], '');
						return;
					}
					renderItems(json.data.items || [], json.data.search_url || '');
				})
				.catch(function (error) {
					if (error && error.name === 'AbortError') {
						return;
					}
					setLoading(false);
					renderItems([], '');
				});
		}

		var debouncedFetch = debounce(function (term) {
			fetchResults(term);
		}, DEBOUNCE_MS);

		input.addEventListener('input', function () {
			var term = input.value.trim();
			lastTerm = term;

			if (term.length < MIN_CHARS) {
				if (activeController) {
					activeController.abort();
				}
				setLoading(false);
				clearResults();
				if (term.length === 0) {
					closeDropdown();
				} else {
					setExpanded(true);
					status.textContent = cfg.i18n && cfg.i18n.minChars ? cfg.i18n.minChars : 'Escribe al menos 2 caracteres';
					status.hidden = false;
				}
				return;
			}

			debouncedFetch(term);
		});

		input.addEventListener('focus', function () {
			var term = input.value.trim();
			if (term.length >= MIN_CHARS) {
				setExpanded(true);
				if (!list.children.length && !status.textContent) {
					fetchResults(term);
				}
			}
		});

		input.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') {
				closeDropdown();
				input.blur();
			}
		});

		document.addEventListener('click', function (event) {
			if (!root.contains(event.target)) {
				closeDropdown();
			}
		});

		form.addEventListener('submit', function () {
			/* Mantiene envío clásico ?s=&post_type=product para SEO y sin JS. */
			closeDropdown();
		});
	}

	function boot() {
		if (!cfg.ajaxUrl) {
			return;
		}
		document.querySelectorAll('[data-abalturas-live-search]').forEach(initLiveSearch);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
