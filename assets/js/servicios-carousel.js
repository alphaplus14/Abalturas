/**
 * Carrusel ligero — página Servicios Abalturas.
 */
(function () {
	'use strict';

	var activeAutoplayRoot = null;

	function pauseVideos( root ) {
		root.querySelectorAll( 'video' ).forEach( function ( video ) {
			video.pause();
		} );
	}

	function clearAutoplayTimer( state ) {
		if ( state.timer ) {
			clearInterval( state.timer );
			state.timer = null;
		}
	}

	function initCarousel( root ) {
		var track = root.querySelector( '.ab-svc-carousel__track' );
		var slides = Array.prototype.slice.call( root.querySelectorAll( '.ab-svc-carousel__slide' ) );
		var dotsWrap = root.querySelector( '.ab-svc-carousel__dots' );
		var prevBtn = root.querySelector( '.ab-svc-carousel__btn--prev' );
		var nextBtn = root.querySelector( '.ab-svc-carousel__btn--next' );
		var counter = root.querySelector( '[data-ab-svc-counter]' );
		var progress = root.querySelector( '[data-ab-svc-progress]' );
		var liveRegion = root.querySelector( '.ab-svc-carousel__live' );

		if ( ! track || slides.length < 2 ) {
			return;
		}

		var state = {
			index: 0,
			timer: null,
			autoplayMs: parseInt( root.getAttribute( 'data-autoplay' ) || '0', 10 ),
			autoplayInviewMs: parseInt( root.getAttribute( 'data-autoplay-inview' ) || '0', 10 ),
			isVisible: false,
			isHovered: false,
			isFocused: false,
			isDragging: false,
			dragStartX: 0,
			dragDeltaX: 0,
			reducedMotion: window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches,
			total: slides.length,
		};

		function getOffsetPercent( slideIndex, dragPx ) {
			var width = track.offsetWidth || 1;
			var base = -slideIndex * 100;
			if ( dragPx ) {
				return base + ( dragPx / width ) * 100;
			}
			return base;
		}

		function setTrackTransform( slideIndex, dragPx, animate ) {
			track.style.transition = animate && ! state.isDragging && ! state.reducedMotion
				? 'transform 0.45s cubic-bezier(0.22, 1, 0.36, 1)'
				: 'none';
			track.style.transform = 'translate3d(' + getOffsetPercent( slideIndex, dragPx ) + '%, 0, 0)';
		}

		function updateChrome( slideIndex ) {
			var humanIndex = slideIndex + 1;

			if ( counter ) {
				counter.textContent = humanIndex + ' / ' + state.total;
			}

			if ( dotsWrap ) {
				var dots = dotsWrap.querySelectorAll( '.ab-svc-carousel__dot' );
				dots.forEach( function ( dot, i ) {
					dot.classList.toggle( 'is-active', i === slideIndex );
					dot.setAttribute( 'aria-selected', i === slideIndex ? 'true' : 'false' );
				} );
			}

			if ( liveRegion ) {
				var caption = slides[ slideIndex ].querySelector( '.ab-svc-carousel__title' );
				liveRegion.textContent = caption
					? 'Imagen ' + humanIndex + ' de ' + state.total + ': ' + caption.textContent
					: 'Imagen ' + humanIndex + ' de ' + state.total;
			}

			if ( progress && state.reducedMotion ) {
				progress.classList.remove( 'is-running' );
				return;
			}

			if ( progress ) {
				progress.classList.remove( 'is-running' );
				void progress.offsetWidth;
				if ( shouldAutoplay() ) {
					progress.style.setProperty( '--ab-svc-progress-ms', getAutoplayMs() + 'ms' );
					progress.classList.add( 'is-running' );
				}
			}
		}

		function goTo( nextIndex, animate ) {
			state.index = ( nextIndex + slides.length ) % slides.length;
			setTrackTransform( state.index, 0, animate !== false );
			slides.forEach( function ( slide, i ) {
				slide.setAttribute( 'aria-hidden', i === state.index ? 'false' : 'true' );
			} );
			updateChrome( state.index );
			pauseVideos( root );

			var activeVideo = slides[ state.index ].querySelector( 'video' );
			if ( activeVideo && root.getAttribute( 'data-autoplay-video' ) === '1' ) {
				activeVideo.play().catch( function () {} );
			}
		}

		function getAutoplayMs() {
			if ( state.autoplayMs > 0 ) {
				return state.autoplayMs;
			}
			if ( state.autoplayInviewMs > 0 && state.isVisible ) {
				return state.autoplayInviewMs;
			}
			return 0;
		}

		function shouldAutoplay() {
			return getAutoplayMs() > 0
				&& state.isVisible
				&& ! state.isHovered
				&& ! state.isFocused
				&& ! state.isDragging
				&& ! state.reducedMotion;
		}

		function resetAutoplay() {
			if ( activeAutoplayRoot && activeAutoplayRoot !== root && activeAutoplayRoot._abSvcState ) {
				clearAutoplayTimer( activeAutoplayRoot._abSvcState );
				var otherProgress = activeAutoplayRoot.querySelector( '[data-ab-svc-progress]' );
				if ( otherProgress ) {
					otherProgress.classList.remove( 'is-running' );
				}
			}

			clearAutoplayTimer( state );

			if ( ! shouldAutoplay() ) {
				if ( activeAutoplayRoot === root ) {
					activeAutoplayRoot = null;
				}
				if ( progress ) {
					progress.classList.remove( 'is-running' );
				}
				return;
			}

			activeAutoplayRoot = root;
			root._abSvcState = state;
			state.timer = setInterval( function () {
				goTo( state.index + 1 );
			}, getAutoplayMs() );

			if ( progress ) {
				progress.style.setProperty( '--ab-svc-progress-ms', getAutoplayMs() + 'ms' );
				progress.classList.remove( 'is-running' );
				void progress.offsetWidth;
				progress.classList.add( 'is-running' );
			}
		}

		if ( dotsWrap ) {
			slides.forEach( function ( _slide, i ) {
				var dot = document.createElement( 'button' );
				dot.type = 'button';
				dot.className = 'ab-svc-carousel__dot' + ( i === 0 ? ' is-active' : '' );
				dot.setAttribute( 'role', 'tab' );
				dot.setAttribute( 'aria-label', 'Ir a imagen ' + ( i + 1 ) );
				dot.setAttribute( 'aria-selected', i === 0 ? 'true' : 'false' );
				dot.addEventListener( 'click', function () {
					goTo( i );
					resetAutoplay();
				} );
				dotsWrap.appendChild( dot );
			} );
		}

		if ( prevBtn ) {
			prevBtn.addEventListener( 'click', function () {
				goTo( state.index - 1 );
				resetAutoplay();
			} );
		}

		if ( nextBtn ) {
			nextBtn.addEventListener( 'click', function () {
				goTo( state.index + 1 );
				resetAutoplay();
			} );
		}

		root.addEventListener( 'keydown', function ( event ) {
			if ( event.key === 'ArrowLeft' ) {
				event.preventDefault();
				goTo( state.index - 1 );
				resetAutoplay();
			}
			if ( event.key === 'ArrowRight' ) {
				event.preventDefault();
				goTo( state.index + 1 );
				resetAutoplay();
			}
		} );

		root.addEventListener( 'mouseenter', function () {
			state.isHovered = true;
			resetAutoplay();
		} );

		root.addEventListener( 'mouseleave', function () {
			state.isHovered = false;
			resetAutoplay();
		} );

		root.addEventListener( 'focusin', function () {
			state.isFocused = true;
			resetAutoplay();
		} );

		root.addEventListener( 'focusout', function ( event ) {
			if ( ! root.contains( event.relatedTarget ) ) {
				state.isFocused = false;
				resetAutoplay();
			}
		} );

		var viewport = root.querySelector( '.ab-svc-carousel__viewport' );

		function onPointerDown( event ) {
			if ( event.pointerType === 'mouse' && event.button !== 0 ) {
				return;
			}
			state.isDragging = true;
			state.dragStartX = event.clientX;
			state.dragDeltaX = 0;
			root.classList.add( 'is-dragging' );
			if ( viewport && viewport.setPointerCapture ) {
				viewport.setPointerCapture( event.pointerId );
			}
			setTrackTransform( state.index, 0, false );
		}

		function onPointerMove( event ) {
			if ( ! state.isDragging ) {
				return;
			}
			state.dragDeltaX = event.clientX - state.dragStartX;
			setTrackTransform( state.index, state.dragDeltaX, false );
		}

		function onPointerEnd( event ) {
			if ( ! state.isDragging ) {
				return;
			}
			state.isDragging = false;
			root.classList.remove( 'is-dragging' );

			if ( viewport && viewport.releasePointerCapture ) {
				try {
					viewport.releasePointerCapture( event.pointerId );
				} catch ( err ) {
					// Sin captura activa.
				}
			}

			if ( Math.abs( state.dragDeltaX ) > 48 ) {
				goTo( state.dragDeltaX < 0 ? state.index + 1 : state.index - 1 );
			} else {
				setTrackTransform( state.index, 0, true );
			}

			state.dragDeltaX = 0;
			resetAutoplay();
		}

		if ( viewport ) {
			viewport.addEventListener( 'pointerdown', onPointerDown );
			viewport.addEventListener( 'pointermove', onPointerMove );
			viewport.addEventListener( 'pointerup', onPointerEnd );
			viewport.addEventListener( 'pointercancel', onPointerEnd );
		}

		if ( 'IntersectionObserver' in window ) {
			var observer = new IntersectionObserver(
				function ( entries ) {
					entries.forEach( function ( entry ) {
						if ( entry.target !== root ) {
							return;
						}
						state.isVisible = entry.isIntersecting && entry.intersectionRatio >= 0.45;
						resetAutoplay();
					} );
				},
				{ threshold: [ 0, 0.45, 0.65 ] }
			);
			observer.observe( root );
		} else {
			state.isVisible = true;
		}

		goTo( 0, false );
		resetAutoplay();
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		document.querySelectorAll( '[data-ab-servicios-carousel]' ).forEach( initCarousel );
	} );
})();
