<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Rovadex Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Rx_Theme_Assistant_Add_Font_Awesome_5' ) ) {

	/**
	 * Define Rx_Theme_Assistant_Add_Font_Awesome_5 class
	 */
	class Rx_Theme_Assistant_Add_Font_Awesome_5 {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Init page
		 */
		public function init() {
			if ( filter_var( rx_theme_assistant_settings()->get( 'font-awesome-package' ), FILTER_VALIDATE_BOOLEAN ) ) {
				$this->add_font_awesome_icons_set();
			}
		}

		/**
		 * [add_font_awesome_icons_set description]
		 */
		public function add_font_awesome_icons_set() {
			add_action( 'elementor/controls/controls_registered', array( $this, 'font_awesome_to_icon_control' ), 20 );
			add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_icon_font' ), 11 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_icon_font' ), 11 );
		}

		/**
		 * [rx_add_theme_icons_to_icon_control description]
		 * @param  [type] $controls_manager [description]
		 * @return [type]                   [description]
		 */
		public function font_awesome_to_icon_control( $controls_manager ) {
			$default_icons = $controls_manager->get_control( 'icon' )->get_settings( 'options' );

			$font_awesome_icons_data = array(
				'icons'  => $this->get_font_awesome_icons_set( 'assets/fonts/font-awesome-5/icons.json' ),
				'format' => array(
					'brands'  => 'fab',
					'solid'   => 'fas',
					'regular' => 'far',
				),
			);

			if ( ! $font_awesome_icons_data['icons'] ) {
				return;
			}

			$font_awesome_icons_array = array();
			$icon_formats = array( 'brands' => 'fab fa-%s', );

			foreach ( $font_awesome_icons_data['icons'] as $icon_name => $icon_value ) {
				$icon_class = 'fa-' . $icon_name;

				if ( array_key_exists( 'fa ' . $icon_class, $default_icons ) ){
					unset( $default_icons[ 'fa ' . $icon_class ] );
				}

				foreach ( $icon_value->styles as $styles ) {
					if ( ! empty( $font_awesome_icons_data[ 'format' ][ $styles ] ) ) {
						$icon_class .= ' ' . $font_awesome_icons_data[ 'format' ][ $styles ];
					}

				}

				//$key = sprintf( $font_awesome_icons_data['format'], $icon );
				$font_awesome_icons_array[ $icon_class ] = $icon_value->label;
			}
			$new_icons = array_merge( $default_icons, $font_awesome_icons_array );
			$controls_manager->get_control( 'icon' )->set_settings( 'options', $new_icons );
		}

		/**
		 * Get font_awesome icons set.
		 *
		 * @return array
		 */
		public function get_font_awesome_icons_set( $file_path ) {
			$font_awesome_icons = [];

			ob_start();

			include rx_theme_assistant()->plugin_path( $file_path );

			$result = ob_get_clean();

			$json = json_decode( $result );

			return $json;
		}

		/**
		 * Enqueue icon font.
		 */
		public function enqueue_icon_font() {
			wp_enqueue_style(
				'font-awesome-5',
				rx_theme_assistant()->plugin_url( 'assets/fonts/font-awesome-5/css/all.min.css' ),
				array(),
				'5.6.3'
			);
			wp_enqueue_style(
				'font-awesome-v4-shims',
				rx_theme_assistant()->plugin_url( 'assets/fonts/font-awesome-5/css/v4-shims.min.css' ),
				array(),
				'5.6.3'
			);
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
function rx_theme_assistant_add_font_awesome_5() {
	return Rx_Theme_Assistant_Add_Font_Awesome_5::get_instance();
}

rx_theme_assistant_add_font_awesome_5()->init();
