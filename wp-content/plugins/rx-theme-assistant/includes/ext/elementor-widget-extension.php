<?php

// If this file is called directly, abort.

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Utils;

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Rx_Theme_Assistant_Elementor_Widget_Extension' ) ) {

	/**
	 * Define Rx_Theme_Assistant_Elementor_Widget_Extension class
	 */
	class Rx_Theme_Assistant_Elementor_Widget_Extension {

		/**
		 * Widgets Data
		 *
		 * @var array
		 */
		public $widgets_data = array();

		/**
		 * [$default_widget_settings description]
		 * @var array
		 */
		public $default_widget_settings = array(
			'rx_theme_assistant_widget_parallax'           => 'false',
			'rx_theme_assistant_widget_parallax_invert'    => 'false',
			'rx_theme_assistant_widget_parallax_speed'     => array(
				'unit' => '%',
				'size' => 50
			),
			'rx_theme_assistant_widget_parallax_on'        => array(
				'desktop',
				'tablet',
				'mobile',
			),
			'rx_theme_assistant_widget_satellite'          => 'false',
			'rx_theme_assistant_widget_satellite_type'     => 'text',
			'rx_theme_assistant_widget_satellite_position' => 'top-center',
			'rx_theme_assistant_widget_satellite_icon'     => 'fa fa-plus',
			'rx_theme_assistant_widget_satellite_image'    => array(
				'url' => '',
				'id' => '',
			)
		);

		/**
		 * [$avaliable_extensions description]
		 * @var array
		 */
		public $avaliable_extensions = array();

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

			$this->avaliable_extensions = rx_theme_assistant_settings()->get( 'avaliable_extensions', rx_theme_assistant_settings()->default_avaliable_extensions );

			if ( ! in_array( 'true', $this->avaliable_extensions ) ) {
				return false;
			}

			add_action( 'elementor/element/common/_section_style/after_section_end', array( $this, 'after_common_section_responsive' ), 10, 2 );

			add_action( 'elementor/frontend/widget/before_render', array( $this, 'widget_before_render' ) );

			add_action( 'elementor/widget/before_render_content', array( $this, 'widget_before_render_content' ) );

			add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ), 9 );
		}

		/**
		 * After section_layout callback
		 *
		 * @param  object $obj
		 * @param  array $args
		 * @return void
		 */
		public function after_common_section_responsive( $obj, $args ) {

			$obj->start_controls_section(
				'widget_rx_theme_assistant',
				array(
					'label' => esc_html__( 'RX Widget Extension', 'rx-theme-assistant' ),
					'tab'   => Controls_Manager::TAB_ADVANCED,
				)
			);

			$this->register_parallax_ext_settings( $obj );

			$this->register_satellite_ext_settings( $obj );

			$obj->end_controls_section();
		}

		/**
		 * [register_parallax_settings description]
		 * @param  [type] $obj [description]
		 * @return [type]      [description]
		 */
		public function register_parallax_ext_settings( $obj ) {

			if ( ! filter_var( $this->avaliable_extensions['widget_parallax'], FILTER_VALIDATE_BOOLEAN ) ) {
				return false;
			}

			$obj->add_control(
				'parallax_heading',
				array(
					'label' => esc_html__( 'Parallax', 'rx-theme-assistant' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$obj->add_control(
				'rx_theme_assistant_widget_parallax',
				array(
					'label'        => esc_html__( 'Use Parallax?', 'rx-theme-assistant' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
					'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
					'return_value' => 'true',
					'default'      => 'false',
				)
			);

			$obj->add_control(
				'rx_theme_assistant_widget_parallax_speed',
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
					'condition' => array(
						'rx_theme_assistant_widget_parallax' => 'true',
					),
				)
			);

			$obj->add_control(
				'rx_theme_assistant_widget_parallax_invert',
				array(
					'label'        => esc_html__( 'Invert', 'rx-theme-assistant' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
					'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
					'return_value' => 'true',
					'default'      => 'false',
					'condition' => array(
						'rx_theme_assistant_widget_parallax' => 'true',
					),
				)
			);

			$obj->add_control(
				'rx_theme_assistant_widget_parallax_on',
				array(
					'label'       => __( 'Active On', 'rx-theme-assistant' ),
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
					'condition' => array(
						'rx_theme_assistant_widget_parallax' => 'true',
					),
					'render_type' => 'template',
				)
			);
		}

		/**
		 * [register_satellite_ext_settings description]
		 * @param  [type] $obj [description]
		 * @return [type]      [description]
		 */
		public function register_satellite_ext_settings( $obj ) {

			if ( ! filter_var( $this->avaliable_extensions['widget_satellite'], FILTER_VALIDATE_BOOLEAN ) ) {
				return false;
			}

			$obj->add_control(
				'satellite_heading',
				array(
					'label'     => esc_html__( 'Satellite', 'rx-theme-assistant' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$obj->add_control(
				'rx_theme_assistant_widget_satellite',
				array(
					'label'        => esc_html__( 'Use Satellite?', 'rx-theme-assistant' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
					'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
					'return_value' => 'true',
					'default'      => 'false',
					'render_type'  => 'template',
				)
			);

			$obj->start_controls_tabs( 'rx_theme_assistant_widget_satellite_tabs' );

			$obj->start_controls_tab(
				'rx_theme_assistant_widget_satellite_settings_tab',
				array(
					'label' => esc_html__( 'Settings', 'rx-theme-assistant' ),
					'condition' => array(
						'rx_theme_assistant_widget_satellite' => 'true',
					),
				)
			);

			$obj->add_control(
				'rx_theme_assistant_widget_satellite_type',
				array(
					'label'   => esc_html__( 'Type', 'rx-theme-assistant' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'text',
					'options' => array(
						'text'  => esc_html__( 'Text', 'rx-theme-assistant' ),
						'icon'  => esc_html__( 'Icon', 'rx-theme-assistant' ),
						'image' => esc_html__( 'Image', 'rx-theme-assistant' ),
					),
					'condition' => array(
						'rx_theme_assistant_widget_satellite' => 'true',
					),
					'render_type'  => 'template',
				)
			);

			$obj->add_control(
				'rx_theme_assistant_widget_satellite_text',
				array(
					'label'       => esc_html__( 'Text', 'rx-theme-assistant' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '',
					'placeholder' => 'Lorem Ipsum',
					'condition' => array(
						'rx_theme_assistant_widget_satellite'      => 'true',
						'rx_theme_assistant_widget_satellite_type' => 'text',
					),
					'render_type'  => 'template',
				)
			);

			$obj->add_control(
				'rx_theme_assistant_widget_satellite_icon',
				array(
					'label'       => esc_html__( 'Icon', 'rx-theme-assistant' ),
					'type'        => Controls_Manager::ICON,
					'label_block' => true,
					'file'        => '',
					'default'     => 'fa fa-plus',
					'condition' => array(
						'rx_theme_assistant_widget_satellite'      => 'true',
						'rx_theme_assistant_widget_satellite_type' => 'icon',
					),
					'render_type'  => 'template',
				)
			);

			$obj->add_control(
				'rx_theme_assistant_widget_satellite_image',
				array(
					'label'   => esc_html__( 'Image', 'rx-theme-assistant' ),
					'type'    => Controls_Manager::MEDIA,
					'default' => array(
						'url' => Utils::get_placeholder_image_src(),
					),
					'condition' => array(
						'rx_theme_assistant_widget_satellite'     => 'true',
						'rx_theme_assistant_widget_satellite_type' => 'image',
					),
					'render_type'  => 'template',
				)
			);

			$obj->add_control(
				'rx_theme_assistant_widget_satellite_position',
				array(
					'label'   => esc_html__( 'Position', 'rx-theme-assistant' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'top-center',
					'options' => array(
						'top-left'      => esc_html__( 'Top Left', 'rx-theme-assistant' ),
						'top-center'    => esc_html__( 'Top Center', 'rx-theme-assistant' ),
						'top-right'     => esc_html__( 'Top Right', 'rx-theme-assistant' ),
						'middle-left'   => esc_html__( 'Middle Left', 'rx-theme-assistant' ),
						'middle-center' => esc_html__( 'Middle Center', 'rx-theme-assistant' ),
						'middle-right'  => esc_html__( 'Middle Right', 'rx-theme-assistant' ),
						'bottom-left'   => esc_html__( 'Bottom Left', 'rx-theme-assistant' ),
						'bottom-center' => esc_html__( 'Bottom Center', 'rx-theme-assistant' ),
						'bottom-right'  => esc_html__( 'Bottom Right', 'rx-theme-assistant' ),
					),
					'condition' => array(
						'rx_theme_assistant_widget_satellite' => 'true',
					),
					'render_type'  => 'template',
				)
			);

			$obj->add_responsive_control(
				'rx_theme_assistant_widget_satellite_x_offset',
				array(
					'label'      => esc_html__( 'x-Offset', 'rx-theme-assistant' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'range'      => array(
						'px' => array(
							'min' => -500,
							'max' => 500,
						),
					),
					'default' => array(
						'size' => 0,
						'unit' => 'px',
					),
					'selectors'  => array(
						'{{WRAPPER}} .rx-theme-assistant-satellite' => 'transform: translateX({{SIZE}}px);',
					),
					'condition' => array(
						'rx_theme_assistant_widget_satellite' => 'true',
					),
				)
			);

			$obj->add_responsive_control(
				'rx_theme_assistant_widget_satellite_y_offset',
				array(
					'label'      => esc_html__( 'y-Offset', 'rx-theme-assistant' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'range'      => array(
						'px' => array(
							'min' => -500,
							'max' => 500,
						),
					),
					'default' => array(
						'size' => 0,
						'unit' => 'px',
					),
					'selectors'  => array(
						'{{WRAPPER}} .rx-theme-assistant-satellite__inner' => 'transform: translateY({{SIZE}}px);',
					),
					'condition' => array(
						'rx_theme_assistant_widget_satellite' => 'true',
					),
				)
			);

			$obj->add_responsive_control(
				'rx_theme_assistant_widget_satellite_rotate',
				array(
					'label'      => esc_html__( 'Rotate', 'rx-theme-assistant' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'deg' ),
					'range'      => array(
						'deg' => array(
							'min' => -180,
							'max' => 180,
						),
					),
					'default' => array(
						'size' => 0,
						'unit' => 'deg',
					),
					'selectors'  => array(
						'{{WRAPPER}} .rx-theme-assistant-satellite .rx-theme-assistant-satellite__text span' => 'transform: rotate({{SIZE}}deg)',
						'{{WRAPPER}} .rx-theme-assistant-satellite .rx-theme-assistant-satellite__icon .rx-theme-assistant-satellite__icon-instance' => 'transform: rotate({{SIZE}}deg)',
						'{{WRAPPER}} .rx-theme-assistant-satellite .rx-theme-assistant-satellite__image .rx-theme-assistant-satellite__image-instance' => 'transform: rotate({{SIZE}}deg)',
					),
					'condition' => array(
						'rx_theme_assistant_widget_satellite' => 'true',
					),
				)
			);

			$obj->add_responsive_control(
				'rx_theme_assistant_widget_satellite_z',
				array(
					'label'   => esc_html__( 'z-Index', 'rx-theme-assistant' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 2,
					'min'     => 0,
					'max'     => 999,
					'step'    => 1,
					'condition' => array(
						'rx_theme_assistant_widget_satellite' => 'true',
					),
					'selectors'  => array(
						'{{WRAPPER}} .rx-theme-assistant-satellite' => 'z-index:{{VALUE}}',
					),
				)
			);

			$obj->end_controls_tab();

			$obj->start_controls_tab(
				'rx_theme_assistant_widget_satellite_styles_tab',
				array(
					'label' => esc_html__( 'Styles', 'rx-theme-assistant' ),
					'condition' => array(
						'rx_theme_assistant_widget_satellite' => 'true',
					),
				)
			);

			$obj->add_control(
				'rx_theme_assistant_widget_satellite_text_color',
				array(
					'label'  => esc_html__( 'Color', 'rx-theme-assistant' ),
					'type'   => Controls_Manager::COLOR,
					'condition' => array(
						'rx_theme_assistant_widget_satellite'      => 'true',
						'rx_theme_assistant_widget_satellite_type' => 'text',
					),
					'selectors' => array(
						'{{WRAPPER}} .rx-theme-assistant-satellite .rx-theme-assistant-satellite__text' => 'color: {{VALUE}}',
					),
				)
			);

			$obj->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'rx_theme_assistant_widget_satellite_text_typography',
					'selector' => '{{WRAPPER}} .rx-theme-assistant-satellite .rx-theme-assistant-satellite__text',
					'condition' => array(
						'rx_theme_assistant_widget_satellite'      => 'true',
						'rx_theme_assistant_widget_satellite_type' => 'text',
					),
				)
			);

			$obj->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				array(
					'name'     => 'rx_theme_assistant_widget_satellite_text_shadow',
					'selector' => '{{WRAPPER}} .rx-theme-assistant-satellite .rx-theme-assistant-satellite__text',
					'condition' => array(
						'rx_theme_assistant_widget_satellite'      => 'true',
						'rx_theme_assistant_widget_satellite_type' => 'text',
					),
				)
			);

			$obj->add_responsive_control(
				'rx_theme_assistant_widget_satellite_image_width',
				array(
					'label'   => esc_html__( 'Width', 'rx-theme-assistant' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 200,
					'min'     => 10,
					'max'     => 1000,
					'step'    => 1,
					'condition' => array(
						'rx_theme_assistant_widget_satellite'      => 'true',
						'rx_theme_assistant_widget_satellite_type' => 'image',
					),
					'selectors'  => array(
						'{{WRAPPER}} .rx-theme-assistant-satellite .rx-theme-assistant-satellite__image' => 'width:{{VALUE}}px',
					),
				)
			);

			$obj->add_responsive_control(
				'rx_theme_assistant_widget_satellite_image_height',
				array(
					'label'   => esc_html__( 'Height', 'rx-theme-assistant' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 200,
					'min'     => 10,
					'max'     => 1000,
					'step'    => 1,
					'condition' => array(
						'rx_theme_assistant_widget_satellite'      => 'true',
						'rx_theme_assistant_widget_satellite_type' => 'image',
					),
					'selectors'  => array(
						'{{WRAPPER}} .rx-theme-assistant-satellite .rx-theme-assistant-satellite__image' => 'height:{{VALUE}}px',
					),
				)
			);

			$obj->add_group_control(
				\Rx_Theme_Assistant_Group_Control_Box_Style::get_type(),
				array(
					'label'     => esc_html__( 'Icon Box', 'rx-theme-assistant' ),
					'name'      => 'rx_theme_assistant_widget_satellite_icon_box',
					'selector'  => '{{WRAPPER}} .rx-theme-assistant-satellite .rx-theme-assistant-satellite__icon-instance',
					'condition' => array(
						'rx_theme_assistant_widget_satellite'      => 'true',
						'rx_theme_assistant_widget_satellite_type' => 'icon',
					),
				)
			);

			if ( class_exists( 'Group_Control_Css_Filter' ) ) {
				$obj->add_group_control(
					Group_Control_Css_Filter::get_type(),
					array(
						'name'     => 'rx_theme_assistant_widget_satellite_css_filters',
						'selector' => '{{WRAPPER}} .rx-theme-assistant-satellite',
						'condition' => array(
							'rx_theme_assistant_widget_satellite'      => 'true',
						),
					)
				);
			}

			$obj->end_controls_tab();

			$obj->end_controls_tabs();
		}

		/**
		 * [widget_before_render description]
		 * @param  [type] $widget [description]
		 * @return [type]         [description]
		 */
		public function widget_before_render( $widget ) {
			$data     = $widget->get_data();
			$settings = $data['settings'];

			$settings = wp_parse_args( $settings, $this->default_widget_settings );

			$widget_settings = array();

			if ( filter_var( $settings['rx_theme_assistant_widget_parallax'], FILTER_VALIDATE_BOOLEAN ) ) {

				$widget_settings['parallax'] = filter_var( $settings['rx_theme_assistant_widget_parallax'], FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false';
				$widget_settings['invert']   = filter_var( $settings['rx_theme_assistant_widget_parallax_invert'], FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false';
				$widget_settings['speed']    = $settings['rx_theme_assistant_widget_parallax_speed'];
				$widget_settings['stickyOn'] = $settings['rx_theme_assistant_widget_parallax_on'];

				$widget->add_render_attribute( '_wrapper', array(
					'class' => 'rx-theme-assistant-parallax-widget',
				) );
			}

			if ( filter_var( $settings['rx_theme_assistant_widget_satellite'], FILTER_VALIDATE_BOOLEAN ) ) {
				$widget_settings['satellite'] = filter_var( $settings['rx_theme_assistant_widget_satellite'], FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false';
				$widget_settings['satelliteType'] = $settings['rx_theme_assistant_widget_satellite_type'];
				$widget_settings['satellitePosition'] = $settings['rx_theme_assistant_widget_satellite_position'];

				$widget->add_render_attribute( '_wrapper', array(
					'class' => 'rx-theme-assistant-satellite-widget',
				) );
			}

			$widget_settings = apply_filters(
				'rx-theme-assistant/frontend/widget/settings',
				$widget_settings,
				$widget,
				$this
			);

			if ( ! empty( $widget_settings ) ) {
				$widget->add_render_attribute( '_wrapper', array(
					'data-rx-theme-assistant-settings' => json_encode( $widget_settings ),
				) );
			}

			$this->widgets_data[ $data['id'] ] = $widget_settings;
		}

		/**
		 * [widget_before_render_content description]
		 * @return [type] [description]
		 */
		public function widget_before_render_content( $widget ) {

			$data     = $widget->get_data();
			$settings = $data['settings'];

			$settings = wp_parse_args( $settings, $this->default_widget_settings );

			foreach ( array( 'rx_theme_assistant_widget_satellite_text' ) as $setting_name ) {
				if ( empty( $settings[ $setting_name ] ) ) {
					$settings[ $setting_name ] = 'Lorem Ipsum';
				}
			}

			$settings = apply_filters( 'rx-theme-assistant/frontend/widget-content/settings', $settings, $widget, $this );

			if ( filter_var( $settings['rx_theme_assistant_widget_satellite'], FILTER_VALIDATE_BOOLEAN ) ) {
				switch ( $settings['rx_theme_assistant_widget_satellite_type'] ) {
					case 'text':

						if ( ! empty( $settings['rx_theme_assistant_widget_satellite_text'] ) ) {
							echo sprintf( '<div class="rx-theme-assistant-satellite rx-theme-assistant-satellite--%1$s"><div class="rx-theme-assistant-satellite__inner"><div class="rx-theme-assistant-satellite__text"><span>%2$s</span></div></div></div>', $settings['rx_theme_assistant_widget_satellite_position'], $settings['rx_theme_assistant_widget_satellite_text'] );
						}
					break;

					case 'icon':

						if ( ! empty( $settings['rx_theme_assistant_widget_satellite_icon'] ) ) {
							echo sprintf( '<div class="rx-theme-assistant-satellite rx-theme-assistant-satellite--%1$s"><div class="rx-theme-assistant-satellite__inner"><div class="rx-theme-assistant-satellite__icon"><div class="rx-theme-assistant-satellite__icon-instance"><i class="%2$s"></i></div></div></div></div>', $settings['rx_theme_assistant_widget_satellite_position'], $settings['rx_theme_assistant_widget_satellite_icon'] );
						}
					break;

					case 'image':

						if ( ! empty( $settings['rx_theme_assistant_widget_satellite_image']['url'] ) ) {
							echo sprintf( '<div class="rx-theme-assistant-satellite rx-theme-assistant-satellite--%1$s"><div class="rx-theme-assistant-satellite__inner"><div class="rx-theme-assistant-satellite__image"><img class="rx-theme-assistant-satellite__image-instance" src="%2$s" alt=""></div></div></div>', $settings['rx_theme_assistant_widget_satellite_position'], $settings['rx_theme_assistant_widget_satellite_image']['url'] );
						}
					break;
				}
			}

		}

		/**
		 * [enqueue_scripts description]
		 *
		 * @return void
		 */
		public function enqueue_scripts() {

			rx_theme_assistant_assets()->localize_data['elements_data']['widgets'] = $this->widgets_data;
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
 * Returns instance of Rx_Theme_Assistant_Elementor_Widget_Extension
 *
 * @return object
 */
function rx_theme_assistant_elementor_widget_ext() {
	return Rx_Theme_Assistant_Elementor_Widget_Extension::get_instance();
}
