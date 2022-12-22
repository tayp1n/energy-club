<?php
/**
 * Class adds theme supported features.
 *
 * @package    Rvdx Theme
 * @subpackage Class
 */

if ( ! class_exists( 'Rvdx_Theme_Gutenberg_Editor_Styles' ) ) {

	class Rvdx_Theme_Gutenberg_Editor_Styles{

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 * @since 1.0.1 Removed argument in constructor.
		 */
		private function __construct( $theme_support = array() ) {
			add_action( 'after_setup_theme', array( $this, 'init' ), 11 );
		}

		/**
		 * init
		 *
		 * @since  1.0.0
		 * @return void|bool false
		 */
		public function init(){
			$feature = get_theme_support( 'editor-styles' );

			if ( $feature ) {
				add_filter( 'block_editor_settings', array( $this, 'gutenberg_extend_editor_styles' ) );

				// Enqueue admin scripts.
				add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ) );
				add_editor_style(
					array(
						'assets/css/wp-gutenberg-block.css',
					)
				);
			}
		}

		/**
		 * Enqueue scripts.
		 *
		 * @since 1.0.0
		 */
		public function admin_enqueue_styles() {
			// Enqueue frontend fonts
			rvdx_theme()->customizer->fonts_manager->prepare_fonts();

			// register style
			wp_enqueue_style(
				'font-awesome',
				get_theme_file_uri( 'assets/lib/font-awesome/font-awesome.min.css' ),
				array(),
				'4.7.0'
			);
		}

		/**
		 * Extend style in gutenberg editor
		 *
		 * @since  1.0.0
		 * @return void|bool false
		 */
		public function gutenberg_extend_editor_styles( $editor_settings ) {
			$dynamic_css = rvdx_theme()->dynamic_css;
			$css = array( 'css' => $dynamic_css->get_inline_css() );

			if( ! empty( $css['css'] ) && $css['css'] ){
				array_push( $editor_settings['styles'], $css );
			}

			return $editor_settings;
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
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	function rvdx_theme_gutenberg_editor_styles() {
		return Rvdx_Theme_Gutenberg_Editor_Styles::get_instance();
	}

	rvdx_theme_gutenberg_editor_styles();
}
