( function( $ ) {
	'use strict';

	var RxThemeAssistantEditor = {
		activeSection: null,

		init: function() {
			window.elementor.on( 'preview:loaded', RxThemeAssistantEditor.onPreviewLoaded );

			window.elementor.on( 'preview:loaded', RxThemeAssistantEditor.addPageCustomCss );

			window.elementor.hooks.addFilter('editor/style/styleText', RxThemeAssistantEditor.addCustomCss );

			window.elementor.settings.page.model.on('change', RxThemeAssistantEditor.addPageCustomCss );
		},

		onPreviewLoaded: function() {
			var $previewContents = window.elementor.$previewContents,
				elementorFrontend = $('#elementor-preview-iframe')[0].contentWindow.elementorFrontend;

			elementorFrontend.hooks.addAction( 'frontend/element_ready/rx-theme-assistant-tabs.default', function( $scope ){
				//$scope.find( '.rx-theme-assistant-tabs__edit-cover' ).on( 'click', RxThemeAssistantEditor.showTemplatesModal );

				$scope.find( '.rx-theme-assistant-tabs__edit-cover' ).on( 'click', function( event ) {
					window.open( $( this ).attr( 'href' ), '_blank' );
				} );

				$scope.find( '.rx-theme-assistant-tabs-new-template-link' ).on( 'click', function( event ) {
					window.open( $( this ).attr( 'href' ), '_blank' );
				} );
			} );

			elementorFrontend.hooks.addAction( 'frontend/element_ready/rx-theme-assistant-accordion.default', function( $scope ){

				$scope.find( '.rx-theme-assistant-toggle__edit-cover' ).on( 'click', function( event ) {
					window.open( $( this ).attr( 'href' ), '_blank' );
				} );

				$scope.find( '.rx-theme-assistant-toggle-new-template-link' ).on( 'click', function( event ) {
					window.open( $( this ).attr( 'href' ), '_blank' );
				} );
			} );

			RxThemeAssistantEditor.getModal().on( 'hide', function() {
				window.elementor.reloadPreview();
			});


		},

		addPageCustomCss: function() {
			var customCSS = window.elementor.settings.page.model.get('custom_css');

			if ( customCSS ) {
				customCSS = customCSS.replace(/selector/g, elementor.config.settings.page.cssWrapperSelector);

				window.elementor.settings.page.getControlsCSS().elements.$stylesheetElement.append(customCSS);
			}
		},

		addCustomCss: function (css, view) {
			if ( ! view ) {
				return false;
			}

			var model = view.getEditModel(),
				customCSS = model.get('settings').get('custom_css');

			if (customCSS) {
				css += customCSS.replace(/selector/g, '.elementor-element.elementor-element-' + view.model.id);
			}

			return css;
		},

		showTemplatesModal: function() {
			var editLink = $( this ).data( 'template-edit-link' );

			RxThemeAssistantEditor.showModal( editLink );
		},

		showModal: function( link ) {
			var $iframe,
				$loader;

			RxThemeAssistantEditor.getModal().show();

			$( '#rx-theme-assistant-tabs-template-edit-modal .dialog-message').html( '<iframe src="' + link + '" id="rx-theme-assistant-tabs-edit-frame" width="100%" height="100%"></iframe>' );
			$( '#rx-theme-assistant-tabs-template-edit-modal .dialog-message').append( '<div id="rx-theme-assistant-tabs-loading"><div class="elementor-loader-wrapper"><div class="elementor-loader"><div class="elementor-loader-boxes"><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div></div></div><div class="elementor-loading-title">Loading</div></div></div>' );

			$iframe = $( '#rx-theme-assistant-tabs-edit-frame');
			$loader = $( '#rx-theme-assistant-tabs-loading');

			$iframe.on( 'load', function() {
				$loader.fadeOut( 300 );
			} );
		},

		getModal: function() {

			if ( ! RxThemeAssistantEditor.modal ) {
				this.modal = elementor.dialogsManager.createWidget( 'lightbox', {
					id: 'rx-theme-assistant-tabs-template-edit-modal',
					closeButton: true,
					closeButtonClass: 'dialog-close-button-icon eicon-button',
					hide: {
						onBackgroundClick: false
					}
				} );
			}

			return RxThemeAssistantEditor.modal;
		}

	};

	$( window ).on( 'elementor:init', RxThemeAssistantEditor.init );

	window.RxThemeAssistantEditor = RxThemeAssistantEditor;

}( jQuery ) );
