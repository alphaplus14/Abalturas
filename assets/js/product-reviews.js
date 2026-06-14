/**
 * Valoraciones de producto — etiqueta de puntuación y accesibilidad.
 */
( function ( $ ) {
	'use strict';

	var LABELS = {
		'1': 'Deficiente — 1 estrella',
		'2': 'Regular — 2 estrellas',
		'3': 'Aceptable — 3 estrellas',
		'4': 'Bueno — 4 estrellas',
		'5': 'Excelente — 5 estrellas',
	};

	var DEFAULT_HINT = 'Toque las estrellas para calificar';

	function updateHint( form ) {
		var rating = form.querySelector( '#rating' );
		var hintEl = form.querySelector( '#ab-review-rating-hint' );

		if ( ! rating || ! hintEl ) {
			return;
		}

		var value = rating.value;
		hintEl.textContent = value && LABELS[ value ] ? LABELS[ value ] : DEFAULT_HINT;
		hintEl.classList.toggle( 'is-selected', Boolean( value && LABELS[ value ] ) );
	}

	function bindReviewForm( form ) {
		if ( form.dataset.abReviewBound === '1' ) {
			updateHint( form );
			return;
		}

		form.dataset.abReviewBound = '1';

		var rating = form.querySelector( '#rating' );
		if ( rating ) {
			rating.addEventListener( 'change', function () {
				updateHint( form );
			} );
		}

		updateHint( form );
	}

	function init() {
		document.querySelectorAll( '#review_form .comment-form, #review_form .ab-review-form' ).forEach( bindReviewForm );
	}

	function previewHint( starLink ) {
		var form = starLink.closest( 'form' );
		var hintEl = form && form.querySelector( '#ab-review-rating-hint' );
		var stars = starLink.closest( 'p.stars' );

		if ( ! hintEl || ! stars ) {
			return;
		}

		var index = Array.prototype.indexOf.call( stars.querySelectorAll( 'a' ), starLink ) + 1;
		hintEl.textContent = LABELS[ String( index ) ] || DEFAULT_HINT;
		hintEl.classList.add( 'is-preview' );
	}

	function clearPreviewHint( starsWrap ) {
		var form = starsWrap.closest( 'form' );
		if ( ! form ) {
			return;
		}
		var hintEl = form.querySelector( '#ab-review-rating-hint' );
		if ( hintEl ) {
			hintEl.classList.remove( 'is-preview' );
		}
		updateHint( form );
	}

	if ( typeof $ !== 'undefined' ) {
		$( document.body )
			.on( 'init', '.woocommerce-tabs, .wc-tabs-wrapper, #rating', init )
			.on( 'click keyup', '#respond p.stars a', function () {
				var form = this.closest( 'form' );
				if ( form ) {
					window.requestAnimationFrame( function () {
						updateHint( form );
					} );
				}
			} )
			.on( 'mouseenter', '#respond p.stars a', function () {
				previewHint( this );
			} )
			.on( 'mouseleave', '#respond p.stars', function () {
				clearPreviewHint( this );
			} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', function () {
			init();
			window.setTimeout( init, 120 );
		} );
	} else {
		init();
		window.setTimeout( init, 120 );
	}
}( window.jQuery ) );
