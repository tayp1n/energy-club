// Promise polyfill
!function(e,n){"object"==typeof exports&&"undefined"!=typeof module?n():"function"==typeof define&&define.amd?define(n):n()}(0,function(){"use strict";function e(e){var n=this.constructor;return this.then(function(t){return n.resolve(e()).then(function(){return t})},function(t){return n.resolve(e()).then(function(){return n.reject(t)})})}function n(e){return!(!e||"undefined"==typeof e.length)}function t(){}function o(e){if(!(this instanceof o))throw new TypeError("Promises must be constructed via new");if("function"!=typeof e)throw new TypeError("not a function");this._state=0,this._handled=!1,this._value=undefined,this._deferreds=[],c(e,this)}function r(e,n){for(;3===e._state;)e=e._value;0!==e._state?(e._handled=!0,o._immediateFn(function(){var t=1===e._state?n.onFulfilled:n.onRejected;if(null!==t){var o;try{o=t(e._value)}catch(r){return void f(n.promise,r)}i(n.promise,o)}else(1===e._state?i:f)(n.promise,e._value)})):e._deferreds.push(n)}function i(e,n){try{if(n===e)throw new TypeError("A promise cannot be resolved with itself.");if(n&&("object"==typeof n||"function"==typeof n)){var t=n.then;if(n instanceof o)return e._state=3,e._value=n,void u(e);if("function"==typeof t)return void c(function(e,n){return function(){e.apply(n,arguments)}}(t,n),e)}e._state=1,e._value=n,u(e)}catch(r){f(e,r)}}function f(e,n){e._state=2,e._value=n,u(e)}function u(e){2===e._state&&0===e._deferreds.length&&o._immediateFn(function(){e._handled||o._unhandledRejectionFn(e._value)});for(var n=0,t=e._deferreds.length;t>n;n++)r(e,e._deferreds[n]);e._deferreds=null}function c(e,n){var t=!1;try{e(function(e){t||(t=!0,i(n,e))},function(e){t||(t=!0,f(n,e))})}catch(o){if(t)return;t=!0,f(n,o)}}var a=setTimeout;o.prototype["catch"]=function(e){return this.then(null,e)},o.prototype.then=function(e,n){var o=new this.constructor(t);return r(this,new function(e,n,t){this.onFulfilled="function"==typeof e?e:null,this.onRejected="function"==typeof n?n:null,this.promise=t}(e,n,o)),o},o.prototype["finally"]=e,o.all=function(e){return new o(function(t,o){function r(e,n){try{if(n&&("object"==typeof n||"function"==typeof n)){var u=n.then;if("function"==typeof u)return void u.call(n,function(n){r(e,n)},o)}i[e]=n,0==--f&&t(i)}catch(c){o(c)}}if(!n(e))return o(new TypeError("Promise.all accepts an array"));var i=Array.prototype.slice.call(e);if(0===i.length)return t([]);for(var f=i.length,u=0;i.length>u;u++)r(u,i[u])})},o.resolve=function(e){return e&&"object"==typeof e&&e.constructor===o?e:new o(function(n){n(e)})},o.reject=function(e){return new o(function(n,t){t(e)})},o.race=function(e){return new o(function(t,r){if(!n(e))return r(new TypeError("Promise.race accepts an array"));for(var i=0,f=e.length;f>i;i++)o.resolve(e[i]).then(t,r)})},o._immediateFn="function"==typeof setImmediate&&function(e){setImmediate(e)}||function(e){a(e,0)},o._unhandledRejectionFn=function(e){void 0!==console&&console&&console.warn("Possible Unhandled Promise Rejection:",e)};var l=function(){if("undefined"!=typeof self)return self;if("undefined"!=typeof window)return window;if("undefined"!=typeof global)return global;throw Error("unable to locate global object")}();"Promise"in l?l.Promise.prototype["finally"]||(l.Promise.prototype["finally"]=e):l.Promise=o});

