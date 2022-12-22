<?php

use Elementor\Plugin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Rx_Assistant_Integration' ) ) {

	/**
	 * Define Rx_Assistant_Integration class
	 */
	class Rx_Assistant_Integration {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Initalize integration hooks
		 *
		 * @return void
		 */
		public function init() {

			add_action( 'elementor/init', array( $this, 'register_category' ) );

			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_addons' ), 10 );

			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_vendors' ), 20 );

			add_action( 'elementor/controls/controls_registered', array( $this, 'add_controls' ), 10 );

			// Init Jet Elementor Extension module
			$ext_module_data = rx_theme_assistant()->framework->get_included_module_data( 'jet-elementor-extension.php' );

			Jet_Elementor_Extension\Module::get_instance(
				array(
					'path' => $ext_module_data['path'],
					'url'  => $ext_module_data['url'],
				)
			);
		}

		/**
		 * Register `rx-theme-assistant` category for elementor if not exists
		 *
		 * @return void
		 */
		public function register_category() {

			$elements_manager = Plugin::instance()->elements_manager;

			$elements_manager->add_category(
				'rx-theme-assistant',
				array(
					'title' => esc_html__( 'Rx Theme Assistant', 'rx-theme-assistant' ),
					'icon'  => 'font',
				),
				1
			);

			$elements_manager->add_category(
				'rx-dynamic-posts',
				array(
					'title' => esc_html__( 'Rx Dynamic Posts', 'rx-theme-assistant' ),
					'icon'  => 'font',
				),
				1
			);
		}

		/**
		 * Register plugin addons
		 *
		 * @param  object $widgets_manager Elementor widgets manager instance.
		 * @return void
		 */
		public function register_addons( $widgets_manager ) {

			require rx_theme_assistant()->plugin_path( 'includes/base/class-rx-theme-assistant-base.php' );

			$avaliable_widgets = rx_theme_assistant_settings()->get( 'avaliable_widgets' );

			foreach ( glob( rx_theme_assistant()->plugin_path( 'includes/addons/' ) . '*.php' ) as $file ) {

				$slug    = basename( $file, '.php' );
				$enabled = isset( $avaliable_widgets[ $slug ] ) ? $avaliable_widgets[ $slug ] : '';

				if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) || ! $avaliable_widgets ) {
					$this->register_addon( $file, $widgets_manager );
				}
			}
		}

		/**
		 * Register vendor addons
		 *
		 * @param  object $widgets_manager Elementor widgets manager instance.
		 * @return void
		 */
		public function register_vendors( $widgets_manager ) {

			$conditional_check = array(
				'callback' => 'class_exists',
				'arg'      => 'WooCommerce',
			);

			$allowed = apply_filters(
				'rx-theme-assistant/allowed-vendor-widgets',
				array(
					'woo_shop_cart' => array(
						'file' => rx_theme_assistant()->plugin_path(
							'includes/addons/third-party/rx-theme-assistant-shop-cart.php'
						),
						'conditional' => $conditional_check,
					),
				)
			);

			foreach ( $allowed as $item ) {
				if ( is_callable( $item['conditional']['callback'] )
					&& true === call_user_func( $item['conditional']['callback'], $item['conditional']['arg'] ) ) {
					$this->register_addon( $item['file'], $widgets_manager );
				}
			}
		}

		/**
		 * Register addon by file name
		 *
		 * @param  string $file            File name.
		 * @param  object $widgets_manager Widgets manager instance.
		 * @return void
		 */
		public function register_addon( $file, $widgets_manager ) {

			$base  = basename( str_replace( '.php', '', $file ) );
			$class = ucwords( str_replace( '-', ' ', $base ) );
			$class = str_replace( ' ', '_', $class );
			$class = sprintf( 'Elementor\%s', $class );

			require $file;

			if ( class_exists( $class ) ) {
				$widgets_manager->register_widget_type( new $class );
			}
		}

		/**
		 * Add new controls.
		 *
		 * @param  object $controls_manager Controls manager instance.
		 * @return void
		 */
		public function add_controls( $controls_manager ) {

			$grouped = array(
				'rx-theme-assistant-box-style'       => 'Rx_Theme_Assistant_Group_Control_Box_Style',
				'rx-theme-assistant-transform-style' => 'Rx_Theme_Assistant_Group_Control_Transform_Style',
			);

			foreach ( $grouped as $control_id => $class_name ) {
				if ( $this->include_control( $class_name, true ) ) {
					$controls_manager->add_group_control( $control_id, new $class_name() );
				}
			}
		}

		/**
		 * Include control file by class name.
		 *
		 * @param  [type] $class_name [description]
		 * @return [type]             [description]
		 */
		public function include_control( $class_name, $grouped = false ) {

			$filename = sprintf(
				'includes/controls/%2$sclass-%1$s.php',
				str_replace( '_', '-', strtolower( $class_name ) ),
				( true === $grouped ? 'groups/' : '' )
			);

			if ( ! file_exists( rx_theme_assistant()->plugin_path( $filename ) ) ) {
				return false;
			}

			require rx_theme_assistant()->plugin_path( $filename );

			return true;
		}

		/**
		 * Check if we currently in Elementor mode
		 *
		 * @since  1.3.0
		 * @return boolean
		 */
		public function in_elementor() {
			$result = false;

			if ( wp_doing_ajax() ) {
				$result = ( isset( $_REQUEST['action'] ) && 'elementor_ajax' === $_REQUEST['action'] );
			} elseif ( Plugin::instance()->editor->is_edit_mode()
				&& 'wp_enqueue_scripts' === current_filter() ) {
				$result = true;
			} elseif ( Plugin::instance()->preview->is_preview_mode() && 'wp_enqueue_scripts' === current_filter() ) {
				$result = true;
			}

			return apply_filters( 'rx-theme-assistant/in-elementor', $result );
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance( $shortcodes = array() ) {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self( $shortcodes );
			}
			return self::$instance;
		}
	}

}

function rx_theme_assistant_integration() {
	return Rx_Assistant_Integration::get_instance();
}
