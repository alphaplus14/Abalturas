/**

 * Checkout Colombia — select dependiente Departamento → Ciudad.

 *

 * Blocks: reemplaza el input de ciudad por <select> nativo.

 * Listeners delegados (React reemplaza nodos al cambiar departamento).

 */

(function ($) {

	'use strict';



	var cfg = window.abalturasColombiaCities || {};

	var citiesByState =

		cfg.citiesByState && typeof cfg.citiesByState === 'object' ? cfg.citiesByState : {};

	var COUNTRY = cfg.country || 'CO';

	var PREFIXES = cfg.prefixes || ['billing', 'shipping'];



	var checkoutRoot = null;

	var observerStarted = false;

	var scanTimer = null;

	var isUpdatingDom = false;

	var lastStateByPrefix = Object.create(null);



	function getCheckoutRoot() {

		if (checkoutRoot && checkoutRoot.isConnected) {

			return checkoutRoot;

		}

		checkoutRoot =

			document.querySelector('.wc-block-checkout') ||

			document.querySelector('form.checkout') ||

			null;

		return checkoutRoot;

	}



	function getStateElement(prefix) {

		return (

			document.getElementById(prefix + '-state') ||

			document.getElementById(prefix + '_state')

		);

	}



	function getCountryElement(prefix) {

		return (

			document.getElementById(prefix + '-country') ||

			document.getElementById(prefix + '_country')

		);

	}



	function getCityWrapper(prefix) {

		var root = document.getElementById(prefix);

		if (!root) {

			return null;

		}

		return root.querySelector('.wc-block-components-address-form__city');

	}



	function getCityField(prefix) {

		return (

			document.getElementById(prefix + '-city') ||

			document.getElementById(prefix + '_city')

		);

	}



	function isColombia(prefix) {

		var countryEl = getCountryElement(prefix);

		if (!countryEl) {

			return true;

		}

		return String(countryEl.value || '').trim() === COUNTRY;

	}



	function getStoreCity(prefix) {

		if (!window.wp || !window.wp.data) {

			return '';

		}

		try {

			var cart = window.wp.data.select('wc/store/cart')?.getCartData?.();

			if (!cart) {

				return '';

			}

			var addr = prefix === 'shipping' ? cart.shippingAddress : cart.billingAddress;

			return String(addr?.city || '').trim();

		} catch (e) {

			return '';

		}

	}



	function updateStoreAddress(prefix, partial) {

		if (!window.wp || !window.wp.data) {

			return;

		}

		try {

			var select = window.wp.data.select('wc/store/cart');

			var dispatch = window.wp.data.dispatch('wc/store/cart');

			if (!select || !dispatch) {

				return;

			}

			var cart = select.getCartData && select.getCartData();

			if (!cart) {

				return;

			}

			if (prefix === 'shipping' && typeof dispatch.setShippingAddress === 'function') {

				dispatch.setShippingAddress(

					Object.assign({}, cart.shippingAddress || {}, partial)

				);

			}

			if (prefix === 'billing' && typeof dispatch.setBillingAddress === 'function') {

				dispatch.setBillingAddress(

					Object.assign({}, cart.billingAddress || {}, partial)

				);

			}

		} catch (e) {

			// Store API no disponible.

		}

	}



	function clearSelectOptions(select) {

		while (select.firstChild) {

			select.removeChild(select.firstChild);

		}

	}



	function addOption(select, value, label) {

		var option = document.createElement('option');

		option.value = value;

		option.textContent = label;

		select.appendChild(option);

	}



	function cityExistsInState(stateCode, city) {

		if (!city || !stateCode || !citiesByState[stateCode]) {

			return false;

		}

		return citiesByState[stateCode].indexOf(city) !== -1;

	}



	function populateCitySelect(select, prefix, stateCode, savedCity, resetCity) {

		clearSelectOptions(select);



		var i18n = cfg.i18n || {};



		if (!isColombia(prefix)) {

			addOption(select, '', i18n.selectCity || 'Seleccione una ciudad');

			select.disabled = true;

			select.value = '';

			return '';

		}



		if (!stateCode || !citiesByState[stateCode]) {

			addOption(

				select,

				'',

				i18n.selectDepartment || 'Seleccione un departamento primero'

			);

			select.disabled = true;

			select.value = '';

			return '';

		}



		addOption(select, '', i18n.selectCity || 'Seleccione una ciudad');



		var cities = citiesByState[stateCode];

		for (var i = 0; i < cities.length; i++) {

			addOption(select, cities[i], cities[i]);

		}



		select.disabled = false;



		if (resetCity || !savedCity || !cityExistsInState(stateCode, savedCity)) {

			select.value = '';

			return '';

		}



		select.value = savedCity;

		return savedCity;

	}



	function updateCityUiState(prefix, citySelect) {
		var wrapper = getCityWrapper(prefix);
		if (!wrapper || !citySelect) {
			return;
		}

		normalizeCityWrapper(wrapper);

		var shell = wrapper.querySelector('.wc-blocks-components-select');
		var hasValue = !!String(citySelect.value || '').trim();

		if (shell) {
			shell.classList.toggle('has-selected', hasValue);
			shell.classList.remove('is-active');
		}
	}



	function syncCityValue(prefix, citySelect, cityValue, fromUser) {

		var storeCity = getStoreCity(prefix);



		if (storeCity === cityValue && citySelect && citySelect.value === cityValue) {

			updateCityUiState(prefix, citySelect);

			return;

		}



		if (citySelect && citySelect.value !== cityValue) {

			citySelect.value = cityValue;

		}



		updateStoreAddress(prefix, { city: cityValue });

		updateCityUiState(prefix, citySelect);



		if (!document.querySelector('.wc-block-checkout') && fromUser && $) {

			$(document.body).trigger('update_checkout');

		}

	}



	function normalizeCityWrapper(wrapper) {
		if (!wrapper || !wrapper.dataset.abalturasCitySelect) {
			return;
		}
		wrapper.classList.remove(
			'wc-block-components-text-input',
			'is-active',
			'has-error',
			'is-open'
		);
		wrapper.classList.add('wc-block-components-state-input', 'abalturas-city-select-wrap');
	}



	function buildBlocksCitySelect(prefix, wrapper, forceReset) {

		var existingField = wrapper.querySelector('#' + prefix + '-city');

		var stateEl = getStateElement(prefix);

		var stateCode = stateEl ? String(stateEl.value || '').trim() : '';

		var savedCity = '';



		if (

			existingField &&

			existingField.tagName === 'INPUT' &&

			!forceReset

		) {

			savedCity = String(existingField.value || '').trim();

		} else if (!forceReset) {

			savedCity = getStoreCity(prefix);

		}



		if (savedCity && !cityExistsInState(stateCode, savedCity)) {

			savedCity = '';

		}



		isUpdatingDom = true;

		wrapper.innerHTML = '';

		wrapper.classList.remove(

			'wc-block-components-text-input',

			'is-active',

			'has-error',

			'is-open'

		);

		wrapper.classList.add('wc-block-components-state-input', 'abalturas-city-select-wrap');



		var selectShell = document.createElement('div');
		selectShell.className = 'wc-blocks-components-select abalturas-city-select';

		var container = document.createElement('div');
		container.className = 'wc-blocks-components-select__container';

		var stateLabelRef = document.querySelector(
			'#' + prefix + ' .wc-block-components-address-form__state .wc-blocks-components-select__label'
		);
		var label = document.createElement('label');
		label.className = stateLabelRef
			? stateLabelRef.className
			: 'wc-blocks-components-select__label';
		label.htmlFor = prefix + '-city';
		label.textContent = (cfg.i18n && cfg.i18n.cityLabel) || 'Ciudad';

		var select = document.createElement('select');
		select.size = 1;
		select.className = 'wc-blocks-components-select__select';

		select.id = prefix + '-city';

		select.name = prefix + '_city';

		select.required = true;

		select.dataset.abalturasPrefix = prefix;

		select.setAttribute(

			'autocomplete',

			'section-' + prefix + ' ' + prefix + ' address-level2'

		);

		select.setAttribute('aria-label', 'Ciudad');

		select.disabled = true;



		container.appendChild(label);

		container.appendChild(select);

		selectShell.appendChild(container);

		wrapper.appendChild(selectShell);

		wrapper.dataset.abalturasCitySelect = '1';

		isUpdatingDom = false;



		return { select: select, savedCity: savedCity };

	}



	function ensureBlocksCitySelect(prefix, forceReset) {

		var wrapper = getCityWrapper(prefix);

		if (!wrapper) {

			return getCityField(prefix);

		}



		var field = getCityField(prefix);



		if (!wrapper.dataset.abalturasCitySelect || !field || field.tagName !== 'SELECT') {

			return buildBlocksCitySelect(prefix, wrapper, forceReset).select;

		}



		normalizeCityWrapper(wrapper);

		wrapper.querySelectorAll('input[type="text"]').forEach(function (input) {

			input.remove();

		});



		return getCityField(prefix);

	}



	function refreshCityForPrefix(prefix, resetCity) {

		if (!isColombia(prefix)) {

			return;

		}



		var stateEl = getStateElement(prefix);

		if (!stateEl) {

			return;

		}



		var wrapper = getCityWrapper(prefix);

		var isBlocks = !!wrapper;

		var fieldBefore = getCityField(prefix);

		var reactReinjectedInput =

			isBlocks && fieldBefore && fieldBefore.tagName === 'INPUT';



		var citySelect = isBlocks

			? ensureBlocksCitySelect(prefix, resetCity || reactReinjectedInput)

			: getCityField(prefix);



		if (!citySelect || citySelect.tagName !== 'SELECT') {

			return;

		}



		if (!isBlocks) {

			citySelect.classList.add('abalturas-city-select__native');

		}



		citySelect.dataset.abalturasPrefix = prefix;



		var stateCode = String(stateEl.value || '').trim();

		var prevState = lastStateByPrefix[prefix];

		var deptChanged =

			resetCity ||

			reactReinjectedInput ||

			(prevState !== undefined && prevState !== stateCode);



		var savedCity = deptChanged

			? ''

			: String(citySelect.value || getStoreCity(prefix) || '').trim();



		if (savedCity && !cityExistsInState(stateCode, savedCity)) {

			savedCity = '';

			deptChanged = true;

		}



		var chosen = populateCitySelect(

			citySelect,

			prefix,

			stateCode,

			savedCity,

			deptChanged

		);



		lastStateByPrefix[prefix] = stateCode;

		updateCityUiState(prefix, citySelect);



		if (deptChanged) {

			window.requestAnimationFrame(function () {

				syncCityValue(prefix, citySelect, chosen, false);

			});

		} else if (chosen !== getStoreCity(prefix)) {

			updateStoreAddress(prefix, { city: chosen });

		}

	}



	function scanAll() {

		if (isUpdatingDom || !Object.keys(citiesByState).length) {

			return;

		}



		PREFIXES.forEach(function (prefix) {

			var stateEl = getStateElement(prefix);

			if (!stateEl || !isColombia(prefix)) {

				return;

			}



			var stateCode = String(stateEl.value || '').trim();

			var wrapper = getCityWrapper(prefix);

			var field = getCityField(prefix);

			var needsRebuild =

				wrapper &&

				(!wrapper.dataset.abalturasCitySelect ||

					!field ||

					field.tagName !== 'SELECT');



			if (needsRebuild) {

				refreshCityForPrefix(prefix, field && field.tagName === 'INPUT');

				return;

			}



			if (lastStateByPrefix[prefix] !== stateCode) {

				refreshCityForPrefix(prefix, lastStateByPrefix[prefix] !== undefined);

				return;

			}



			if (field && field.tagName === 'SELECT') {

				updateCityUiState(prefix, field);

			}

		});

	}



	function scheduleScan() {

		clearTimeout(scanTimer);

		scanTimer = setTimeout(scanAll, 60);

	}



	function onDelegatedChange(event) {

		var target = event.target;

		if (!target || !target.id) {

			return;

		}



		if (target.id === 'billing-city' || target.id === 'billing_city') {

			syncCityValue('billing', target, target.value, true);

			return;

		}



		if (target.id === 'shipping-city' || target.id === 'shipping_city') {

			syncCityValue('shipping', target, target.value, true);

			return;

		}



		if (

			target.id === 'billing-state' ||

			target.id === 'billing_state' ||

			target.id === 'billing-country' ||

			target.id === 'billing_country'

		) {

			if (target.id.indexOf('country') !== -1) {

				lastStateByPrefix.billing = undefined;

			}

			refreshCityForPrefix('billing', true);

			return;

		}



		if (

			target.id === 'shipping-state' ||

			target.id === 'shipping_state' ||

			target.id === 'shipping-country' ||

			target.id === 'shipping_country'

		) {

			if (target.id.indexOf('country') !== -1) {

				lastStateByPrefix.shipping = undefined;

			}

			refreshCityForPrefix('shipping', true);

		}

	}



	function onDelegatedFocus(event) {

		var target = event.target;

		if (!target || !target.id) {

			return;

		}

		if (

			target.id === 'billing-city' ||

			target.id === 'billing_city' ||

			target.id === 'shipping-city' ||

			target.id === 'shipping_city'

		) {

			var prefix = target.id.indexOf('billing') === 0 ? 'billing' : 'shipping';

			updateCityUiState(prefix, target);

		}

	}



	function bindDelegatedListeners() {

		var root = getCheckoutRoot();

		if (!root || root.dataset.abalturasCityDelegated) {

			return;

		}

		root.dataset.abalturasCityDelegated = '1';

		root.addEventListener('change', onDelegatedChange, true);

		root.addEventListener('focusin', onDelegatedFocus, true);

	}



	function observeCheckout() {

		if (observerStarted) {

			return;

		}



		var root = getCheckoutRoot();

		if (!root || typeof MutationObserver === 'undefined') {

			return;

		}



		observerStarted = true;



		var observer = new MutationObserver(function () {

			if (isUpdatingDom) {

				return;

			}

			scheduleScan();

		});



		observer.observe(root, { childList: true, subtree: true });

	}



	function init() {

		if (!Object.keys(citiesByState).length) {

			return;

		}



		bindDelegatedListeners();

		PREFIXES.forEach(function (prefix) {

			lastStateByPrefix[prefix] = undefined;

			refreshCityForPrefix(prefix, false);

		});

		observeCheckout();

	}



	$(init);

	$(document.body).on('updated_checkout init_checkout', init);

})(jQuery);


