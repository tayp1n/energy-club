<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Rovadex Team
 * @license   GPL-2.0+
 */

use Elementor\Plugin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Rx_Theme_Assistant_Dynamic_Pages' ) ) {

	/**
	 * Define Rx_Theme_Assistant_Add_Font_Awesome_5 class
	 */
	class Rx_Theme_Assistant_Dynamic_Pages {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;


		/**
		 * Sets up needed actions/filters for the theme to initialize.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

		}

		/**
		 * Get page template.
		 *
		 * @since 1.0.0
		 */
		static public function get_page_template() {

			switch ( true ) {
				case is_404():
					$result =rx_theme_assistant_settings()->get( 'dynamic_404_pages', false );
				break;

				case is_search() && ! have_posts():
					$result = rx_theme_assistant_settings()->get( 'dynamic_search_pages', false );
				break;

				case is_single() && 'post' === get_post_type():
					$result = rx_theme_assistant_settings()->get( 'dynamic_single_blog_pages', false );
				break;

				case rx_theme_assistant_tools()->is_blog() && ! is_single():
					$result = rx_theme_assistant_settings()->get( 'dynamic_blog_pages', false );
				break;

				default:
					$result = false;
				break;
			}

			if( 'default' !== $result && true !== $result && $result ){
				echo Plugin::$instance->frontend->get_builder_content_for_display( $result );

				$result = true;
			}
			return $result;
		}

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

/**
 * Returns instance of Rx_Theme_Assistant_Add_Font_Awesome_5
 *
 * @return object
 */
function rx_theme_assistant_dynamic_pages() {
	return Rx_Theme_Assistant_Dynamic_Pages::get_instance();
}

rx_theme_assistant_dynamic_pages();
