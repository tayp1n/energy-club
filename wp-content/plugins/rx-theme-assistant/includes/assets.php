<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Rovadex
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Rx_Theme_Assistant_Assets' ) ) {

	/**
	 * Define Rx_Theme_Assistant_Assets class
	 */
	class Rx_Theme_Assistant_Assets {

		/**
		 * Localize data array
		 *
		 * @var array
		 */
		public $localize_data = [
			'elements_data' => [
				'sections' => [],
				'columns'  => [],
				'widgets'  => [],
			]
		];

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Constructor for the class
		 */
		public function init() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ) );

			add_action( 'elementor/frontend/before_register_scripts', array( $this, 'register_scripts' ) );
			add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_styles' ) );
			add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'editor_scripts' ) );
		}

		/**
		 * Enqueue public-facing stylesheets.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function enqueue_styles() {

			wp_enqueue_style(
				'rx-theme-assistant-skin',
				rx_theme_assistant()->plugin_url( 'assets/css/rx-theme-assistant-skin.css' ),
				false,
				rx_theme_assistant()->get_version()
			);

			wp_enqueue_style(
				'rx-theme-assistant-fronend',
				rx_theme_assistant()->plugin_url( 'assets/css/rx-theme-assistant-frontend.css' ),
				false,
				rx_theme_assistant()->get_version()
			);

			if ( is_rtl() ) {
				wp_enqueue_style(
					'rx-theme-assistant-rtl',
					rx_theme_assistant()->plugin_url( 'assets/css/rx-theme-assistant-rtl.css' ),
					false,
					rx_theme_assistant()->get_version()
				);
			}
		}

		/**
		 * Enqueue admin styles
		 *
		 * @return void
		 */
		public function admin_enqueue_styles() {
			$screen = get_current_screen();

			// Setting page check
			if ( 'elementor_page_rx-theme-settings' === $screen->base ) {}

			wp_enqueue_style(
				'rx-theme-assistant-admin-css',
				rx_theme_assistant()->plugin_url( 'assets/css/rx-theme-assistant-admin.css' ),
				false,
				rx_theme_assistant()->get_version()
			);
		}

		/**
		 * Register plugin scripts
		 *
		 * @return void
		 */
		public function register_scripts() {

			$api_disabled = rx_theme_assistant_settings()->get( 'disable_google_api_js', array() );
			$key          = rx_theme_assistant_settings()->get( 'google_api_key' );

			if ( ! empty( $key ) && ( empty( $api_disabled ) || 'true' !== $api_disabled['disable'] ) ) {

				wp_register_script(
					'google-maps-api',
					add_query_arg(
						array( 'key' => $key, ),
						'https://maps.googleapis.com/maps/api/js'
					),
					false,
					false,
					true
				);
			}

			// Register vendor salvattore.js script (https://github.com/rnmp/salvattore)
			wp_register_script(
				'rx-theme-assistant-salvattore',
				rx_theme_assistant()->plugin_url( 'assets/js/lib/salvattore/salvattore.min.js' ),
				[],
				'1.0.9',
				true
			);

			wp_register_script(
				'rx-theme-assistant-tween-js',
				rx_theme_assistant()->plugin_url( 'assets/js/lib/tweenjs/tweenjs.min.js' ),
				[],
				'2.0.2',
				true
			);

			// Register vendor anime.js script (https://github.com/juliangarnier/anime)
			wp_register_script(
				'rx-theme-assistant-anime-js',
				rx_theme_assistant()->plugin_url( 'assets/js/lib/anime-js/anime.min.js' ),
				array(),
				'2.2.0',
				true
			);

			// Register vendor masonry.pkgd.min.js script
			wp_register_script(
				'rx-theme-assistant-masonry-js',
				rx_theme_assistant()->plugin_url( 'assets/js/lib/masonry-js/masonry.pkgd.min.js' ),
				array(),
				'4.2.1',
				true
			);

			// Register vendor tablesorter.js script (https://github.com/Mottie/tablesorter)
			wp_register_script(
				'jquery-tablesorter',
				rx_theme_assistant()->plugin_url( 'assets/js/lib/tablesorter/jquery.tablesorter.min.js' ),
				array( 'jquery' ),
				'2.30.7',
				true
			);
		}

		/**
		 * Enqueue plugin scripts only with elementor scripts
		 *
		 * @return void
		 */
		public function enqueue_scripts() {
			wp_enqueue_script(
				'rx-theme-assistant-frontend',
				rx_theme_assistant()->plugin_url( 'assets/js/rx-theme-assistant-frontend.js' ),
				[
					'jquery',
					'elementor-frontend',
				],
				rx_theme_assistant()->get_version(),
				true
			);

			$rest_api_url = apply_filters( 'rx-theme-assistant/rest/url', get_rest_url() );

			$this->localize_data = wp_parse_args( $this->localize_data, array(
				'ajaxurl'        => esc_url( admin_url( 'admin-ajax.php' ) ),
				'isMobile'       => filter_var( wp_is_mobile(), FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
				'templateApiUrl' => $rest_api_url . 'rx-theme-assistant-api/v1/elementor-template',
				'devMode'        => is_user_logged_in() ? 'true' : 'false',
			) );

			wp_localize_script(
				'rx-theme-assistant-frontend',
				'rxThemeAssistant',
				apply_filters( 'rx-theme-assistant/frontend/localize-data', $this->localize_data )
			);
		}


		/**
		 * Enqueue elemnetor editor-related styles
		 *
		 * @return void
		 */
		public function editor_styles() {

			wp_enqueue_style(
				'rx-theme-assistant-editor',
				rx_theme_assistant()->plugin_url( 'assets/css/rx-theme-assistant-editor.css' ),
				array(),
				rx_theme_assistant()->get_version()
			);
		}

		/**
		 * Enqueue plugin scripts only with elementor scripts
		 *
		 * @return void
		 */
		public function editor_scripts() {

			wp_enqueue_script(
				'rx-theme-assistant-editor',
				rx_theme_assistant()->plugin_url( 'assets/js/rx-theme-assistant-editor.js' ),
				array(
					'jquery',
					'backbone-marionette',
					'elementor-common',
					'elementor-editor-modules',
					'elementor-editor-document',
				),
				rx_theme_assistant()->get_version(),
				true
			);

		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}

}

function rx_theme_assistant_assets() {
	return Rx_Theme_Assistant_Assets::get_instance();
}