( function( $, elementor ) {
	'use strict';

	var RxThemeAssistant = {

		addedScripts: {},

		addedStyles: {},

		addedAssetsPromises: [],

		devMode: rxThemeAssistant.devMode || 'false',

		init: function() {

			var widgets = {
				'rx-theme-assistant-navigation.default' : RxThemeAssistant.widgetNavigation,
				'rx-theme-assistant-accordion.default': RxThemeAssistant.accordionInit,
				'rx-theme-assistant-map.default' : RxThemeAssistant.widgetMap,
				'rx-theme-assistant-instagram-gallery.default' : RxThemeAssistant.widgetInstagramGallery,
				'rx-theme-assistant-timeline.default' : RxThemeAssistant.widgetTimeLine,
				'rx-theme-assistant-horizontal-timeline.default': RxThemeAssistant.widgetHorizontalTimeline,
				'rx-theme-assistant-posts.default' : RxThemeAssistant.widgetPosts,
				'rx-theme-assistant-portfolio.default' : RxThemeAssistant.widgetPortfolio,
				'rx-theme-assistant-auth-links.default' : RxThemeAssistant.widgetAuthLinks,
				'rx-theme-assistant-tabs.default': RxThemeAssistant.tabsInit,
				'rx-theme-assistant-table.default': RxThemeAssistant.widgetTable,
				'rx-theme-assistant-shop-cart.default': RxThemeAssistant.refreshCart,
				'rx-theme-assistant-dynamic-posts.default': RxThemeAssistant.dynamicPostsCarousel,
				'rx-theme-assistant-countdown-timer.default' : RxThemeAssistant.widgetCountdown,
				'rx-theme-assistant-testimonials.default' : RxThemeAssistant.widgetTestimonials,
			};

			$.each( widgets, function( widget, callback ) {
				elementor.hooks.addAction( 'frontend/element_ready/' + widget, callback );
			} );

			$( document )
				.on( 'click.RxThemeAssistant', '.rx-search__popup-trigger', RxThemeAssistant.searchPopupSwitch )
				.on( 'click.RxThemeAssistant', '.rx-search__popup-close', RxThemeAssistant.searchPopupSwitch );

			elementor.hooks.addAction( 'frontend/element_ready/section', RxThemeAssistant.elementorSection );
			elementor.hooks.addAction( 'frontend/element_ready/widget', RxThemeAssistant.elementorWidget );
			elementor.hooks.addAction( 'frontend/element_ready/section', RxThemeAssistant.sectionActions );

			RxThemeAssistant.stickUpHeaderInit();
		},

		widgetInstagramGallery: function( $scope ) {
			var $target         = $scope.find( '.rx-theme-assistant-instagram-gallery__instance' ),
				instance        = null,
				defaultSettings = {},
				settings        = {};

			if ( ! $target.length ) {
				return;
			}

			settings = $target.data( 'settings' );

			/*
			 * Default Settings
			 */
			defaultSettings = {
				layoutType: 'masonry',
				columns: 3,
				columnsTablet: 2,
				columnsMobile: 1,
			}

			/**
			 * Checking options, settings and options merging
			 */
			$.extend( defaultSettings, settings );

			if ( 'masonry' === settings.layoutType ) {
				salvattore.init();
			}

			if ( 'carousel' === settings.layoutType ) {
				var carousel = $scope.find( '.rx-theme-assistant-carousel' );

				if ( ! carousel.length ) {
					return;
				}

				RxThemeAssistant.initCarousel( carousel.find( '.rx-theme-assistant-instagram-gallery__instance' ), carousel.data( 'slider_options' ) );
			}

		},

		widgetTimeLine: function ( $scope ){
			var $target = $scope.find( '.rx-theme-assistant-timeline' ),
				instance = null;

			if ( ! $target.length ) {
				return;
			}

			instance = new RxThemeAssistantTimeLine( $target );
			instance.init();
		},

		widgetHorizontalTimeline: function( $scope ) {
			var $timeline         = $scope.find( '.rx-theme-assistant-hor-timeline' ),
				$timelineTrack    = $scope.find( '.rx-theme-assistant-hor-timeline-track' ),
				$items            = $scope.find( '.rx-theme-assistant-hor-timeline-item' ),
				$arrows           = $scope.find( '.rx-theme-assistant-arrow' ),
				$nextArrow        = $scope.find( '.rx-theme-assistant-next-arrow' ),
				$prevArrow        = $scope.find( '.rx-theme-assistant-prev-arrow' ),
				columns           = $timeline.data( 'columns' ) || {},
				desktopColumns    = columns.desktop || 3,
				tabletColumns     = columns.tablet || desktopColumns,
				mobileColumns     = columns.mobile || tabletColumns,
				firstMouseEvent   = true,
				currentDeviceMode = elementorFrontend.getCurrentDeviceMode(),
				prevDeviceMode    = currentDeviceMode,
				itemsCount        = $scope.find( '.rx-theme-assistant-hor-timeline-list--middle .rx-theme-assistant-hor-timeline-item' ).length,
				currentTransform  = 0,
				currentPosition   = 0,
				transform = {
					desktop: 100 / desktopColumns,
					tablet:  100 / tabletColumns,
					mobile:  100 / mobileColumns
				},
				maxPosition = {
					desktop: Math.max( 0, (itemsCount - desktopColumns) ),
					tablet:  Math.max( 0, (itemsCount - tabletColumns) ),
					mobile:  Math.max( 0, (itemsCount - mobileColumns) )
				};

			if ( 'ontouchstart' in window || 'ontouchend' in window ) {
				$items.on( 'touchend.rxThemeAssistantHorTimeline', function( event ) {
					var itemId = $( this ).data( 'item-id' );

					$scope.find( '.elementor-repeater-item-' + itemId ).toggleClass( 'is-hover' );
				} );
			} else {
				$items.on( 'mouseenter.rxThemeAssistantHorTimeline mouseleave.rxThemeAssistantHorTimeline', function( event ) {

					if ( firstMouseEvent && 'mouseleave' === event.type ) {
						return;
					}

					if ( firstMouseEvent && 'mouseenter' === event.type ) {
						firstMouseEvent = false;
					}

					var itemId = $( this ).data( 'item-id' );

					$scope.find( '.elementor-repeater-item-' + itemId ).toggleClass( 'is-hover' );
				} );
			}

			// Set Line Position
			setLinePosition();
			$( window ).on( 'resize.rxThemeAssistantHorTimeline orientationchange.rxThemeAssistantHorTimeline', setLinePosition );

			function setLinePosition() {
				var $line             = $scope.find( '.rx-theme-assistant-hor-timeline__line' ),
					$firstPoint       = $scope.find( '.rx-theme-assistant-hor-timeline-item__point-content:first' ),
					$lastPoint        = $scope.find( '.rx-theme-assistant-hor-timeline-item__point-content:last' ),
					firstPointLeftPos = $firstPoint.position().left + parseInt( $firstPoint.css( 'marginLeft' ) ),
					lastPointLeftPos  = $lastPoint.position().left + parseInt( $lastPoint.css( 'marginLeft' ) ),
					pointWidth        = $firstPoint.outerWidth();

				$line.css( {
					'left': firstPointLeftPos + pointWidth/2,
					'width': lastPointLeftPos - firstPointLeftPos
				} );

				// var $progressLine   = $scope.find( '.rx-theme-assistant-hor-timeline__line-progress' ),
				// 	$lastActiveItem = $scope.find( '.rx-theme-assistant-hor-timeline-list--middle .rx-theme-assistant-hor-timeline-item.is-active:last' );
				//
				// if ( $lastActiveItem[0] ) {
				// 	var $lastActiveItemPointWrap = $lastActiveItem.find( '.rx-theme-assistant-hor-timeline-item__point' ),
				// 		progressLineWidth        = $lastActiveItemPointWrap.position().left + $lastActiveItemPointWrap.outerWidth() - firstPointLeftPos - pointWidth / 2;
				//
				// 	$progressLine.css( {
				// 		'width': progressLineWidth
				// 	} );
				// }
			}

			// Arrows Navigation Type
			if ( $nextArrow[0] && maxPosition[ currentDeviceMode ] === 0 ) {
				$nextArrow.addClass( 'rx-theme-assistant-arrow-disabled' );
			}

			if ( $arrows[0] ) {
				$arrows.on( 'click.rxThemeAssistantHorTimeline', function( event ){
					var $this = $( this ),
						direction = $this.hasClass( 'rx-theme-assistant-next-arrow' ) ? 'next' : 'prev',
						currentDeviceMode = elementorFrontend.getCurrentDeviceMode();

					if ( 'next' === direction && currentPosition < maxPosition[ currentDeviceMode ] ) {
						currentTransform -= transform[ currentDeviceMode ];
						currentPosition += 1;
					}

					if ( 'prev' === direction && currentPosition > 0 ) {
						currentTransform += transform[ currentDeviceMode ];
						currentPosition -= 1;
					}

					if ( currentPosition > 0 ) {
						$prevArrow.removeClass( 'rx-theme-assistant-arrow-disabled' );
					} else {
						$prevArrow.addClass( 'rx-theme-assistant-arrow-disabled' );
					}

					if ( currentPosition === maxPosition[ currentDeviceMode ] ) {
						$nextArrow.addClass( 'rx-theme-assistant-arrow-disabled' );
					} else {
						$nextArrow.removeClass( 'rx-theme-assistant-arrow-disabled' );
					}

					if ( currentPosition === 0 ) {
						currentTransform = 0;
					}

					$timelineTrack.css({
						'transform': 'translateX(' + currentTransform + '%)'
					});

				} );
			}

			setArrowPosition();
			$( window ).on( 'resize.rxThemeAssistantHorTimeline orientationchange.rxThemeAssistantHorTimeline', setArrowPosition );
			$( window ).on( 'resize.rxThemeAssistantHorTimeline orientationchange.rxThemeAssistantHorTimeline', timelineSliderResizeHandler );

			function setArrowPosition() {
				if ( ! $arrows[0] ) {
					return;
				}

				var $middleList = $scope.find( '.rx-theme-assistant-hor-timeline-list--middle' ),
					middleListTopPosition = $middleList.position().top,
					middleListHeight = $middleList.outerHeight();

				$arrows.css({
					'top': middleListTopPosition + middleListHeight/2
				});
			}

			function timelineSliderResizeHandler( event ) {
				if ( ! $timeline.hasClass( 'rx-theme-assistant-hor-timeline--arrows-nav' ) ) {
					return;
				}

				var currentDeviceMode = elementorFrontend.getCurrentDeviceMode(),
					resetSlider = function() {
						$prevArrow.addClass( 'rx-theme-assistant-arrow-disabled' );

						if ( $nextArrow.hasClass( 'rx-theme-assistant-arrow-disabled' ) ) {
							$nextArrow.removeClass( 'rx-theme-assistant-arrow-disabled' );
						}

						if ( maxPosition[ currentDeviceMode ] === 0 ) {
							$nextArrow.addClass( 'rx-theme-assistant-arrow-disabled' );
						}

						currentTransform = 0;
						currentPosition = 0;

						$timelineTrack.css({
							'transform': 'translateX(0%)'
						});
					};

				switch ( currentDeviceMode ) {
					case 'desktop':
						if ( 'desktop' !== prevDeviceMode ) {
							resetSlider();
							prevDeviceMode = 'desktop';
						}
						break;

					case 'tablet':
						if ( 'tablet' !== prevDeviceMode ) {
							resetSlider();
							prevDeviceMode = 'tablet';
						}
						break;

					case 'mobile':
						if ( 'mobile' !== prevDeviceMode ) {
							resetSlider();
							prevDeviceMode = 'mobile';
						}
						break;
				}
			}
		},

		widgetPosts: function ( $scope ) {

			var $target = $scope.find( '.rx-theme-assistant-carousel' );

			if ( ! $target.length ) {
				return;
			}

			RxThemeAssistant.initCarousel( $target.find( '.rx-theme-assistant-posts' ), $target.data( 'slider_options' ) );

		},

		widgetPortfolio: function( $scope ) {
			var $target = $scope.find( '.rx-theme-assistant-portfolio' ),
				instance = null,
				settings = {};

			if ( ! $target.length ) {
				return;
			}

			settings = $target.data( 'settings' );
			instance = new RxThemeAssistantPortfolio( $target, settings );
			instance.init();
		},

		widgetMap: function( $scope ) {

			var $container = $scope.find( '.rx-theme-assistant-map' ),
				map,
				init,
				pins;

			if ( ! window.google || ! $container.length ) {
				return;
			}

			init = $container.data( 'init' );
			pins = $container.data( 'pins' );
			map  = new google.maps.Map( $container[0], init );

			if ( pins ) {
				$.each( pins, function( index, pin ) {

					var marker,
						infowindow,
						pinData = {
							position: pin.position,
							map: map
						};

					if ( '' !== pin.image ) {
						pinData.icon = pin.image;
					}

					marker = new google.maps.Marker( pinData );

					if ( '' !== pin.desc ) {
						infowindow = new google.maps.InfoWindow({
							content: pin.desc,
							disableAutoPan: true
						});
					}

					marker.addListener( 'click', function() {
						infowindow.setOptions({ disableAutoPan: false });
						infowindow.open( map, marker );
					});

					if ( 'visible' === pin.state && '' !== pin.desc ) {
						infowindow.open( map, marker );
					}

				});
			}

		},

		widgetAuthLinks: function( $scope ) {

			if ( ! elementor ) {
				return;
			}

			if ( ! window.RxThemeAssistantEditor ) {
				return;
			}

			if ( ! window.RxThemeAssistantEditor.activeSection ) {
				$scope.find( '.rx-auth-links__login' ).css( 'display', 'none' );
				$scope.find( '.rx-auth-links__register' ).css( 'display', 'none' );
				return;
			}

			var section      = window.RxThemeAssistantEditor.activeSection;
			var isLogout     = -1 !== [ 'section_logout_link', 'section_logout_link_style' ].indexOf( section );
			var isRegistered = -1 !== [ 'section_registered_link', 'section_registered_link_style' ].indexOf( section );

			if ( isLogout ) {
				$scope.find( '.rx-auth-links__login' ).css( 'display', 'none' );
			} else {
				$scope.find( '.rx-auth-links__logout' ).css( 'display', 'none' );
			}

			if ( isRegistered ) {
				$scope.find( '.rx-auth-links__register' ).css( 'display', 'none' );
			} else {
				$scope.find( '.rx-auth-links__registered' ).css( 'display', 'none' );
			}
		},

		widgetNavigation: function( $scope ) {

			if ( $scope.data( 'initialized' ) ) {
				return;
			}

			$scope.data( 'initialized', true );

			var hoverClass        = 'rx-navigation-hover',
				hoverOutClass     = 'rx-navigation-hover-out',
				mobileActiveClass = $( '.rx-mobile-menu', $scope ).data( 'menu-active-class' );

			if( $( '.rx-navigation-wrap', $scope).hasClass('rx-menu-on-mobile-panel') ){
				$('body').addClass('rx-navigation--on-mobile-panel');
			}

			$( '.rx-mobile-menu', $scope ).data( 'mobile-menu-scroll', false );

			$scope.find( '.rx-navigation:not(.rx-navigation--vertical-sub-bottom)' ).hoverIntent({
				over: function() {
					$( this ).addClass( hoverClass );
				},
				out: function() {
					var $this = $( this );
					$this.removeClass( hoverClass );
					$this.addClass( hoverOutClass );
					setTimeout( function() {
						$this.removeClass( hoverOutClass );
					}, 200 );
				},
				timeout: 200,
				selector: '.menu-item-has-children'
			});

			if ( RxThemeAssistantTools.mobileAndTabletCheck() ) {
				$scope.find( '.rx-navigation:not(.rx-navigation--vertical-sub-bottom)' ).on( 'click.rxNavigation', '.menu-item > a', clickItemOnMobile );

				$( document ).on( 'touchstart.rxNavigation', prepareHideSubMenus );
				$( document ).on( 'touchend.rxNavigation', hideSubMenus );
			} else {
				$scope.find( '.rx-navigation:not(.rx-navigation--vertical-sub-bottom)' ).on( 'click.rxNavigation', '.menu-item > a', clickItem );
			}

			function clickItemOnMobile( event ) {
				var $this = $( event.currentTarget ).parent( '.menu-item' ),
					href = $( this ).attr('href'),
					subMenu =  $( '.rx-navigation__sub', $this ),
					mobilePanel = $( '.rvdx-mobile-panel .rvdx-mobile-panel__control--mobile-menu' );

				if( ! subMenu[0] || $this.hasClass( hoverClass ) && href && '#' !== href ){
					if( mobilePanel[0] ){
						mobilePanel.trigger( 'click.rvdx-mobile-panel');
					}

					window.location.href = href;
				}

				$this.toggleClass( hoverClass );

				return !1;
			}

			function clickItem( event ) {
				var $currentTarget  = $( event.currentTarget ),
					$menuItem       = $currentTarget.closest( '.menu-item' ),
					$hamburgerPanel = $menuItem.closest( '.rx-hamburger-panel' );

				if ( ! $menuItem.hasClass( 'menu-item-has-children' ) || $menuItem.hasClass( hoverClass ) ) {

					if ( $hamburgerPanel[0] && $hamburgerPanel.hasClass( 'open-state' ) ) {
						$hamburgerPanel.removeClass( 'open-state' );
						$( 'html' ).removeClass( 'rx-hamburger-panel-visible' );
					}

				}
			}

			var scrollOffset;

			function prepareHideSubMenus( event ) {
				scrollOffset = $( window ).scrollTop();
			}

			function hideSubMenus( event ) {
				var $menu = $scope.find( '.rx-navigation' );

				if ( 'touchend' === event.type && scrollOffset !== $( window ).scrollTop() ) {
					return;
				}

				if ( $( event.target ).closest( $menu ).length ) {
					return;
				}

				var $openMenuItems = $( '.menu-item-has-children.' + hoverClass, $menu );

				if ( ! $openMenuItems[0] ) {
					return;
				}

				$openMenuItems.removeClass( hoverClass );
				$openMenuItems.addClass( hoverOutClass );

				setTimeout( function() {
					$openMenuItems.removeClass( hoverOutClass );
				}, 200 );

				if ( $menu.hasClass( 'rx-navigation--vertical-sub-bottom' ) ) {
					$( '.rx-navigation__sub', $openMenuItems ).slideUp( 200 );
				}

				event.stopPropagation();
			}

			// START Vertical Layout: Sub-menu at the bottom
			$scope.find( '.rx-navigation--vertical-sub-bottom' ).on( 'click.rxNavigation', '.menu-item > a', verticalSubBottomHandler );

			function verticalSubBottomHandler( event ) {
				var $currentTarget  = $( event.currentTarget ),
					$menuItem       = $currentTarget.closest( '.menu-item' ),
					$siblingsItems  = $menuItem.siblings( '.menu-item.menu-item-has-children' ),
					$subMenu        = $( '.rx-navigation__sub:first', $menuItem ),
					$hamburgerPanel = $menuItem.closest( '.rx-hamburger-panel' );

				if ( ! $menuItem.hasClass( 'menu-item-has-children' ) || $menuItem.hasClass( hoverClass ) ) {

					if ( $scope.find( '.rx-navigation-wrap' ).hasClass( mobileActiveClass ) ) {
						$scope.find( '.rx-navigation-wrap' ).removeClass( mobileActiveClass );
					}

					if ( $hamburgerPanel[0] && $hamburgerPanel.hasClass( 'open-state' ) ) {
						$hamburgerPanel.removeClass( 'open-state' );
						$( 'html' ).removeClass( 'rx-hamburger-panel-visible' );
					}

					return;
				}

				event.preventDefault();
				event.stopPropagation();

				if ( $siblingsItems[0] ) {
					$siblingsItems.removeClass( hoverClass );
					$( '.menu-item-has-children', $siblingsItems ).removeClass( hoverClass );
					$( '.rx-navigation__sub', $siblingsItems ).slideUp( 200 );
				}

				if ( $subMenu[0] ) {
					$subMenu.slideDown( 200 );
					$menuItem.addClass( hoverClass );
				}
			}

			$( document ).on( 'click.rxNavigation', hideVerticalSubBottomMenus );

			function hideVerticalSubBottomMenus( event ) {
				if ( ! $scope.find( '.rx-navigation' ).hasClass( 'rx-navigation--vertical-sub-bottom' ) ) {
					return;
				}

				hideSubMenus( event );
			}
			// END Vertical Layout: Sub-menu at the bottom

			// Mobile trigger click event
			$( '.rx-navigation__mobile-trigger', $scope ).on( 'click.rxNavigation', function( event ) {
				$( this ).closest( '.rx-navigation-wrap' ).toggleClass( mobileActiveClass );
			} );

			// START Mobile Layout: Left-side, Right-side
			if ( 'ontouchend' in window ) {
				$( document ).on( 'touchend.rxMobileNavigation', removeMobileActiveClass );
			} else {
				$( document ).on( 'click.rxMobileNavigation', removeMobileActiveClass );
			}

			function removeMobileActiveClass( event ) {
				var mobileLayout = $scope.find( '.rx-navigation-wrap' ).data( 'mobile-layout' ),
					$navWrap     = $scope.find( '.rx-navigation-wrap' ),
					$trigger     = $scope.find( '.rx-navigation__mobile-trigger' ),
					$menu        = $scope.find( '.rx-navigation' );

				if ( 'left-side' !== mobileLayout && 'right-side' !== mobileLayout ) {
					return;
				}

				if ( 'touchend' === event.type && scrollOffset !== $( window ).scrollTop() ) {
					return;
				}

				if ( $( event.target ).closest( $trigger ).length || $( event.target ).closest( $menu ).length ) {
					return;
				}

				if ( ! $navWrap.hasClass( mobileActiveClass ) ) {
					return;
				}

				$navWrap.removeClass( mobileActiveClass );

				event.stopPropagation();
			}

			$( '.rx-navigation__mobile-close-btn', $scope ).on( 'click.rxMobileNavigation', function( event ) {
				$( '.rvdx-mobile-panel__control--mobile-menu', '.rvdx-mobile-panel' ).trigger( 'click.rvdx-mobile-panel' );
				$( this ).closest( '.rx-navigation-wrap' ).removeClass( mobileActiveClass );
			} );

			// END Mobile Layout: Left-side, Right-side

			// START Mobile Layout: Full-width
			var initMobileFullWidthCss = false;

			setFullWidthMenuPosition();
			$( window ).on( 'resize.rxMobileNavigation', setFullWidthMenuPosition );

			function setFullWidthMenuPosition() {
				var mobileLayout = $scope.find( '.rx-navigation-wrap' ).data( 'mobile-layout' );

				if ( 'full-width' !== mobileLayout ) {
					return;
				}

				var $menu = $scope.find( '.rx-navigation' ),
					currentDeviceMode = elementorFrontend.getCurrentDeviceMode();

				if ( 'mobile' !== currentDeviceMode ) {
					if ( initMobileFullWidthCss ) {
						$menu.css( { 'left': '' } );
						initMobileFullWidthCss = false;
					}
					return;
				}

				if ( initMobileFullWidthCss ) {
					$menu.css( { 'left': '' } );
				}

				var offset = - $menu.offset().left;

				$menu.css( { 'left': offset } );
				initMobileFullWidthCss = true;
			}
			// END Mobile Layout: Full-width

			if ( RxThemeAssistantTools.isEditMode() ) {
				$scope.data( 'initialized', false );
			}
		},

		tabsInit: function( $scope ) {
			var $target         = $( '.rx-theme-assistant-tabs', $scope ).first(),
				$controlWrapper = $( '.rx-theme-assistant-tabs__control-wrapper', $target ).first(),
				$contentWrapper = $( '.rx-theme-assistant-tabs__content-wrapper', $target ).first(),
				$controlList    = $( '> .rx-theme-assistant-tabs__control', $controlWrapper ),
				$contentList    = $( '> .rx-theme-assistant-tabs__content', $contentWrapper ),
				settings        = $target.data( 'settings' ) || {},
				toogleEvents    = 'mouseenter mouseleave',
				scrollOffset,
				autoSwitchInterval = null,
				curentHash      = window.location.hash || false,
				tabsArray       = curentHash ? curentHash.replace( '#', '' ).split( '&' ) : false;

			if ( 'click' === settings['event'] ) {
				addClickEvent();
			} else {
				addMouseEvent();
			}

			if ( settings['autoSwitch'] ) {

				var startIndex        = settings['activeIndex'],
					currentIndex      = startIndex,
					controlListLength = $controlList.length;

				autoSwitchInterval = setInterval( function() {

					if ( currentIndex < controlListLength - 1 ) {
						currentIndex++;
					} else {
						currentIndex = 0;
					}

					switchTab( currentIndex );

				}, +settings['autoSwitchDelay'] );
			}

			$( window ).on( 'resize.rxThemeAssistant orientationchange.rxThemeAssistant', function() {
				$contentWrapper.css( { 'height': 'auto' } );
			} );

			function addClickEvent() {
				$controlList.on( 'click.rxThemeAssistant', function() {
					var $this = $( this ),
						tabId = +$this.data( 'tab' ) - 1;

					clearInterval( autoSwitchInterval );
					switchTab( tabId );
				});
			}

			function addMouseEvent() {
				if ( 'ontouchend' in window || 'ontouchstart' in window ) {
					$controlList.on( 'touchstart', function( event ) {
						scrollOffset = $( window ).scrollTop();
					} );

					$controlList.on( 'touchend', function( event ) {
						var $this = $( this ),
							tabId = +$this.data( 'tab' ) - 1;

						if ( scrollOffset !== $( window ).scrollTop() ) {
							return false;
						}

						clearInterval( autoSwitchInterval );
						switchTab( tabId );
					} );

				} else {
					$controlList.on( 'mouseenter', function( event ) {
						var $this = $( this ),
							tabId = +$this.data( 'tab' ) - 1;

						clearInterval( autoSwitchInterval );
						switchTab( tabId );
					} );
				}
			}

			function switchTab( curentIndex ) {
				var $activeControl      = $controlList.eq( curentIndex ),
					$activeContent      = $contentList.eq( curentIndex ),
					activeContentHeight = 'auto',
					timer;

				$contentWrapper.css( { 'height': $contentWrapper.outerHeight( true ) } );

				$controlList.removeClass( 'active-tab' );
				$activeControl.addClass( 'active-tab' );

				$contentList.removeClass( 'active-content' );
				activeContentHeight = $activeContent.outerHeight( true );
				activeContentHeight += parseInt( $contentWrapper.css( 'border-top-width' ) ) + parseInt( $contentWrapper.css( 'border-bottom-width' ) );
				$activeContent.addClass( 'active-content' );

				$contentWrapper.css( { 'height': activeContentHeight } );

				if ( timer ) {
					clearTimeout( timer );
				}

				timer = setTimeout( function() {
					$contentWrapper.css( { 'height': 'auto' } );
				}, 500 );
			}

			// Hash Watch Handler
			if ( tabsArray ) {

				$controlList.each( function( index ) {
					var $this    = $( this ),
						id       = $this.attr( 'id' ),
						tabIndex = index;

					tabsArray.forEach( function( itemHash, i ) {
						if ( itemHash === id ) {
							switchTab( tabIndex );
						}
					} );

				} );
			}

		},// tabsInit end

		accordionInit: function( $scope ) {
			var $target       = $( '.rx-theme-assistant-accordion', $scope ).first(),
				$widgetId     = $target.data( 'id' ),
				$window       = $( window ),
				$controlsList = $( '> .rx-theme-assistant-accordion__inner > .rx-theme-assistant-toggle > .rx-theme-assistant-toggle__control', $target ),
				settings      = $target.data( 'settings' ),
				$toggleList   = $( '> .rx-theme-assistant-accordion__inner > .rx-theme-assistant-toggle', $target ),
				timer, timer2,
				curentHash    = window.location.hash || false,
				togglesArray  = curentHash ? curentHash.replace( '#', '' ).split( '&' ) : false;

			$( window ).on( 'resize.rxAccordion orientationchange.rxAccordion', function() {
				var activeToggle        = $( '> .rx-theme-assistant-accordion__inner > .active-toggle', $target ),
					activeToggleContent = $( '> .rx-theme-assistant-toggle__content', activeToggle );

				activeToggleContent.css( { 'height': 'auto' } );
			} );

			$controlsList.on( 'click.rxAccordion', function() {
				var $this       = $( this ),
					$toggle     = $this.closest( '.rx-theme-assistant-toggle' ),
					toggleIndex = +$this.data( 'toggle' ) - 1;

				if ( settings['collapsible'] ) {

					if ( ! $toggle.hasClass( 'active-toggle' ) ) {

						$toggleList.each( function( index ) {
							var $this                = $( this ),
								$toggleControl       = $( '> .rx-theme-assistant-toggle__control', $this ),
								$toggleContent       = $( '> .rx-theme-assistant-toggle__content', $this ),
								$toggleContentHeight = $( '> .rx-theme-assistant-toggle__content > .rx-theme-assistant-toggle__content-inner', $this ).outerHeight();

							$toggleContentHeight += parseInt( $toggleContent.css( 'border-top-width' ) ) + parseInt( $toggleContent.css( 'border-bottom-width' ) );

							if ( index === toggleIndex ) {
								$this.addClass( 'active-toggle' );
								$toggleContent.css( { 'height': $toggleContentHeight } );

								$toggleControl.attr( 'aria-expanded', 'true' );
								$toggleContent.attr( 'aria-hidden', 'false' );

								if ( settings['ajaxTemplate'] ) {
									ajaxLoadTemplate( toggleIndex );
								}

								$window.trigger( 'rx-theme-assistant/accordion/show-toggle-event/before', {
									widgetId: $widgetId,
									toggleIndex: toggleIndex,
								} );

								if ( timer ) {
									clearTimeout( timer );
								}

								timer = setTimeout( function() {
									$window.trigger( 'rx-theme-assistant/accordion/show-toggle-event/after', {
										widgetId: $widgetId,
										toggleIndex: toggleIndex,
									} );

									$toggleContent.css( { 'height': 'auto' } );
								}, 300 );

							} else {
								if ( $this.hasClass( 'active-toggle' ) ) {
									$toggleContent.css( { 'height': $toggleContent.outerHeight() } );
									$this.removeClass( 'active-toggle' );

									$toggleControl.attr( 'aria-expanded', 'false' );
									$toggleContent.attr( 'aria-hidden', 'true' );

									if ( timer2 ) {
										clearTimeout( timer2 );
									}

									timer2 = setTimeout( function() {
										$toggleContent.css( { 'height': 0 } );
									}, 5 );
								}
							}
						} );
					}
				} else {
					var $toggleContent = $( '> .rx-theme-assistant-toggle__content', $toggle ),
						$toggleContentHeight = $( '> .rx-theme-assistant-toggle__content > .rx-theme-assistant-toggle__content-inner', $toggle ).outerHeight();

					$toggleContentHeight += parseInt( $toggleContent.css( 'border-top-width' ) ) + parseInt( $toggleContent.css( 'border-bottom-width' ) );

					$toggle.toggleClass( 'active-toggle' );

					if ( $toggle.hasClass( 'active-toggle') ) {
						$toggleContent.css( { 'height': $toggleContentHeight } );

						$this.attr( 'aria-expanded', 'true' );
						$toggleContent.attr( 'aria-hidden', 'false' );

						if ( settings['ajaxTemplate'] ) {
							ajaxLoadTemplate( toggleIndex );
						}

						$window.trigger( 'rx-theme-assistant/accordion/show-toggle-event/before', {
							widgetId: $widgetId,
							toggleIndex: toggleIndex,
						} );

						if ( timer ) {
							clearTimeout( timer );
						}

						timer = setTimeout( function() {
							$window.trigger( 'rx-theme-assistant/accordion/show-toggle-event/after', {
								widgetId: $widgetId,
								toggleIndex: toggleIndex,
							} );

							$toggleContent.css( { 'height': 'auto' } );
						}, 300 );

					} else {
						$toggleContent.css( { 'height': $toggleContent.outerHeight() } );

						$this.attr( 'aria-expanded', 'false' );
						$toggleContent.attr( 'aria-hidden', 'true' );

						if ( timer2 ) {
							clearTimeout( timer2 );
						}

						timer2 = setTimeout( function() {
							$toggleContent.css( { 'height': 0 } );
						}, 5 );
					}
				}

			});

			/**
			 * [ajaxLoadTemplate description]
			 * @param  {[type]} $index [description]
			 * @return {[type]}        [description]
			 */
			function ajaxLoadTemplate( $index ) {
				var $toggle        = $toggleList.eq( $index ),
					$contentHolder = $( '> .rx-theme-assistant-toggle__content', $toggle ),
					$contentHolderInner = $( '> .rx-theme-assistant-toggle__content > .rx-theme-assistant-toggle__content-inner', $toggle ),
					templateLoaded = $contentHolder.data( 'template-loaded' ) || false,
					templateId     = $contentHolder.data( 'template-id' ),
					loader         = $( '.rx-theme-assistant-loader', $contentHolderInner );

				if ( templateLoaded ) {
					return false;
				}

				$contentHolder.data( 'template-loaded', true );

				$.ajax( {
					type: 'GET',
					url: window.rxThemeAssistant.templateApiUrl,
					dataType: 'json',
					data: {
						'id': templateId,
						'dev': window.rxThemeAssistant.devMode
					},
					success: function( responce, textStatus, jqXHR ) {
						var templateContent     = responce['template_content'],
							templateScripts     = responce['template_scripts'],
							templateStyles      = responce['template_styles'];

						for ( var scriptHandler in templateScripts ) {
							RxThemeAssistant.addedAssetsPromises.push( RxThemeAssistant.loadScriptAsync( scriptHandler, templateScripts[ scriptHandler ] ) );
						}

						for ( var styleHandler in templateStyles ) {
							RxThemeAssistant.addedAssetsPromises.push( RxThemeAssistant.loadStyle( styleHandler, templateStyles[ styleHandler ] ) );
						}

						Promise.all( RxThemeAssistant.addedAssetsPromises ).then( value => {
							loader.remove();
							$contentHolderInner.append( templateContent );
							RxThemeAssistant.elementorFrontendInit( $contentHolderInner );
						}, reason => {
							console.log( 'Script Loaded Error' );
						});
					}
				} );//end
			}

			// Hash Watch Handler
			if ( togglesArray ) {

				$controlsList.each( function( index ) {
					var $this    = $( this ),
						id       = $this.attr( 'id' ),
						toggleIndex = index;

					togglesArray.forEach( function( itemHash, i ) {
						if ( itemHash === id ) {
							$this.trigger('click.rxAccordion');
						}
					} );

				} );
			}

			$( document ).on( 'click.rxAccordionAnchor', 'a[href*="#rx-theme-assistant-toggle-control-"]', function( event ) {
				var $hash = $( this.hash );

				if ( ! $hash.closest( $scope )[0] ) {
					return;
				}

				$hash.trigger( 'click.rxAccordion' );
			} );

		},// accordionInit end

		widgetTable: function( $scope ) {
			var $target = $scope.find( '.rx-theme-assistant-table' ),
				options = {
					cssHeader: 'rx-theme-assistant-table-header-sort',
					cssAsc: 'rx-theme-assistant-table-header-sort--up',
					cssDesc: 'rx-theme-assistant-table-header-sort--down',
					initWidgets: false
				};

			if ( ! $target.length ) {
				return;
			}

			$target.parent().on( 'scroll', function(){
				$(this).addClass( 'remove-swipe-icon' );
			} );

			if ( $target.hasClass( 'rx-theme-assistant-table--sorting' ) ) {
				$target.tablesorter( options );
			}
		},

		refreshCart: function( $scope ) {

			if ( ! elementor ) {
				return;
			}

			if ( ! window.RxThemeAssistantEditor ) {
				return;
			}

			if ( ! window.RxThemeAssistantEditor.activeSection ) {
				return;
			}

			var section = window.RxThemeAssistantEditor.activeSection;
			var isCart = -1 !== [ 'cart_list_style', 'cart_list_items_style', 'cart_buttons_style' ].indexOf( section );

			if ( isCart ) {
				$scope.find( '.rx-cart' ).addClass( 'rx-cart-hover' );
			} else {
				$scope.find( '.rx-cart' ).removeClass( 'rx-cart-hover' );
			}

			$( '.widget_shopping_cart_content' ).empty();
			$( document.body ).trigger( 'wc_fragment_refresh' );
		},

		widgetSearch: function( $scope ) {

			RxThemeAssistant.onSearchSectionActivated( $scope );

			$( document ).on( 'click.RxThemeAssistant', function( event ) {

				var $widget       = $scope.find( '.rx-search' ),
					$popupToggle  = $( '.rx-search__popup-trigger', $widget ),
					$popupContent = $( '.rx-search__popup-content', $widget ),
					activeClass   = 'rx-search-popup-active',
					transitionOut = 'rx-transition-out';

				if ( $( event.target ).closest( $popupToggle ).length || $( event.target ).closest( $popupContent ).length ) {
					return;
				}

				if ( ! $widget.hasClass( activeClass ) ) {
					return;
				}

				$widget.removeClass( activeClass );
				$widget.addClass( transitionOut );
				setTimeout( function() {
					$widget.removeClass( transitionOut );
				}, 300 );

				event.stopPropagation();
			} );
		},

		onSearchSectionActivated: function( $scope ) {
			if ( ! elementor ) {
				return;
			}

			if ( ! window.RxThemeAssistantEditor ) {
				return;
			}

			if ( ! window.RxThemeAssistantEditor.activeSection ) {
				return;
			}

			var section = window.RxThemeAssistantEditor.activeSection;

			var isPopup = -1 !== [ 'section_popup_style', 'section_popup_close_style', 'section_form_style' ].indexOf( section );

			if ( isPopup ) {
				$scope.find( '.rx-search' ).addClass( 'rx-search-popup-active' );
			} else {
				$scope.find( '.rx-search' ).removeClass( 'rx-search-popup-active' );
			}
		},

		searchPopupSwitch: function( event ) {

			var $this         = $( this ),
				$widget       = $this.closest( '.rx-search' ),
				$input        = $( '.rx-search__field', $widget ),
				activeClass   = 'rx-search-popup-active',
				transitionIn  = 'rx-transition-in',
				transitionOut = 'rx-transition-out';

			if ( ! $widget.hasClass( activeClass ) ) {
				$widget.addClass( transitionIn );
				setTimeout( function() {
					$widget.removeClass( transitionIn );
					$widget.addClass( activeClass );
				}, 300 );
				$input.focus();
			} else {
				$widget.removeClass( activeClass );
				$widget.addClass( transitionOut );
				setTimeout( function() {
					$widget.removeClass( transitionOut );
				}, 300 );
			}
		},

		dynamicPostsCarousel: function( $scope ) {
			var $carousel = $scope.find( '.rxta-dynamic-posts__layout-carousel .rx-theme-assistant-carousel' );

			if ( ! $carousel.length ) {
				return;
			}

			RxThemeAssistant.initCarousel( $carousel, $carousel.data( 'slider_options' ) );
		},

		elementorSection: function( $scope ) {
			var $target   = $scope,
				instance  = null,
				editMode  = Boolean( elementor.isEditMode() );

			instance = new rxParallaxExt( $target );
			instance.init();
		},

		elementorWidget: function( $scope ) {
			var parallaxInstance = null,
				satelliteInstance = null;

			parallaxInstance = new rxWidgetParallax( $scope );
			parallaxInstance.init();

			satelliteInstance = new rxWidgetSatellite( $scope );
			satelliteInstance.init();

		},

		initCarousel: function( $target, options ) {

			var tabletSlides, mobileSlides, defaultOptions, slickOptions;

			if ( options.slidesToShow.tablet ) {
				tabletSlides = options.slidesToShow.tablet;
			} else {
				tabletSlides = 1 === options.slidesToShow.desktop ? 1 : 2;
			}

			if ( options.slidesToShow.mobile ) {
				mobileSlides = options.slidesToShow.mobile;
			} else {
				mobileSlides = 1;
			}

			options.slidesToShow = options.slidesToShow.desktop;

			defaultOptions = {
				customPaging: function(slider, i) {
					return $( '<span />' ).text( i + 1 );
				},
				dotsClass: 'rx-theme-assistant-slick-dots',
				responsive: [
					{
						breakpoint: 1025,
						settings: {
							slidesToShow: tabletSlides,
						}
					},
					{
						breakpoint: 768,
						settings: {
							slidesToShow: mobileSlides,
							slidesToScroll: 1
						}
					}
				]
			};

			slickOptions = $.extend( {}, defaultOptions, options );

			$target.slick( slickOptions );
		},

		widgetCountdown: function( $scope ) {

			var timeInterval,
				$coutdown = $scope.find( '[data-due-date]' ),
				endTime = new Date( $coutdown.data( 'due-date' ) * 1000 ),
				elements = {
					days: $coutdown.find( '[data-value="days"]' ),
					hours: $coutdown.find( '[data-value="hours"]' ),
					minutes: $coutdown.find( '[data-value="minutes"]' ),
					seconds: $coutdown.find( '[data-value="seconds"]' )
				};

			RxThemeAssistant.widgetCountdown.updateClock = function() {

				var timeRemaining = RxThemeAssistant.widgetCountdown.getTimeRemaining( endTime );

				$.each( timeRemaining.parts, function( timePart ) {

					var $element = elements[ timePart ];

					if ( $element.length ) {
						$element.html( this );
					}

				} );

				if ( timeRemaining.total <= 0 ) {
					clearInterval( timeInterval );
				}
			};

			RxThemeAssistant.widgetCountdown.initClock = function() {
				RxThemeAssistant.widgetCountdown.updateClock();
				timeInterval = setInterval( RxThemeAssistant.widgetCountdown.updateClock, 1000 );
			};

			RxThemeAssistant.widgetCountdown.splitNum = function( num ) {

				var num   = num.toString(),
					arr   = [],
					reult = '';

				if ( 1 === num.length ) {
					num = 0 + num;
				}

				arr = num.match(/\d{1}/g);

				$.each( arr, function( index, val ) {
					reult += '<span class="rxta-countdown-timer__digit">' + val + '</span>';
				});

				return reult;
			};

			RxThemeAssistant.widgetCountdown.getTimeRemaining = function( endTime ) {

				var timeRemaining = endTime - new Date(),
					seconds = Math.floor( ( timeRemaining / 1000 ) % 60 ),
					minutes = Math.floor( ( timeRemaining / 1000 / 60 ) % 60 ),
					hours = Math.floor( ( timeRemaining / ( 1000 * 60 * 60 ) ) % 24 ),
					days = Math.floor( timeRemaining / ( 1000 * 60 * 60 * 24 ) );

				if ( days < 0 || hours < 0 || minutes < 0 ) {
					seconds = minutes = hours = days = 0;
				}

				return {
					total: timeRemaining,
					parts: {
						days: RxThemeAssistant.widgetCountdown.splitNum( days ),
						hours: RxThemeAssistant.widgetCountdown.splitNum( hours ),
						minutes: RxThemeAssistant.widgetCountdown.splitNum( minutes ),
						seconds: RxThemeAssistant.widgetCountdown.splitNum( seconds )
					}
				};
			};

			RxThemeAssistant.widgetCountdown.initClock();

		},

		stickUpHeaderInit: function( ) {
			var $window = $( window ),
				$body= $( 'body' ),
				stickUpHeader = $('span.rx-stick-header').parents('header#masthead'),
				stickUpFooter = $('span.rx-stick-footer').parents('footer#colophon'),
				siteContent = $( '.site', $body );

			if( stickUpHeader[0] ){
				var headerHaight,
					scrollTop,
					isSticUp = false;

				$body.addClass( 'rx-have-stick-up-header' );

				$window
					.on( 'scroll.rxStickUpHeader', function(){
						if( $window.width() > 767 ){
							scrollTop =$window.scrollTop();
							isSticUp = scrollTop > headerHaight + 50;

							if( isSticUp && ! $body.hasClass('rx-header-is-stick-up') ){
								siteContent.css( { 'padding-top' : headerHaight } );
								$body.addClass( 'rx-header-is-stick-up')
							}else if( ! isSticUp && $body.hasClass('rx-header-is-stick-up') ){
								$body.addClass( 'rx-stick-up-header-hide' );
								stickUpHeader.on( 'animationend', removeHeaderClass )
							}

							if( headerHaight - 50 > scrollTop && $body.hasClass('rx-header-is-stick-up') ){
								removeHeaderClass();
								headerHaight = stickUpHeader.outerHeight(true);
							}
						} else {
							removeHeaderClass();
						}
					} )
					.on( 'resize.rxStickUpHeader', function(){
						if( $window.width() > 767 ){
							headerHaight = stickUpHeader.outerHeight(true);
						} else {
							removeHeaderClass();
						}
					} )
					.trigger('resize.rxStickUpHeader')
					.trigger('scroll.rxStickUpHeader');

				function removeHeaderClass(){
					stickUpHeader.off( 'animationend' );
					siteContent.css( { 'padding-top' : 0 } );
					$body.removeClass( 'rx-header-is-stick-up rx-stick-up-header-hide' );
				}
			}

			if(stickUpFooter[0]){
				var footerHaight,
					resizeTimeout;

				$window
					.on( 'resize.rxStickFooter', function(){
						if( $window.width() > 767 ){
							clearTimeout( resizeTimeout );

							resizeTimeout = setTimeout( function(){
								footerHaight = stickUpFooter.outerHeight();

								$body.addClass( 'rx-have-stick-footer' );
								siteContent.css( { 'padding-bottom' : footerHaight } );
							}, 200 );
						} else {
							$body.removeClass( 'rx-have-stick-footer' );
							siteContent.css( { 'padding-bottom' : 0 } );
						}
					} )
					.trigger('resize.rxStickFooter')
			}
		},

		sectionActions: function( $scope ){
			var settings = $scope.data('rx-actions');

			if( ! settings ){
				return;
			}

			settings['dependent_element'] = settings['dependent_class_name'] ? $scope.siblings( '.' + settings['dependent_class_name'] ) : $scope ;

			$scope.on( 'click', settings, doSectionActions );

			function doSectionActions( event ){
				var sectionSettings = event.data,
					dependent_element = sectionSettings['dependent_element'];

				switch( sectionSettings['type'] ){
					case 'toggle_class':
						dependent_element.toggleClass( sectionSettings['class_name'] );
					break;
					case 'add_class':
						if ( ! dependent_element.hasClass( sectionSettings['class_name'] ) ) {
							dependent_element.addClass( sectionSettings['class_name'] );
						}
					break;
					case 'remove_class':
						if ( dependent_element.hasClass( sectionSettings['class_name'] ) ) {
							dependent_element.removeClass( sectionSettings['class_name'] );
						}
					break;
					case 'call_user_function':
						if ( $.isFunction( window[sectionSettings['function_name']] ) ) {
							window[sectionSettings['function_name']]();
						}
					break;
				}
			}
		},

		loadScriptAsync: function( script, uri ) {

			if ( RxThemeAssistant.addedScripts.hasOwnProperty( script ) ) {
				return script;
			}

			RxThemeAssistant.addedScripts[ script ] = uri;

			return new Promise( ( resolve, reject ) => {
				var tag = document.createElement( 'script' );

					tag.src    = uri;
					tag.async  = true;
					tag.onload = () => {
						resolve( script );
					};

				document.head.appendChild( tag );
			});
		},

		loadStyle: function( style, uri ) {

			if ( RxThemeAssistant.addedStyles.hasOwnProperty( style ) && RxThemeAssistant.addedStyles[ style ] ===  uri) {
				return style;
			}

			RxThemeAssistant.addedStyles[ style ] = uri;

			return new Promise( ( resolve, reject ) => {
				var tag = document.createElement( 'link' );

					tag.id      = style;
					tag.rel     = 'stylesheet';
					tag.href    = uri;
					tag.type    = 'text/css';
					tag.media   = 'all';
					tag.onload  = () => {
						resolve( style );
					};

				document.head.appendChild( tag );
			});
		},

		elementorFrontendInit: function( $container ) {

			$container.find( 'div[data-element_type]' ).each( function() {
				var $this       = $( this ),
					elementType = $this.data( 'element_type' );

				if ( ! elementType ) {
					return;
				}

				try {
					if ( 'widget' === elementType ) {
						elementType = $this.data( 'widget_type' );
						window.elementorFrontend.hooks.doAction( 'frontend/element_ready/widget', $this, $ );
					}

					window.elementorFrontend.hooks.doAction( 'frontend/element_ready/global', $this, $ );
					window.elementorFrontend.hooks.doAction( 'frontend/element_ready/' + elementType, $this, $ );

				} catch ( err ) {
					console.log(err);

					$this.remove();

					return false;
				}
			} );

		},

		widgetTestimonials: function( $scope ) {
			var $target        = $scope.find( '.rx-theme-assistant-testimonials__instance' ),
				$imagesTagList = $( '.rx-theme-assistant-testimonials__figure', $target ),
				instance       = null,
				settings       = $target.data( 'settings' );

			if ( ! $target.length ) {
				return;
			}

			settings.adaptiveHeight = settings['adaptiveHeight'];

			RxThemeAssistant.initCarousel( $target, settings );
		}
	};

	$( window ).on( 'elementor/frontend/init', RxThemeAssistant.init );

	var RxThemeAssistantTools = {
		debounce: function( threshold, callback ) {
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

		getObjectNextKey: function( object, key ) {
			var keys      = Object.keys( object ),
				idIndex   = keys.indexOf( key ),
				nextIndex = idIndex += 1;

			if( nextIndex >= keys.length ) {
				//we're at the end, there is no next
				return false;
			}

			var nextKey = keys[ nextIndex ];

			return nextKey;
		},

		getObjectPrevKey: function( object, key ) {
			var keys      = Object.keys( object ),
				idIndex   = keys.indexOf( key ),
				prevIndex = idIndex -= 1;

			if ( 0 > idIndex ) {
				//we're at the end, there is no next
				return false;
			}

			var prevKey = keys[ prevIndex ];

			return prevKey;
		},

		getObjectFirstKey: function( object ) {
			return Object.keys( object )[0];
		},

		getObjectLastKey: function( object ) {
			return Object.keys( object )[ Object.keys( object ).length - 1 ];
		},

		validateEmail: function( email ) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

			return re.test( email );
		},

		mobileAndTabletCheck: function() {
			var check = false;

			(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);

			return check;
		},

		isEditMode: function() {
			return Boolean( elementorFrontend.isEditMode() );
		},

		widgetEditorSettings: function( widgetId ) {
			var editorElements = null,
				widgetData     = {};

			if ( ! window.elementor.hasOwnProperty( 'elements' ) ) {
				return false;
			}

			editorElements = window.elementor.elements;

			if ( ! editorElements.models ) {
				return false;
			}

			$.each( editorElements.models, function( index, obj ) {

				$.each( obj.attributes.elements.models, function( index, obj ) {

					$.each( obj.attributes.elements.models, function( index, obj ) {
						if ( widgetId == obj.id ) {
							widgetData = obj.attributes.settings.attributes;
						}
					} );

				} );

			} );

			return {
				'speed': widgetData['rx_theme_assistant_widget_parallax_speed'] || { 'size': 50, 'unit': '%'},
				'parallax': widgetData['rx_theme_assistant_widget_parallax'] || 'false',
				'invert': widgetData['rx_theme_assistant_widget_parallax_invert'] || 'false',
				'stickyOn': widgetData['rx_theme_assistant_widget_parallax_on'] || [ 'desktop', 'tablet' ],
				'satellite': widgetData['rx_theme_assistant_widget_satellite'] || 'false',
				'satelliteType': widgetData['rx_theme_assistant_widget_satellite_type'] || 'text',
				'satellitePosition': widgetData['rx_theme_assistant_widget_satellite_position'] || 'top-center',
			}
		}
	}

	/**
	 * Rx Theme Assistant Timeline Class
	 *
	 * @return {void}
	 */
	window.RxThemeAssistantTimeLine = function ( $element ){
		var $viewport		= $(window),
			self			= this,
			$line 			= $element.find( '.rx-theme-assistant-timeline__line' ),
			$progress		= $line.find( '.rx-theme-assistant-timeline__line-progress' ),
			$cards			= $element.find( '.rx-theme-assistant-timeline-item' ),
			$points 		= $element.find('.timeline-item__point'),

			currentScrollTop 		= $viewport.scrollTop(),
			lastScrollTop 			= -1,
			currentWindowHeight 	= $(window).height(),
			currentViewportHeight 	= $viewport.outerHeight(),
			lastWindowHeight 		= -1,
			requestAnimationId 		= null,
			flag 					= false;

		self.onScroll = function (){
			currentScrollTop = $viewport.scrollTop();

			self.updateFrame();
			self.animateCards();
		};

		self.onResize = function() {
			currentScrollTop = $viewport.scrollTop();
			currentWindowHeight = $viewport.height();

			self.updateFrame();
		};

		self.updateWindow = function() {
			flag = false;

			$line.css({
				'top' 		: $cards.first().find( $points ).offset().top - $cards.first().offset().top,
				'bottom'	: ( $element.offset().top + $element.outerHeight() ) - $cards.last().find( $points ).offset().top
			});

			if ( ( lastScrollTop !== currentScrollTop ) ) {
				lastScrollTop 		= currentScrollTop;
				lastWindowHeight = currentWindowHeight;

				self.updateProgress();
			}
		};

		self.updateProgress = function() {
			var progressFinishPosition = $cards.last().find( $points ).offset().top,
				progressHeight = ( currentScrollTop - $progress.offset().top ) + ( currentViewportHeight / 2 );

			if ( progressFinishPosition <= ( currentScrollTop + currentViewportHeight / 2 ) ) {
				progressHeight = progressFinishPosition - $progress.offset().top;
			}

			$progress.css({
				'height' : progressHeight + 'px'
			});

			$cards.each( function() {
				if ( $(this).find( $points ).offset().top < ( currentScrollTop + currentViewportHeight * 0.5 ) ) {
					$(this).addClass('is--active');
				} else {
					$(this).removeClass('is--active');
				}
			});
		};

		self.updateFrame = function() {
			if ( ! flag ) {
				requestAnimationId = requestAnimationFrame( self.updateWindow );
			}
			flag = true;
		};

		self.animateCards = function() {
			$cards.each( function() {
				if( $(this).offset().top <= currentScrollTop + currentViewportHeight * 0.9 && $(this).hasClass('rx-theme-assistant-timeline-item--animated') ) {
					$(this).addClass('is--show');
				}
			});
		};

		self.init = function(){
			$(document).ready(self.onScroll);
			$(window).on('scroll.rxThemeAssistantTimeline', self.onScroll);
			$(window).on('resize.rxThemeAssistantTimeline orientationchange.rxThemeAssistantTimeline', RxThemeAssistantTools.debounce( 50, self.onResize ));
		};
	}

	/**
	 * Rx Theme Assistant Portfolio Class
	 *
	 * @return {void}
	 */
	window.RxThemeAssistantPortfolio = function( $selector, settings ) {
		var self            = this,
			$instance       = $selector,
			$instanceList   = $( '.rx-theme-assistant-portfolio__list', $instance ),
			$itemsList      = $( '.rx-theme-assistant-portfolio__item', $instance ),
			$filterList     = $( '.rx-theme-assistant-portfolio__filter-item', $instance ),
			$moreWrapper    = $( '.rx-theme-assistant-portfolio__view-more', $instance ),
			$moreButton     = $( '.rx-theme-assistant-portfolio__view-more-button', $instance ),
			itemsData       = {},
			filterData      = {},
			activeSlug      = [],
			defaultSettings = {
				layoutType: 'masonry',
				columns: 3,
				columnsTablet: 2,
				columnsMobile: 1,
				perPage: 6
			},
			masonryOptions = {
				itemSelector: '.rx-theme-assistant-portfolio__item',
				percentPosition: true,
				//isAnimated: true
			},
			settings        = $.extend( defaultSettings, settings ),
			$masonryInstance,
			page            = 1;

		/**
		 * Init
		 */
		self.init = function() {
			self.layoutBuild();
		}

		/**
		 * Layout build
		 */
		self.layoutBuild = function() {

			self.generateData();

			if ( 'justify' == settings['layoutType'] ) {
				masonryOptions['columnWidth'] = '.grid-sizer';
			}

			$masonryInstance = $instanceList.masonry( masonryOptions );

			$( '.rx-theme-assistant-portfolio__image', $itemsList ).imagesLoaded().progress( function( instance, image ) {
				var $image      = $( image.img ),
					$parentItem = $image.closest( '.rx-theme-assistant-portfolio__item' ),
					$loader     = $( '.rx-theme-assistant-portfolio__image-loader', $parentItem );

				$loader.remove();

				$parentItem.addClass( 'item-loaded' );

				$masonryInstance.masonry( 'layout' );
			} );

			//$instanceList.imagesLoaded( function( instance ) {} );

			$filterList.on( 'click.rx-theme-assistantPortfolio', self.filterHandler );
			$moreButton.on( 'click.rx-theme-assistantPortfolio', self.moreButtonHandler );

			self.render();
			self.checkMoreButton();
		};

		self.generateData = function() {
			if ( $filterList[0] ) {
				$filterList.each( function( index ) {
					var $this = $( this ),
						slug  = $this.data('slug');

					filterData[ slug ] = false;

					if ( 'all' == slug ) {
						filterData[ slug ] = true;
					}
				} );
			} else {
				filterData['all'] = true;
			}

			$itemsList.each( function( index ) {
				var $this = $( this ),
					slug  = $this.data('slug');

				itemsData[ index ] = {
					selector: $this,
					slug: slug,
					visible: $this.hasClass( 'visible-status' ) ? true : false,
					more: $this.hasClass( 'hidden-status' ) ? true : false
				};
			} );
		};

		self.filterHandler = function( event ) {
			var $this = $( this ),
				slug  = $this.data( 'slug' );

			$filterList.removeClass( 'active' );
			$this.addClass( 'active' );

			for ( var slugName in filterData ) {
				filterData[ slugName ] = false;

				if ( slugName == slug ) {
					filterData[ slugName ] = true;
				}
			}

			$.each( itemsData, function( index, obj ) {
				var visible = false;

				if ( self.isItemVisible( obj.slug ) && ! obj['more'] ) {
					visible = true;
				}

				obj.visible = visible;
			} );

			self.render();
			self.checkMoreButton();
		}

		/**
		 * [moreButtonHandler description]
		 * @param  {[type]} event [description]
		 * @return {[type]}       [description]
		 */
		self.moreButtonHandler = function( event ) {
			var $this   = $( this ),
				counter = 1;

			$.each( itemsData, function( index, obj ) {

				if ( self.isItemVisible( obj.slug ) && obj.more && counter <= settings.perPage ) {
					obj.more = false;
					obj.visible = true;

					counter++;
				}
			} );

			self.render();
			self.checkMoreButton();
		}

		/**
		 * [checkmoreButton description]
		 * @return {[type]} [description]
		 */
		self.checkMoreButton = function() {
			var check = false;

			$.each( itemsData, function( index, obj ) {

				if ( self.isItemVisible( obj.slug ) && obj.more ) {
					check = true;
				}
			} );

			if ( check ) {
				$moreWrapper.removeClass( 'hidden-status' );
			} else {
				$moreWrapper.addClass( 'hidden-status' );
			}
		}

		/**
		 * [anyFilterEnabled description]
		 * @return {Boolean} [description]
		 */
		self.isItemVisible = function( slugs ) {
			var slugList = Object.values( slugs );

			for ( var slug in filterData ) {
				var checked = filterData[ slug ];

				if ( checked && -1 !== slugList.indexOf( slug ) ) {
					return true;
				}
			}

			return false;
		}

		/**
		 * [anyFilterEnabled description]
		 * @return {Boolean} [description]
		 */
		self.anyFilterEnabled = function() {

			for ( var slug in filterData ) {
				if ( filterData[ slug ] ) {
					return true;
				}
			}

			return false;
		}

		/**
		 * Render
		 *
		 * @return void
		 */
		self.render = function() {
			var hideAnimation,
				showAnimation;

			$itemsList.removeClass( 'visible-status' ).removeClass( 'hidden-status' );

			$.each( itemsData, function( index, itemData ) {
				var selector = $( '.rx-theme-assistant-portfolio__inner', itemData.selector );

				if ( itemData.visible ) {
					itemData.selector.addClass( 'visible-status' );

					showAnimation = anime( {
						targets: selector[0],
						opacity: {
							value: 1,
							duration: 400,
						},
						scale: {
							value: 1,
							duration: 500,
							easing: 'easeOutExpo'
						},
						delay: 50,
						elasticity: false
					} );
				} else {
					itemData.selector.addClass( 'hidden-status' );

					hideAnimation = anime( {
						targets: selector[0],
						opacity: 0,
						scale: 0,
						duration: 500,
						elasticity: false
					} );
				}
			} );

			$masonryInstance.masonry( 'layout' );
		}
	}

	/**
	 * rx-theme-assistantSectionParallax Class
	 *
	 * @return {void}
	 */
	window.rxParallaxExt = function( $target ) {
		var self             = this,
			sectionId        = $target.data('id'),
			settings         = false,
			editMode         = Boolean( elementor.isEditMode() ),
			$window          = $( window ),
			$body            = $( 'body' ),
			scrollLayoutList = [],
			mouseLayoutList  = [],
			winScrollTop     = $window.scrollTop(),
			winHeight        = $window.height(),
			requesScroll     = null,
			requestMouse     = null,
			tiltx            = 0,
			tilty            = 0,
			isSafari         = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/),
			platform         = navigator.platform;

		/**
		 * Init
		 */
		self.init = function() {

			if ( ! editMode ) {
				settings = rxThemeAssistant[ 'rxParallaxSections' ][ sectionId ] || false;
			} else {
				settings = self.generateEditorSettings( sectionId );
			}

			if ( ! settings ) {
				return false;
			}

			$target.addClass( 'rx-parallax-section' );
			self.generateLayouts();

			if ( 0 !== scrollLayoutList.length ) {
				$window.on( 'scroll.rxSectionParallax resize.rxSectionParallax', self.scrollHandler );
			}

			if ( 0 !== mouseLayoutList.length ) {
				$target.on( 'mousemove.rxSectionParallax resize.rxSectionParallax', self.mouseMoveHandler );
				$target.on( 'mouseleave.rxSectionParallax', self.mouseLeaveHandler );
			}

			self.scrollUpdate();
		};

		self.generateEditorSettings = function( sectionId ) {
			var editorElements      = null,
				sectionsData        = {},
				sectionData         = {},
				sectionParallaxData = {},
				settings            = [];

			if ( ! window.elementor.hasOwnProperty( 'elements' ) ) {
				return false;
			}

			editorElements = window.elementor.elements;

			if ( ! editorElements.models ) {
				return false;
			}

			$.each( editorElements.models, function( index, obj ) {
				if ( sectionId == obj.id ) {
					sectionData = obj.attributes.settings.attributes;
				}
			} );

			if ( ! sectionData.hasOwnProperty( 'rx_parallax_layout_list' ) || 0 === Object.keys( sectionData ).length ) {
				return false;
			}

			sectionParallaxData = sectionData[ 'rx_parallax_layout_list' ].models;

			$.each( sectionParallaxData, function( index, obj ) {
				settings.push( obj.attributes );
			} );

			if ( 0 !== settings.length ) {
				return settings;
			}

			return false;
		};

		self.generateLayouts = function() {

			$( '.rx-parallax-section__layout', $target ).remove();

			$.each( settings, function( index, layout ) {

				var imageData      = layout['rx_parallax_layout_image'],
					speed          = layout['rx_parallax_layout_speed']['size'] || 50,
					zIndex         = layout['rx_parallax_layout_z_index'],
					bgSize         = layout['rx_parallax_layout_bg_size'] || 'auto',
					animProp       = layout['rx_parallax_layout_animation_prop'] || 'bgposition',
					bgX            = layout['rx_parallax_layout_bg_x'],
					bgY            = layout['rx_parallax_layout_bg_y'],
					type           = layout['rx_parallax_layout_type'] || 'none',
					device         = layout['rx_parallax_layout_on'] || ['desktop', 'tablet'],
					deviceVisible  = layout['rx_parallax_layout_visible'] || ['desktop', 'tablet', 'mobile'],
					_id            = layout['_id'],
					isDynamicImage = layout.hasOwnProperty( '__dynamic__' ) && layout.__dynamic__.hasOwnProperty( 'rx_parallax_layout_image' ),
					$layout        = null,
					layoutData     = {},
					safariClass    = isSafari ? ' is-safari' : '',
					macClass       = 'MacIntel' == platform ? ' is-mac' : '';

				if ( '' === imageData['url'] && ! isDynamicImage ) {
					return false;
				}

				$layout = $( '<div class="rx-parallax-section__layout elementor-repeater-item-' + _id + ' rx-parallax-section__' + type +'-layout' + macClass + '"><div class="rx-parallax-section__image"></div></div>' )
					.prependTo( $target )
					.css({
						'z-index': zIndex
					});

				var imageCSS = {
					'background-size': bgSize,
					'background-position-x': bgX + '%',
					'background-position-y': bgY + '%'
				};

				if ( '' !== imageData['url'] ) {
					imageCSS['background-image'] = 'url(' + imageData['url'] + ')';
				}

				$( '> .rx-parallax-section__image', $layout ).css( imageCSS );

				layoutData = {
					selector: $layout,
					image: imageData['url'],
					size: bgSize,
					prop: animProp,
					type: type,
					device: device,
					deviceVisible: deviceVisible,
					xPos: bgX,
					yPos: bgY,
					speed: 2 * ( speed / 100 )
				};

				if ( 'none' !== type ) {
					if ( 'scroll' === type || 'zoom' === type ) {
						scrollLayoutList.push( layoutData );
					}

					if ( 'mouse' === type ) {
						mouseLayoutList.push( layoutData );
					}
				}

			});

		};

		self.scrollHandler = function( event ) {
			winScrollTop = $window.scrollTop();
			winHeight    = $window.height();

			self.scrollUpdate();
		};

		self.scrollUpdate = function() {
			$.each( scrollLayoutList, function( index, layout ) {

				var $this      = layout.selector,
					$image     = $( '.rx-parallax-section__image', $this ),
					speed      = layout.speed,
					offsetTop  = $this.offset().top,
					thisHeight = $this.outerHeight(),
					prop       = layout.prop,
					type       = layout.type,
					posY       = ( winScrollTop - offsetTop + winHeight ) / thisHeight * 100,
					device     = elementorFrontend.getCurrentDeviceMode();


				if ( -1 == layout.deviceVisible.indexOf( device ) ) {
					$this.addClass( 'layout-hidden' );

					return true;
				} else {
					$this.removeClass( 'layout-hidden' );
				}

				if ( -1 == layout.device.indexOf( device ) ) {
					$image.css( {
						'transform': 'translateY(0)',
						'background-position-y': layout.yPos
					} );

					return true;
				}

				if ( winScrollTop < offsetTop - winHeight ) posY = 0;
				if ( winScrollTop > offsetTop + thisHeight) posY = 200;

				posY = parseFloat( speed * posY ).toFixed(1);

				switch( type ) {
					case 'scroll':
						if ( 'bgposition' === layout.prop ) {
							$image.css( {
								'background-position-y': 'calc(' + layout.yPos + '% + ' + posY + 'px)'
							} );
						} else {
							$image.css( {
								'transform': 'translateY(' + posY + 'px)'
							} );
						}
						break;
					case 'zoom':
						var deltaScale = ( winScrollTop - offsetTop + winHeight ) / winHeight,
							scale      = deltaScale * speed;

						scale = scale + 1;

						$image.css( {
							'transform': 'scale(' + scale + ')'
						} );
						break;
				}

			} );

			//requesScroll = requestAnimationFrame( self.scrollUpdate );
			//requestAnimationFrame( self.scrollUpdate );
		};

		self.mouseMoveHandler = function( event ) {
			var windowWidth  = $window.width(),
				windowHeight = $window.height(),
				cx           = Math.ceil( windowWidth / 2 ),
				cy           = Math.ceil( windowHeight / 2 ),
				dx           = event.clientX - cx,
				dy           = event.clientY - cy;

			tiltx = -1 * ( dx / cx );
			tilty = -1 * ( dy / cy);

			self.mouseMoveUpdate();
		};

		self.mouseLeaveHandler = function( event ) {

			$.each( mouseLayoutList, function( index, layout ) {
				var $this  = layout.selector,
					$image = $( '.rx-parallax-section__image', $this );

				switch( layout.prop ) {
					case 'transform3d':
						TweenMax.to(
							$image[0],
							1.2, {
								x: 0,
								y: 0,
								z: 0,
								rotationX: 0,
								rotationY: 0,
								ease:Power2.easeOut
							}
						);
					break;
				}

			} );
		};

		self.mouseMoveUpdate = function() {
			$.each( mouseLayoutList, function( index, layout ) {
				var $this   = layout.selector,
					$image  = $( '.rx-parallax-section__image', $this ),
					speed   = layout.speed,
					prop    = layout.prop,
					posX    = parseFloat( tiltx * 125 * speed ).toFixed(1),
					posY    = parseFloat( tilty * 125 * speed ).toFixed(1),
					posZ    = layout.zIndex * 50,
					rotateX = parseFloat( tiltx * 25 * speed ).toFixed(1),
					rotateY = parseFloat( tilty * 25 * speed ).toFixed(1),
					device  = elementorFrontend.getCurrentDeviceMode();

				if ( -1 == layout.deviceVisible.indexOf( device ) ) {
					$image.addClass( 'layout-hidden' );

					return false;
				} else {
					$image.removeClass( 'layout-hidden' );
				}

				if ( -1 == layout.device.indexOf( device ) ) {
					$image.css( {
						'transform': 'translateX(0) translateY(0)',
						'background-position-x': layout.xPos,
						'background-position-y': layout.yPos
					} );

					return false;
				}

				switch( prop ) {
					case 'bgposition':
						TweenMax.to(
							$image[0],
							1, {
								backgroundPositionX: 'calc(' + layout.xPos + '% + ' + posX + 'px)',
								backgroundPositionY: 'calc(' + layout.yPos + '% + ' + posY + 'px)',
								ease:Power2.easeOut
							}
						);
					break;

					case 'transform':
						TweenMax.to(
							$image[0],
							1, {
								x: posX,
								y: posY,
								ease:Power2.easeOut
							}
						);
					break;

					case 'transform3d':
						TweenMax.to(
							$image[0],
							2, {
								x: posX,
								y: posY,
								z: posZ,
								rotationX: rotateY,
								rotationY: -rotateX,
								ease:Power2.easeOut
							}
						);
					break;
				}

			} );
		};

	}

	/**
	 * [rxWidgetParallax description]
	 * @param  {[type]} $scope [description]
	 * @return {[type]}        [description]
	 */
	window.rxWidgetParallax = function( $scope ) {
		var self         = this,
			$target      = $( '> .elementor-widget-container', $scope ),
			$section     = $scope.closest( '.elementor-top-section' ),
			widgetId     = $scope.data('id'),
			settings     = {},
			editMode     = Boolean( elementor.isEditMode() ),
			$window      = $( window ),
			isSafari     = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/),
			platform     = navigator.platform,
			safariClass  = isSafari ? 'is-safari' : '',
			macClass    = 'MacIntel' == platform ? ' is-mac' : '';

		/**
		 * Init
		 */
		self.init = function() {

			$scope.addClass( macClass );

			if ( ! editMode ) {
				settings = $scope.data( 'rx-theme-assistant-settings' );
			} else {
				settings = RxThemeAssistantTools.widgetEditorSettings( widgetId );
			}

			if ( ! settings ) {
				return false;
			}

			if ( 'undefined' === typeof settings ) {
				return false;
			}

			if ( 'false' === settings['parallax'] || 'undefined' === typeof settings['parallax'] ) {
				return false;
			}

			$window.on( 'scroll.rxWidgetParallax resize.rxWidgetParallax', self.scrollHandler ).trigger( 'resize.rxWidgetParallax' );
		};

		self.scrollHandler = function( event ) {
			var speed             = +settings['speed']['size'] * 0.01,
				invert            = 'true' == settings['invert'] ? -1 : 1,
				winHeight         = $window.height(),
				winScrollTop      = $window.scrollTop(),
				offsetTop         = $scope.offset().top,
				thisHeight        = $scope.outerHeight(),
				sectionHeight     = $section.outerHeight(),
				positionDelta     = winScrollTop - offsetTop + ( winHeight / 2 ),
				abs               = positionDelta > 0 ? 1 : -1,
				posY              = abs * Math.pow( Math.abs( positionDelta ), 0.85 ),
				availableDevices  = settings['stickyOn'] || [],
				currentDeviceMode = elementorFrontend.getCurrentDeviceMode();

			posY = invert * Math.ceil( speed * posY );

			if ( -1 !== availableDevices.indexOf( currentDeviceMode ) ) {
				$target.css( {
					'transform': 'translateY(' + posY + 'px)'
				} );
			} else {
				$target.css( {
					'transform': 'translateY(0)'
				} );
			}
		};
	};

	/**
	 * [rxWidgetSatellite description]
	 * @param  {[type]} $scope [description]
	 * @return {[type]}        [description]
	 */
	window.rxWidgetSatellite = function( $scope ) {
		var self     = this,
			widgetId = $scope.data('id'),
			settings = {},
			editMode = Boolean( elementor.isEditMode() );

		/**
		 * Init
		 */
		self.init = function() {

			if ( ! editMode ) {
				settings = $scope.data( 'rx-theme-assistant-settings' );
			} else {
				settings = RxThemeAssistantTools.widgetEditorSettings( widgetId );
			}

			if ( ! settings ) {
				return false;
			}

			if ( 'undefined' === typeof settings ) {
				return false;
			}

			if ( 'false' === settings['satellite'] || 'undefined' === typeof settings['satellite'] ) {
				return false;
			}

			$scope.addClass( 'rx-theme-assistant-satellite-widget' );

			$( '.rx-theme-assistant-satellite', $scope ).addClass( 'rx-theme-assistant-satellite--' + settings['satellitePosition'] );
		};
	};

}( jQuery, window.elementorFrontend ) );
