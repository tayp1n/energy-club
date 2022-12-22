<?php
/**
 * Plugin Name: Rx Theme Assistant
 * Plugin URI:  https://rovadex.com
 * Description: RX Theme Assistant plugin
 * Version:     1.6.0
 * Author:      Rovadex
 * Author URI:  https://rovadex.com
 * Text Domain: rx-theme-assistant
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

// If class `Rx_Theme_Assistant` doesn't exists yet.
if ( ! class_exists( 'Rx_Theme_Assistant' ) ) {

	/**
	 * Sets up and initializes the plugin.
	 */
	class Rx_Theme_Assistant {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Plugin version
		 *
		 * @var string
		 */
		private $version = '1.6.0';

		/**
		 * Holder for base plugin URL
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_url = null;

		/**
		 * Holder for base plugin path
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_path = null;

		/**
		 * Framework component
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    object
		 */
		public $framework;

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {

			// Internationalize the text strings used.
			add_action( 'init', array( $this, 'lang' ), -10 );
			// Load files.
			add_action( 'init', array( $this, 'init' ), -10 );

			// Load the CX Loader.
			add_action( 'after_setup_theme', array( $this, 'framework_loader' ), -20 );

			// Load the plugin modules.
			add_action( 'after_setup_theme', array( $this, 'framework_modules' ), 0 );

			// Register activation and deactivation hook.
			register_activation_hook( __FILE__, array( $this, 'activation' ) );
			register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );
		}

		/**
		 * Manually init required modules.
		 *
		 * @return void
		 */
		public function init() {
			if( ! defined( 'ELEMENTOR_VERSION' ) && ! is_callable( 'Elementor\Plugin::instance' ) ){
				return;
			}

			require $this->plugin_path( 'includes/settings.php' );
			require $this->plugin_path( 'includes/assets.php' );
			require $this->plugin_path( 'includes/post-meta.php' );
			require $this->plugin_path( 'includes/functions.php' );
			require $this->plugin_path( 'includes/tools.php' );
			require $this->plugin_path( 'includes/post-tools.php' );
			require $this->plugin_path( 'includes/integration.php' );
			require $this->plugin_path( 'includes/rest-api/rest-api.php' );
			require $this->plugin_path( 'includes/rest-api/endpoints/base.php' );
			require $this->plugin_path( 'includes/rest-api/endpoints/elementor-template.php' );
			require $this->plugin_path( 'includes/shortcodes.php' );
			require $this->plugin_path( 'includes/ext/elementor-plugin-ext.php' );
			require $this->plugin_path( 'includes/ext/elementor-add-font-awesome-5.php' );
			require $this->plugin_path( 'includes/ext/header-footer-elementor-plugin-ext.php' );
			require $this->plugin_path( 'includes/ext/elementor-parallax-ext.php' );
			require $this->plugin_path( 'includes/ext/elementor-section-actions-ext.php' );
			require $this->plugin_path( 'includes/ext/elementor-widget-extension.php' );
			require $this->plugin_path( 'includes/ext/elementor-custom-css-ext.php' );
			require $this->plugin_path( 'includes/ext/contact-form-7-paypal-add-on-ext.php' );
			require $this->plugin_path( 'includes/ext/class-cx-breadcrumbs-extendt.php' );
			require $this->plugin_path( 'includes/ext/elementor-dynamic-pages.php' );

			/**
			 * Widgets.
			 */
			require $this->plugin_path( 'includes/widgets/class-elementor-template-widget.php' );
			require $this->plugin_path( 'includes/widgets/class-wp-nav-menu-widget.php' );

			rx_theme_assistant_assets()->init();
			rx_theme_assistant_settings()->init();
			rx_theme_assistant_functions()->init();
			rx_theme_assistant_integration()->init();
			rx_theme_assistant_shortcodes()->init();
			rx_theme_assistant_elementor_parallax_ext()->init();
			rx_theme_assistant_elementor_widget_ext()->init();
			rxta_section_actions_ext()->init();
			rx_theme_assistant_elementor_custom_css_ext()->init();
			rx_theme_assistant_post_meta()->init();

			//Init Rest Api
			new \Rx_Theme_Assistant\Rest_Api();

			do_action( 'rx-theme-assistant/init', $this );
		}

		/**
		 * [rx_theme_assistant_framework_modules description]
		 *
		 * @return [type] [description]
		 */
		public function framework_modules() {
			do_action( 'rx-theme-assistant/cx-framework-modules-init', $this );
		}

		/**
		 * Load the theme modules.
		 *
		 * @since  1.0.0
		 */
		public function framework_loader() {
			require $this->plugin_path( 'framework/loader.php' );

			$this->framework = new Rx_Theme_Assistant_CX_Loader(
				array(
					$this->plugin_path( 'framework/modules/post-meta/cherry-x-post-meta.php' ),
					$this->plugin_path( 'framework/modules/interface-builder/cherry-x-interface-builder.php' ),
					$this->plugin_path( 'framework/modules/breadcrumbs/cherry-x-breadcrumbs.php' ),
					$this->plugin_path( 'framework/modules/jet-elementor-extension/jet-elementor-extension.php' ),
				)
			);
		}

		/**
		 * Returns plugin version
		 *
		 * @return string
		 */
		public function get_version() {
			return $this->version;
		}

		/**
		 * RX Theme Check
		 *
		 * @return boolean
		 */
		public function is_rx_theme() {
			$is_compatibility = false;

			$theme_compatibility_list = apply_filters( 'rx-theme-assistant/theme-compatibility-list', array(
				'RX_Theme_Setup',
			) ) ;

			if ( ! empty( $theme_compatibility_list ) ) {
				foreach ( $theme_compatibility_list as $key => $theme ) {
					if ( class_exists( $theme ) ) {
						$is_compatibility = true;

						break;
					}
				}
			}
			return $is_compatibility;
		}

		/**
		 * Returns path to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 * @return string
		 */
		public function plugin_path( $path = null ) {

			if ( ! $this->plugin_path ) {
				$this->plugin_path = trailingslashit( plugin_dir_path( __FILE__ ) );
			}

			return $this->plugin_path . $path;
		}
		/**
		 * Returns url to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 * @return string
		 */
		public function plugin_url( $path = null ) {

			if ( ! $this->plugin_url ) {
				$this->plugin_url = trailingslashit( plugin_dir_url( __FILE__ ) );
			}

			return $this->plugin_url . $path;
		}

		/**
		 * Loads the translation files.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function lang() {
			load_plugin_textdomain( 'rx-theme-assistant', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Get the template path.
		 *
		 * @return string
		 */
		public function template_path() {
			return apply_filters( 'rx-theme-assistant/template-path', 'rx-theme-assistant/' );
		}

		/**
		 * Returns path to template file.
		 *
		 * @return string|bool
		 */
		public function get_template( $name = null ) {

			$template = locate_template( $this->template_path() . $name );

			if ( ! $template ) {
				$template = $this->plugin_path( 'templates/' . $name );
			}

			if ( file_exists( $template ) ) {
				return $template;
			} else {
				return false;
			}
		}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function activation() {}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function deactivation() {}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
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

if ( ! function_exists( 'rx_theme_assistant' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function rx_theme_assistant() {
		return Rx_Theme_Assistant::get_instance();
	}
}

rx_theme_assistant();
