<?php
if ( ! class_exists( 'Rvdx_Theme_Setup' ) ) {

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since 1.0.0
	 */
	class Rvdx_Theme_Setup {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * True if the page is a blog or archive.
		 *
		 * @since 1.0.0
		 * @var   Boolean
		 */
		private $is_blog = false;

		/**
		 * Sidebar position.
		 *
		 * @since 1.0.0
		 * @var   String
		 */
		public $sidebar_position = 'none';

		/**
		 * Loaded modules
		 *
		 * @var array
		 */
		public $modules = array();

		/**
		 * Theme version
		 *
		 * @var string
		 */
		public $version;

		/**
		 * Framework component
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    object
		 */
		public $framework;

		/**
		 * A reference to an instance of this class CX_Dynamic_CSS
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    object
		 */
		public $dynamic_css;

		/**
		 * Sets up needed actions/filters for the theme to initialize.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			$template      = get_template();
			$theme_obj     = wp_get_theme( $template );
			$this->version = $theme_obj->get( 'Version' );

			// Load the theme modules.
			add_action( 'after_setup_theme', array( $this, 'rvdx_theme_framework_loader' ), -20 );

			// Initialization of customizer.
			add_action( 'after_setup_theme', array( $this, 'rvdx_theme_customizer' ) );

			// Initialization of breadcrumbs module
			add_action( 'wp_head', array( $this, 'rvdx_theme_breadcrumbs' ) );

			// Language functions and translations setup.
			add_action( 'after_setup_theme', array( $this, 'l10n' ), 2 );

			// Handle theme supported features.
			add_action( 'after_setup_theme', array( $this, 'theme_support' ), 3 );

			// Load the theme includes.
			add_action( 'after_setup_theme', array( $this, 'includes' ), 4 );

			// Load theme modules.
			add_action( 'after_setup_theme', array( $this, 'load_modules' ), 5 );

			// Init properties.
			add_action( 'wp_head', array( $this, 'rvdx_theme_init_properties' ) );

			// Register public assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 9 );

			// Enqueue scripts.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );

			// Enqueue styles.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );

			// Maybe register Elementor Pro locations.
			add_action( 'elementor/theme/register_locations', array( $this, 'elementor_locations' ) );

			// Register plugins config for Jet Plugins Wizard.
			add_action( 'init', array( $this, 'register_plugins_wizard_config' ), 5 );

			// Register import config for Jet Data Importer.
			add_action( 'init', array( $this, 'register_data_importer_config' ), 5 );

		}

		/**
		 * Retuns theme version
		 *
		 * @return string
		 */
		public function version() {
			return apply_filters( 'rvdx-theme/version', $this->version );
		}

		/**
		 * Load the theme modules.
		 *
		 * @since  1.0.0
		 */
		public function rvdx_theme_framework_loader() {

			require get_theme_file_path( 'framework/loader.php' );

			$this->framework = new Rvdx_Theme_CX_Loader(
				array(
					get_theme_file_path( 'framework/modules/customizer/cherry-x-customizer.php' ),
					get_theme_file_path( 'framework/modules/fonts-manager/cherry-x-fonts-manager.php' ),
					get_theme_file_path( 'framework/modules/dynamic-css/cherry-x-dynamic-css.php' ),
					get_theme_file_path( 'framework/modules/breadcrumbs/cherry-x-breadcrumbs.php' ),
				)
			);
		}

		/**
		 * Run initialization of customizer.
		 *
		 * @since 1.0.0
		 */
		public function rvdx_theme_customizer() {

			$this->customizer = new CX_Customizer( rvdx_theme_get_customizer_options() );
			$this->dynamic_css = new CX_Dynamic_CSS( rvdx_theme_get_dynamic_css_options() );

		}

		/**
		 * Run initialization of breadcrumbs.
		 *
		 * @since 1.0.0
		 */
		public function rvdx_theme_breadcrumbs() {

			$this->breadcrumbs = new CX_Breadcrumbs( rvdx_theme_get_breadcrumbs_options() );

		}

		/**
		 * Run init init properties.
		 *
		 * @since 1.0.0
		 */
		public function rvdx_theme_init_properties() {

			$this->is_blog = is_home() || ( is_archive() && ! is_tax() && ! is_post_type_archive() ) ? true : false;

			// Blog list properties init
			if ( $this->is_blog ) {
				$this->sidebar_position = rvdx_theme()->customizer->get_value( 'blog_sidebar_position' );
			}

			// Single blog properties init
			if ( is_singular( 'post' ) ) {
				$this->sidebar_position = rvdx_theme()->customizer->get_value( 'single_sidebar_position' );
			}

		}

		/**
		 * [is_blog description]
		 * @return boolean [description]
		 */
		public function is_blog() {
			return is_home() || ( is_archive() && ! is_tax() && ! is_post_type_archive() ) ? true : false;
		}

		/**
		 * Loads the theme translation file.
		 *
		 * @since 1.0.0
		 */
		public function l10n() {

			/*
			 * Make theme available for translation.
			 * Translations can be filed in the /languages/ directory.
			 */
			load_theme_textdomain( 'fitmax', get_theme_file_path( 'languages' ) );

		}

		/**
		 * Adds theme supported features.
		 *
		 * @since 1.0.0
		 */
		public function theme_support() {

			global $content_width;

			if ( ! isset( $content_width ) ) {
				$content_width = 1200;
			}

			// Add support for core custom logo.
			add_theme_support( 'custom-logo', array(
				'height'      => 35,
				'width'       => 135,
				'flex-width'  => true,
				'flex-height' => true
			) );

			// Enable support for Post Thumbnails on posts and pages.
			add_theme_support( 'post-thumbnails' );

			// Enable HTML5 markup structure.
			add_theme_support( 'html5', array(
				'comment-list', 'comment-form', 'search-form', 'gallery', 'caption',
			) );

			// Enable default title tag.
			add_theme_support( 'title-tag' );

			// Enable post formats.
			add_theme_support( 'post-formats', array(
				'gallery', 'image', 'link', 'quote', 'video', 'audio',
			) );

			// Add default posts and comments RSS feed links to head.
			add_theme_support( 'automatic-feed-links' );

			//Enable builded custom headers and footers
			add_theme_support( 'header-footer-elementor' );

			//Add gutenberg blocks support
			add_theme_support( 'wp-block-styles' );

			//Add gutenberg blocks align
			add_theme_support( 'align-wide' );


			//Add gutenberg editor styles
			add_theme_support( 'editor-styles' );

			//Add gutenberg editor ditor style
			add_theme_support( 'dark-editor-style' );

		}

		/**
		 * Loads the theme files supported by themes and template-related functions/classes.
		 *
		 * @since 1.0.0
		 */
		public function includes() {


			/**
			 * Class add gutenberg editor styles
			*/
			require_once get_theme_file_path( 'inc/classes/class-gutenberg-editor-styles.php' );

			/**
			 * Configurations.
			 */
			require_once get_theme_file_path( 'config/layout.php' );
			require_once get_theme_file_path( 'config/menus.php' );
			require_once get_theme_file_path( 'config/sidebars.php' );
			require_once get_theme_file_path( 'config/modules.php' );

			require_if_theme_supports( 'post-thumbnails', get_theme_file_path( 'config/thumbnails.php' ) );

			require_once get_theme_file_path( 'inc/modules/base.php' );

			/**
			 * Classes.
			*/
			require_once get_theme_file_path( 'inc/classes/class-widget-area.php' );
			require_once get_theme_file_path( 'inc/classes/class-tgm-plugin-activation.php' );

			/**
			 * Functions.
			 */
			require_once get_theme_file_path( 'inc/template-tags.php' );
			require_once get_theme_file_path( 'inc/template-menu.php' );
			require_once get_theme_file_path( 'inc/template-comment.php' );
			require_once get_theme_file_path( 'inc/template-related-posts.php' );
			require_once get_theme_file_path( 'inc/extras.php' );
			require_once get_theme_file_path( 'inc/customizer.php' );
			require_once get_theme_file_path( 'inc/breadcrumbs.php' );
			require_once get_theme_file_path( 'inc/mobile-panel.php' );
			require_once get_theme_file_path( 'inc/context.php' );
			require_once get_theme_file_path( 'inc/hooks.php' );
			require_once get_theme_file_path( 'inc/register-plugins.php' );
		}

		/**
		 * Modules base path
		 *
		 * @return string
		 */
		public function modules_base() {

			return 'inc/modules/';
		}

		/**
		 * Returns module class by name
		 * @return [type] [description]
		 */
		public function get_module_class( $name ) {

			$module = str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $name ) ) );
			return 'Rvdx_Theme_' . $module . '_Module';

		}

		/**
		 * Load theme and child theme modules
		 *
		 * @return void
		 */
		public function load_modules() {

			$disabled_modules = apply_filters( 'rvdx-theme/disabled-modules', array() );

			foreach ( rvdx_theme_get_allowed_modules() as $module => $childs ) {
				if ( ! in_array( $module, $disabled_modules ) ) {
					$this->load_module( $module, $childs );
				}
			}

		}

		public function load_module( $module = '', $childs = array() ) {

			if ( ! file_exists( get_theme_file_path( $this->modules_base() . $module . '/module.php' ) ) ) {
				return;
			}

			require_once get_theme_file_path( $this->modules_base() . $module . '/module.php' );
			$class = $this->get_module_class( $module );

			if ( ! class_exists( $class ) ) {
				return;
			}

			$instance = new $class( $childs );

			$this->modules[ $instance->module_id() ] = $instance;

		}

		/**
		 * Register assets.
		 *
		 * @since 1.0.0
		 */
		public function register_assets() {

			wp_register_script(
				'magnific-popup',
				get_theme_file_uri( 'assets/lib/magnific-popup/jquery.magnific-popup.min.js' ),
				array( 'jquery' ),
				'1.1.0',
				true
			);

			wp_register_script(
				'jquery-swiper',
				get_theme_file_uri( 'assets/lib/swiper/swiper.jquery.min.js' ),
				array( 'jquery' ),
				'4.4.6',
				true
			);

			wp_register_script(
				'jquery-totop',
				get_theme_file_uri( 'assets/js/jquery.ui.totop.min.js' ),
				array( 'jquery' ),
				'1.2.0',
				true
			);

			wp_register_script(
				'responsive-menu',
				get_theme_file_uri( 'assets/js/responsive-menu.js' ),
				array(),
				'1.0.0',
				true
			);

			// register style
			wp_register_style(
				'font-awesome',
				get_theme_file_uri( 'assets/lib/font-awesome/font-awesome.min.css' ),
				array(),
				'4.7.0'
			);

			wp_register_style(
				'magnific-popup',
				get_theme_file_uri( 'assets/lib/magnific-popup/magnific-popup.min.css' ),
				array(),
				'1.1.0'
			);

			wp_register_style(
				'jquery-swiper',
				get_theme_file_uri( 'assets/lib/swiper/swiper.min.css' ),
				array(),
				'4.4.6'
			);

		}

		/**
		 * Enqueue scripts.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_scripts() {

			/**
			 * Filter the depends on main theme script.
			 *
			 * @since 1.0.0
			 * @var   array
			 */
			$scripts_depends = 	apply_filters( 'rvdx-theme/assets-depends/script', array(
				'jquery',
				'responsive-menu',
			) );

			if ( $this->is_blog() || is_singular( 'post' ) ) {
				array_push( $scripts_depends, 'magnific-popup', 'jquery-swiper' );
			}

			wp_enqueue_script(
				'rvdx-theme-script',
				get_theme_file_uri( 'assets/js/theme-script.js' ),
				$scripts_depends,
				$this->version(),
				true
			);

			// Threaded Comments.
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

		}

		/**
		 * Enqueue styles.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_styles() {

			/**
			 * Filter the depends on main theme styles.
			 *
			 * @since 1.0.0
			 * @var   array
			 */
			$styles_depends = apply_filters( 'rvdx-theme/assets-depends/styles', array(
				'font-awesome',
			) );

			if ( $this->is_blog() || is_singular( 'post' ) ) {
				array_push($styles_depends, 'magnific-popup', 'jquery-swiper' );
			}

			wp_enqueue_style(
				'rvdx-theme-style',
				get_stylesheet_uri(),
				$styles_depends,
				$this->version()
			);

			if ( is_rtl() ) {
				wp_enqueue_style(
					'rtl',
					get_theme_file_uri( 'rtl.css' ),
					false,
					$this->version()
				);
			}

		}


		/**
		 * Do Elementor or Header & Footer location
		 *
		 * @return bool
		 */
		public function do_location( $location = null, $fallback = null ) {
			$done    = false;

			switch ( true ) {
				case class_exists( 'Header_Footer_Elementor' ) && class_exists( 'Rx_Theme_Assistant_Header_Footer_Plugin_Ext' ) && in_array( $location, [ 'header', 'footer'] ):
					$handler = array( 'Rx_Theme_Assistant_Header_Footer_Plugin_Ext', 'rx_theme_assistant_return_template' );
				break;

				case class_exists( 'Rx_Theme_Assistant_Dynamic_Pages' ) && in_array( $location, [ 'archive', 'single-post-content', '404-page', 'search-fail' ] ):
					$handler = array( 'Rx_Theme_Assistant_Dynamic_Pages', 'get_page_template' );
				break;

				case function_exists( 'elementor_theme_do_location' ):
					$handler = 'elementor_theme_do_location';
				break;

				default:
					$handler = false;
				break;
			}

			// If handler is found - try to do passed location
			if ( false !== $handler ) {
				$done = call_user_func( $handler, $location );
			}

			if ( true === $done ) {
				// If location successfully done - return true
				return true;
			} elseif ( null !== $fallback ) {
				// If for some reasons location coludn't be done and passed fallback template name - include this template and return
				if ( is_array( $fallback ) ) {
					// fallback in name slug format
					get_template_part( $fallback[0], $fallback[1] );
				} else {
					// fallback with just a name
					get_template_part( $fallback );
				}
				return true;
			}

			// In other cases - return false
			return false;

		}

		/**
		 * Register Elemntor Pro locations
		 *
		 * @return [type] [description]
		 */
		public function elementor_locations( $elementor_theme_manager ) {

			// Do nothing if Header & Footer Elementor is active.
			if ( class_exists( 'Header_Footer_Elementor' ) ) {
				return;
			}

			$elementor_theme_manager->register_location( 'header' );
			$elementor_theme_manager->register_location( 'footer' );

		}

		/**
		 * Register plugins config for Jet Plugins Wizard.
		 *
		 * @since 1.0.0
		 */
		public function register_plugins_wizard_config() {
			if ( ! function_exists( 'rx_theme_wizard_register_config' ) ) {
				return;
			}

			if ( ! is_admin() ) {
				return;
			}

			require_once get_parent_theme_file_path( 'config/plugins-wizard.php' );

			/**
			 * @var array $config Defined in config file.
			 */
			rx_theme_wizard_register_config( $config );
		}

		/**
		 * Register import config for Jet Data Importer.
		 *
		 * @since 1.0.0
		 */
		public function register_data_importer_config() {
			if ( ! function_exists( 'jet_data_importer_register_config' ) ) {
				return;
			}

			require_once get_parent_theme_file_path( 'config/import.php' );

			/**
			 * @var array $config Defined in config file.
			 */
			jet_data_importer_register_config( $config );
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

/**
 * Returns instanse of main theme configuration class.
 *
 * @since  1.0.0
 * @return object
 */
function rvdx_theme() {

	return Rvdx_Theme_Setup::get_instance();

}

rvdx_theme();
function webp_upload_mimes( $existing_mimes ) {
	// add webp to the list of mime types
	$existing_mimes['webp'] = 'image/webp';

	// return the array back to the function with our added mime type
	return $existing_mimes;
}
add_filter( 'mime_types', 'webp_upload_mimes' );