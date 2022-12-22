<?php

/**
 * Class description
 *
 * @package   package_name
 * @author    Rovadex
 * @license   GPL-2.0+
 */

use Elementor\Controls_Manager;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'RXTA_Section_Actions_Ext' ) ) {

	/**
	 * Define RXTA_Section_Actions_Ext class
	 */
	class RXTA_Section_Actions_Ext {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Init Handler
		 */
		public function init() {
			$avaliable_extensions = rx_theme_assistant_settings()->get( 'avaliable_extensions', false );

			if( empty( $avaliable_extensions ) || ! isset( $avaliable_extensions['section_actions'] ) || 'false' === $avaliable_extensions['section_actions'] ){
				return;
			}

			add_action( 'elementor/element/section/section_advanced/after_section_end', array( $this, 'after_advanced_ection_end' ), 10, 2 );

			add_action( 'elementor/frontend/element/before_render', array( $this, 'section_before_render' ) );

			add_action( 'elementor/frontend/section/before_render', array( $this, 'section_before_render' ) );
		}

		/**
		 * After section_layout callback
		 *
		 * @param  object $obj
		 * @param  array $args
		 * @return void
		 */
		public function after_advanced_ection_end( $obj, $args ) {

			$obj->start_controls_section(
				'rxta_sa',
				array(
					'label' => esc_html__( 'RX Section Actions', 'rx-theme-assistant' ),
					'tab'   => Controls_Manager::TAB_LAYOUT,
				)
			);

			$obj->add_control(
				'rxta_sa_notice',
				array(
					'type' => Controls_Manager::RAW_HTML,
					'raw' => esc_html__( 'The action is triggered when a user clicks on an item..', 'rx-theme-assistant' ),
				)
			);

			$obj->add_control(
				'rxta_sa_type',
				array(
					'label'   => esc_html__( 'Action Type', 'rx-theme-assistant' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => array(
						'none'   => esc_html__( 'None', 'rx-theme-assistant' ),
						'toggle_class'   => esc_html__( 'Toggle Class', 'rx-theme-assistant' ),
						'add_class' => esc_html__( 'Add Class', 'rx-theme-assistant' ),
						'remove_class'  => esc_html__( 'Remove Class', 'rx-theme-assistant' ),
						'call_user_function'   => esc_html__( 'Call User Function', 'rx-theme-assistant' ),
					),
					'render_type' => 'none',
				)
			);

			$obj->add_control(
				'rxta_sa_class_name',
				[
					'label' => esc_html__( 'Class Name', 'rx-theme-assistant' ),
					'type' => Controls_Manager::TEXT,
					'default' => '',
					'condition' => [
						'rxta_sa_type' => [ 'toggle_class', 'add_class', 'remove_class' ],
					],
					'description' => esc_html__( 'More than one class name must be specified with a space.', 'rx-theme-assistant' ),
					'render_type' => 'none',
				]
			);

			$obj->add_control(
				'rxta_sa_dependent_class_name',
				[
					'label' => esc_html__( 'Dependent Element ( Class Name )', 'rx-theme-assistant' ),
					'type' => Controls_Manager::TEXT,
					'default' => '',
					'condition' => [
						'rxta_sa_type' => [ 'toggle_class', 'add_class', 'remove_class' ],
					],
					'description' => esc_html__( 'The class of the element on which the additional class will be added or removed. If no class is specified, an additional class will be added to the current element.', 'rx-theme-assistant' ),
					'render_type' => 'none',
				]
			);


			$obj->add_control(
				'rxta_sa_function_name',
				[
					'label' => esc_html__( 'JS Function Name', 'rx-theme-assistant' ),
					'type' => Controls_Manager::TEXT,
					'default' => '',
					'condition' => [
						'rxta_sa_type' => 'call_user_function',
					],
					'description' => esc_html__( 'To call a user function, it must be in the global scope or in the "window" object.', 'rx-theme-assistant' ),
					'render_type' => 'none',
				]
			);

			$obj->end_controls_section();
		}

		/**
		 * Elementor before section render callback
		 *
		 * @param  object $obj
		 * @return void
		 */
		public function section_before_render( $obj ) {
			$data         = $obj->get_data();
			$type         = isset( $data['elType'] ) ? $data['elType'] : 'section';
			$settings     = $data['settings'];
			$data_atribut = [];

			if ( 'section' === $type && isset( $settings['rxta_sa_type'] ) && 'none' !== $settings['rxta_sa_type'] ) {
				foreach ( $settings as $key => $value ) {
					if( false !== stripos( $key, 'rxta_sa_' ) ){
						$new_key = str_replace( 'rxta_sa_', '', $key );
						$data_atribut[ $new_key ] = $value;
					}
				}

				$data_atribut = json_encode( $data_atribut );
				$obj->add_render_attribute( '_wrapper', 'data-rx-actions', [ $data_atribut ] );
			}
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
 * Returns instance of rxta_section_actions_ext
 *
 * @return object
 */
function rxta_section_actions_ext() {
	return RXTA_Section_Actions_Ext::get_instance();
}
