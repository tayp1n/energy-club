( function( $, settings ) {

	'use strict';

	var RxThemeWizard = {
		css: {
			plugins: '.rx-theme-wizard-plugins',
			progress: '.rx-theme-wizard-progress__bar',
			showResults: '.rx-theme-wizard-install-results__trigger',
			showPlugins: '.rx-theme-wizard-skin-item__plugins-title',
			loaderBtn: '[data-loader="true"]',
			start: '.start-install',
			storePlugins: '.store-plugins',
			activateLicense: '.rx-theme-wizard-activate-license',
			licenseInput: '.rx-theme-wizard-input',
			installSkin: '.rx-theme-install-template-skin:not(.is_instaled)',
		},

		vars: {
			plugins: null,
			template: null,
			currProgress: 0,
			progress: null,
			skinInstall: false
		},

		init: function() {

			var self = this;

			self.vars.progress = $( self.css.progress );
			self.vars.percent  = $( '.rx-theme-wizard-progress__label', self.vars.progress );

			$( document )
				.on( 'click.RxThemeWizard', self.css.showResults, self.showResults )
				.on( 'click.RxThemeWizard', self.css.showPlugins, self.showPlugins )
				.on( 'click.RxThemeWizard', self.css.storePlugins, self.storePlugins )
				.on( 'click.RxThemeWizard', self.css.activateLicense, self.activateLicense )
				.on( 'click.RxThemeWizard', self.css.loaderBtn, self.showLoader )
				.on( 'click.RxThemeWizard', self.css.installSkin, self.installSkin )
				.on( 'focus.RxThemeWizard', self.css.licenseInput, self.clearLicenseErrors );

			if ( undefined !== settings.firstPlugin ) {
				self.vars.template = wp.template( 'wizard-item' );
				settings.firstPlugin.isFirst = true;
				self.installPlugin( settings.firstPlugin );
			}
		},

		activateLicense: function( event ) {

			event.preventDefault();

			var $this   = $( this ),
				$form   = $this.closest( '.rx-theme-wizard-license-form' ),
				$input  = $form.find( '.rx-theme-wizard-input' ),
				license = $input.val();

			$( '.rx-theme-wizard-license-errors' ).html( '' );

			if ( ! license ) {

				$( '.rx-theme-wizard-license-errors' ).html( settings.license.empty );

				setTimeout( function() {
					$this.removeClass( 'in-progress' );
				}, 10 );

				return false;
			}

			$.ajax({
				url: ajaxurl,
				type: 'get',
				dataType: 'json',
				data: {
					action: 'rx_theme_wizard_activate_license',
					license: license
				}
			}).done( function( response ) {
				if ( true === response.success ) {
					$form.replaceWith( response.data.replaceWith );
				} else {
					$this.removeClass( 'in-progress' );
					$( '.rx-theme-wizard-license-errors' ).html( response.data.errorMessage );
				}
			});

		},

		clearLicenseErrors: function() {
			$( '.rx-theme-wizard-license-errors' ).html( '' );
		},

		storePlugins: function( event ) {

			var $this   = $( this ),
				href    = $this.attr( 'href' ),
				plugins = [];

			event.preventDefault();

			$( '.tm-config-list input[type="checkbox"]:checked' ).each( function( index, el ) {
				plugins.push( $( this ).attr( 'name' ) );
			} );

			$.ajax({
				url: ajaxurl,
				type: 'get',
				dataType: 'json',
				data: {
					action: 'rx_theme_wizard_store_plugins',
					plugins: plugins
				}
			}).done( function( response ) {
				window.location = href;
			});

		},

		showLoader: function() {
			$( this ).addClass( 'in-progress' );
		},

		showPlugins: function() {
			$( this ).toggleClass( 'is-active' );
		},

		showResults: function() {
			var $this = $( this );
			$this.toggleClass( 'is-active' );
		},

		installPlugin: function( data ) {

			var $target = $( RxThemeWizard.vars.template( data ) );

			if ( null === RxThemeWizard.vars.plugins ) {
				RxThemeWizard.vars.plugins = $( RxThemeWizard.css.plugins );
			}

			$target.appendTo( RxThemeWizard.vars.plugins );
			RxThemeWizard.installRequest( $target, data );

		},

		updateProgress: function() {

			var val   = 0,
				total = parseInt( settings.totalPlugins );

			RxThemeWizard.vars.currProgress++;

			val = 100 * ( RxThemeWizard.vars.currProgress / total );
			val = Math.round( val );

			if ( 100 < val ) {
				val = 100;
			}

			RxThemeWizard.vars.percent.html( val + '%' );
			RxThemeWizard.vars.progress.css( 'width', val + '%' );

		},

		installRequest: function( target, data ) {

			var icon;

			data.action = 'rx_theme_wizard_install_plugin';

			if ( undefined === data.isFirst ) {
				data.isFirst = false;
			}

			$.ajax({
				url: ajaxurl,
				type: 'get',
				dataType: 'json',
				data: data
			}).done( function( response ) {

				RxThemeWizard.updateProgress();

				if ( true !== response.success ) {
					return;
				}

				target.append( response.data.log );

				if ( true !== response.data.isLast ) {
					RxThemeWizard.installPlugin( response.data );
				} else {

					$( document ).trigger( 'rx-theme-wizard-install-finished' );

					if ( 1 == settings.redirect ) {
						window.location = response.data.redirect;
					}

					target.after( response.data.message );

				}

				if ( 'error' === response.data.resultType ) {
					icon = '<span class="dashicons dashicons-no"></span>';
				} else {
					icon = '<span class="dashicons dashicons-yes"></span>';
				}

				target.addClass( 'installed-' + response.data.resultType );
				$( '.rx-theme-wizard-loader', target ).replaceWith( icon );
			});
		},

		installSkin: function( event ) {
			event.preventDefault();

			var $this       = $( this ),
				getSkinSlug = $this.data('skin');

			if( RxThemeWizard.vars.skinInstall ){
				$this.removeClass( 'in-progress' );
				return false;
			}

			$( ".rx-theme-install-template-skin:not(.is_instaled)" ).not( $this ).addClass( 'disable' );
			RxThemeWizard.vars.skinInstall = true;

			$.ajax({
				url: ajaxurl,
				type: 'post',
				dataType: "json",
				data: {
					action: 'rx_theme_wizard_install_skin',
					skinSlug: getSkinSlug,
					nonce_code : rxThemeWizard.nonce
				}
			}).done( function( response ) {
				$this.removeClass( 'in-progress' );
				if ( true === response.success ) {
					window.location.href = response.data['redirecUrl'];
					$this.addClass( 'is_instaled' );
				} else {
					var parent = $this.parents('.rx-theme-wizard-skin-item');

					$this.addClass( 'is_error dashicons dashicons-no' );

					$( '.rx-theme-wizard-skin-item__notice', parent )
						.html( response.data['errorMessage'] )
						.css( { 'display' : 'block' } );
					;
				}

				RxThemeWizard.vars.skinInstall = false;
			});
		}
	};

	RxThemeWizard.init();

}( jQuery, window.JetWizardSettings ) );
