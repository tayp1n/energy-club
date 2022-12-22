<?php

/**
 * Class description
 *
 * @package   package_name
 * @author    Rovadex
 * @license   GPL-2.0+
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Rx_Theme_Assistant_Elementor_Parallax_Ext' ) ) {

	/**
	 * Define Rx_Theme_Assistant_Elementor_Parallax_Ext class
	 */
	class Rx_Theme_Assistant_Elementor_Parallax_Ext {

		/**
		 * [$parallax_sections description]
		 * @var array
		 */
		public $parallax_sections = [];

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

			add_action( 'elementor/element/section/section_advanced/after_section_end', array( $this, 'after_advanced_ection_end' ), 10, 2 );

			add_action( 'elementor/frontend/element/before_render', array( $this, 'section_before_render' ) );

			add_action( 'elementor/frontend/section/before_render', array( $this, 'section_before_render' ) );

			add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ), 9 );
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
				'section_rx_parallax',
				array(
					'label' => esc_html__( 'Rx Theme Parallax', 'rx-theme-assistant' ),
					'tab'   => Controls_Manager::TAB_LAYOUT,
				)
			);

			$obj->add_control(
				'rx_parallax_items_heading',
				array(
					'label'     => esc_html__( 'Layouts', 'rx-theme-assistant' ),
					'type'      => Controls_Manager::HEADING,
				)
			);

			$repeater = new Repeater();

			$repeater->start_controls_tabs( 'layout_tabs' );

			$repeater->start_controls_tab(
				'layout_general_settings',
				array(
					'label' => esc_html__( 'General', 'rx-theme-assistant' ),
				)
			);

			$repeater->add_control(
				'rx_parallax_layout_image',
				array(
					'label'   => esc_html__( 'Image', 'rx-theme-assistant' ),
					'type'    => Controls_Manager::MEDIA,
					'dynamic' => array( 'active' => true ),
					'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.jet-parallax-section__layout .jet-parallax-section__image' => 'background-image: url("{{URL}}") !important;'
					),
				)
			);

			$repeater->add_control(
				'rx_parallax_layout_type',
				array(
					'label'   => esc_html__( 'Parallax Type', 'rx-theme-assistant' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'scroll',
					'options' => array(
						'none'   => esc_html__( 'None', 'rx-theme-assistant' ),
						'scroll' => esc_html__( 'Scroll', 'rx-theme-assistant' ),
						'mouse'  => esc_html__( 'Mouse Move', 'rx-theme-assistant' ),
						'zoom'   => esc_html__( 'Scrolling Zoom', 'rx-theme-assistant' ),
					),
				)
			);

			$repeater->add_control(
				'rx_parallax_layout_speed',
				array(
					'label'      => esc_html__( 'Parallax Speed(%)', 'rx-theme-assistant' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( '%' ),
					'range'      => array(
						'%' => array(
							'min'  => 1,
							'max'  => 100,
						),
					),
					'default' => array(
						'size' => 50,
						'unit' => '%',
					),
				)
			);

			$repeater->end_controls_tab();

			$repeater->start_controls_tab(
				'layout_advanced_settings',
				array(
					'label' => esc_html__( 'Advanced', 'rx-theme-assistant' ),
				)
			);

			$repeater->add_control(
				'rx_parallax_layout_bg_size',
				array(
					'label'   => esc_html__( 'Background Size', 'rx-theme-assistant' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'auto',
					'options' => array(
						'auto'    => esc_html__( 'Auto', 'rx-theme-assistant' ),
						'cover'   => esc_html__( 'Cover', 'rx-theme-assistant' ),
						'contain' => esc_html__( 'Contain', 'rx-theme-assistant' ),
					),
				)
			);

			$repeater->add_control(
				'rx_parallax_layout_animation_prop',
				array(
					'label'   => esc_html__( 'Animation Property', 'rx-theme-assistant' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'transform',
					'options' => array(
						'bgposition'  => esc_html__( 'Background Position', 'rx-theme-assistant' ),
						'transform'   => esc_html__( 'Transform', 'rx-theme-assistant' ),
						'transform3d' => esc_html__( 'Transform 3D', 'rx-theme-assistant' ),
					),
				)
			);

			$repeater->add_control(
				'rx_parallax_layout_bg_x',
				array(
					'label'   => esc_html__( 'Background X Position(%)', 'rx-theme-assistant' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 50,
					'min'     => -200,
					'max'     => 200,
					'step'    => 1,
				)
			);

			$repeater->add_control(
				'rx_parallax_layout_bg_y',
				array(
					'label'   => esc_html__( 'Background Y Position(%)', 'rx-theme-assistant' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 50,
					'min'     => -200,
					'max'     => 200,
					'step'    => 1,
				)
			);

			$repeater->add_control(
				'rx_parallax_layout_z_index',
				array(
					'label'    => esc_html__( 'z-Index', 'rx-theme-assistant' ),
					'type'     => Controls_Manager::NUMBER,
					'min'      => 0,
					'max'      => 99,
					'step'     => 1,
				)
			);

			$repeater->add_control(
				'rx_parallax_layout_on',
				array(
					'label'       => __( 'Enable On Device', 'rx-theme-assistant' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => 'true',
					'default'     => array(
						'desktop',
						'tablet',
					),
					'options'     => array(
						'desktop' => __( 'Desktop', 'rx-theme-assistant' ),
						'tablet'  => __( 'Tablet', 'rx-theme-assistant' ),
						'mobile'  => __( 'Mobile', 'rx-theme-assistant' ),
					),
				)
			);

			$repeater->add_control(
				'rx_parallax_layout_visible',
				array(
					'label'       => __( 'Visible On Device', 'rx-theme-assistant' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => 'true',
					'default'     => array(
						'desktop',
						'tablet',
						'mobile',
					),
					'options'     => array(
						'desktop' => __( 'Desktop', 'rx-theme-assistant' ),
						'tablet'  => __( 'Tablet', 'rx-theme-assistant' ),
						'mobile'  => __( 'Mobile', 'rx-theme-assistant' ),
					),
				)
			);

			$repeater->end_controls_tab();

			$repeater->end_controls_tabs();

			$obj->add_control(
				'rx_parallax_layout_list',
				array(
					'type'    => 'jet-repeater',
					//'fields'  => $repeater->get_controls(),
					'fields'  => $repeater->get_controls(),
					'default' => array(
						array(
							'rx_parallax_layout_image' => array(
								'url' => '',
							),
						)
					),
				)
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
			$data     = $obj->get_data();
			$type     = isset( $data['elType'] ) ? $data['elType'] : 'section';

			if ( 'section' === $type ) {
				$rx_parallax_layout_list = method_exists( $obj, 'get_settings_for_display' ) ? $obj->get_settings_for_display( 'rx_parallax_layout_list' ) : $data['settings']['rx_parallax_layout_list'];

				if ( $rx_parallax_layout_list && $rx_parallax_layout_list[0]['rx_parallax_layout_image']['url'] ) {
					foreach ( $rx_parallax_layout_list as $key => $value ) {
						$id = $rx_parallax_layout_list[ $key ]['rx_parallax_layout_image']['id'];
						$imega =wp_get_attachment_image_src( $id, 'full' );
						if( $imega[0] ){
							$rx_parallax_layout_list[ $key ]['rx_parallax_layout_image']['url'] = $imega[0];
						}
					}

					$this->parallax_sections[ $data['id'] ] = $rx_parallax_layout_list;
				}
			}
		}

		/**
		 * [enqueue_scripts description]
		 *
		 * @return void
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( 'rx-theme-assistant-tween-js' );

			if ( ! array_key_exists( 'rxParallaxSections', rx_theme_assistant_assets()->localize_data ) ) {
				rx_theme_assistant_assets()->localize_data['rxParallaxSections'] = $this->parallax_sections;
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
 * Returns instance of Rx_Theme_Assistant_Elementor_Parallax_Ext
 *
 * @return object
 */
function rx_theme_assistant_elementor_parallax_ext() {
	return Rx_Theme_Assistant_Elementor_Parallax_Ext::get_instance();
}
