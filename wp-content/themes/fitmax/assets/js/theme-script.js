;var Rvdx_Theme_JS;

(function($) {
	'use strict';

	Rvdx_Theme_JS = {

		$window: $( window ),

		$body: $( 'body' ),

		threshold: 768,

		init: function() {
			this.page_preloader_init();
			this.eventsInit();
			this.toTopInit();
			this.responsiveMenuInit();
			this.magnificPopupInit();
			this.swiperInit();
			this.mobilePanelInit();
		},

		page_preloader_init: function(self) {
			if ($('.page-preloader-cover')[0]) {
				$( window ).on('load', function () {
					$( 'body' ).removeClass( 'website-loading' );

					if ( "onanimationend" in window && 'ontransitionend' in window ) {
						$('.page-preloader-cover')
							.on( 'animationend', removePreLoader )
							.on( 'transitionend', removePreLoader )
							.addClass( 'hide-loader' );
					} else {
						$('.page-preloader-cover').fadeTo(500, 0, removePreLoader);
					}

					function removePreLoader(){
						$( this ).remove();
					}
				});
			}
		},

		toTopInit: function() {
			if ($.isFunction(jQuery.fn.UItoTop)) {
				$().UItoTop({
					text: '',
					scrollSpeed: 600
				});
			}
		},

		responsiveMenuInit: function() {
			$( '.site-header .main-navigation' ).RvdxMenu( { 'threshold' : Rvdx_Theme_JS.threshold } );
		},

		magnificPopupInit: function() {

			if (typeof $.magnificPopup !== 'undefined') {

				//MagnificPopup init
				$('[data-popup="magnificPopup"]').magnificPopup({
					type: 'image'
				});

				$(".gallery > .gallery-item a").filter("[href$='.png'],[href$='.jpg']").magnificPopup({
					type: 'image',
					gallery: {
						enabled: true,
						navigateByImgClick: true,
					},
				});

			}
		},

		swiperInit: function() {
			if (typeof Swiper !== 'undefined') {

				//Swiper carousel init
				var mySwiper = new Swiper('.swiper-container', {
					// Optional parameters
					loop: true,
					spaceBetween: 10,

					// Navigation arrows
					navigation: {
						nextEl: '.swiper-button-next',
						prevEl: '.swiper-button-prev',
					},
				})

			}
		},

		mobilePanelInit: function() {
			var $mobilePanel = $( '.rvdx-mobile-panel' ),
				$body        = $( 'body' );

			if ( ! $mobilePanel[0] ) {
				return false;
			}

			var $manuToggle    = $( '.rvdx-mobile-panel__control--mobile-menu', $mobilePanel ),
				$sidebarToggle = $( '.rvdx-mobile-panel__control--sidebar', $mobilePanel );

			$sidebarToggle.on( 'click.rvdx-mobile-panel', function(){
				var toggle = $(this);

				$( '.active', $mobilePanel ).not( toggle ).removeClass( 'active' );
				toggle.toggleClass( 'active' );

				$body.removeClass( 'mobile-menu-visible' ).toggleClass( 'sidebar-visible' );
			} )

			if( typeof( elementor ) === 'undefined' && ! $('.rx-menu-on-mobile-panel.rx-mobile-menu')[0] ){
				$manuToggle.remove();
				return false;
			}

			$manuToggle.on( 'click.rvdx-mobile-panel', function(){
				var toggle = $(this),
					iconHolder = $('i', toggle),
					icon = iconHolder.attr( 'class' ) ===  iconHolder.data( 'icon' ) ? iconHolder.data( 'close-icon' ) : iconHolder.data( 'icon' ) ;

				$( '.active', $mobilePanel ).not( toggle ).removeClass( 'active' );
				toggle.toggleClass( 'active' );

				$('i', toggle).attr( 'class', icon );

				$body.removeClass( 'sidebar-visible' ).toggleClass( 'mobile-menu-visible' );
			} )
		},

		eventsInit: function() {
			Rvdx_Theme_JS.$window.on( 'resize.RvdxTheme orientationchange.RvdxTheme', Rvdx_Theme_JS.debounce( 50, Rvdx_Theme_JS.watcher.bind( this ) ) ).trigger( 'resize.RvdxTheme' );
		},

		/**
		 * Resize Event Watcher callback.
		 *
		 * @param  {Object} Resize or Orientationchange event.
		 * @return {void}
		 */
		watcher: function( event ) {

			if ( Rvdx_Theme_JS.isThreshold() ) {
				Rvdx_Theme_JS.$body.addClass( 'mobile-layout' );
				Rvdx_Theme_JS.$body.removeClass( 'desktop-layout' );
			} else {
				Rvdx_Theme_JS.$body.addClass( 'desktop-layout' );
				Rvdx_Theme_JS.$body.removeClass( 'mobile-layout' );
			}
		},

		/**
		 * Get mobile status.
		 *
		 * @return {boolean} Mobile Status
		 */
		isThreshold: function() {
			return ( Rvdx_Theme_JS.$window.width() < Rvdx_Theme_JS.threshold ) ? true : false;
		},

		/**
		 * Debounce the function call
		 *
		 * @param  {number}   threshold The delay.
		 * @param  {Function} callback  The function.
		 */
		debounce: function ( threshold, callback ) {
			var timeout;

			return function debounced( $event ) {
				function delayed() {
					callback.call( this, $event );
					timeout = null;
				}

				if ( timeout ) {
					clearTimeout( timeout );
				}

				timeout = setTimeout( delayed, threshold );
			};
		},
	};

	Rvdx_Theme_JS.init();

}(jQuery));
