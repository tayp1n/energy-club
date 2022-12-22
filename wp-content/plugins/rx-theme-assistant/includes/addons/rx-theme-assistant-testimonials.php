<?php
/**
 * Class: Rx_Theme_Assistant_Testimonials
 * Name: Testimonials Carousel
 * Slug: rx-theme-assistant-testimonials
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rx_Theme_Assistant_Testimonials extends Rx_Theme_Assistant_Base {

	public function get_name() {
		return 'rx-theme-assistant-testimonials';
	}

	public function get_title() {
		return esc_html__( 'Testimonials Carousel', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories() {
		return array( 'rx-theme-assistant' );
	}

	public function get_script_depends() {
		return array( 'jquery-slick' );
	}

	protected function register_controls() {
		$css_scheme = apply_filters(
			'rx-theme-assistant/testimonials/css-scheme',
			array(
				'instance'   => '.rx-theme-assistant-testimonials__instance',
				'item'       => '.rx-theme-assistant-testimonials__item',
				'item_inner' => '.rx-theme-assistant-testimonials__item-inner',
				'image'      => '.rx-theme-assistant-testimonials__figure',
				'image_tag'  => '.rx-theme-assistant-testimonials__tag-img',
				'content'    => '.rx-theme-assistant-testimonials__content',
				'icon'       => '.rx-theme-assistant-testimonials__icon',
				'icon_inner' => '.rx-theme-assistant-testimonials__icon-inner',
				'title'      => '.rx-theme-assistant-testimonials__title',
				'comment'    => '.rx-theme-assistant-testimonials__comment',
				'name'       => '.rx-theme-assistant-testimonials__name',
				'position'   => '.rx-theme-assistant-testimonials__position',
				'date'       => '.rx-theme-assistant-testimonials__date',
				'rating'     => '.rx-theme-assistant-testimonials__rating',
				'arrow'      => '.rx-theme-assistant-testimonials__instance .rx-theme-assistant-arrow',
				'dots'       => '.rx-theme-assistant-testimonials__instance .rx-theme-assistant-slick-dots',
			)
		);

		$preset_options = apply_filters(
			'rx-theme-assistant/testimonials/preset',
			array(
					'default' => esc_html__( 'Default', 'rx-theme-assistant' ),
			)
		);

		$this->start_controls_section(
			'section_settings',
			array(
				'label' => esc_html__( 'Settings', 'rx-theme-assistant' ),
			)
		);

		if( 1 < count( $preset_options ) ){
			$this->add_control(
				'preset',
				array(
					'label'   => esc_html__( 'Preset', 'rx-theme-assistant' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'default',
					'options' => $preset_options,
				)
			);
		}

		$this->add_responsive_control(
			'slides_to_show',
			array(
				'label'   => esc_html__( 'Slides to Show', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => rx_theme_assistant_tools()->get_select_range( 10 ),
			)
		);

		$this->add_control(
			'slides_to_scroll',
			array(
				'label'     => esc_html__( 'Slides to Scroll', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => rx_theme_assistant_tools()->get_select_range( 10 ),
				'condition' => array(
					'slides_to_show!' => '1',
				),
			)
		);

		$this->add_control(
			'pause_on_hover',
			array(
				'label'        => esc_html__( 'Pause on Hover', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => '',
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'     => esc_html__( 'Autoplay Speed', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => array(
					'autoplay' => 'true',
				),
			)
		);

		$this->add_control(
			'infinite',
			array(
				'label'        => esc_html__( 'Infinite Loop', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'adaptive_height',
			array(
				'label'        => esc_html__( 'Adaptive Height', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'effect',
			array(
				'label'   => esc_html__( 'Effect', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => array(
					'slide' => esc_html__( 'Slide', 'rx-theme-assistant' ),
					'fade'  => esc_html__( 'Fade', 'rx-theme-assistant' ),
				),
				'condition' => array(
					'slides_to_show' => '1',
				),
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'   => esc_html__( 'Animation Speed', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
			)
		);

		$this->add_control(
			'arrows',
			array(
				'label'        => esc_html__( 'Show Arrows Navigation', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'prev_arrow',
			array(
				'label'   => esc_html__( 'Prev Arrow Icon', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fa fa-angle-left',
				'options' => rx_theme_assistant_tools()->get_available_prev_arrows_list(),
				'condition' => array(
					'arrows' => 'true',
				),
			)
		);

		$this->add_control(
			'next_arrow',
			array(
				'label'   => esc_html__( 'Next Arrow Icon', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fa fa-angle-right',
				'options' => rx_theme_assistant_tools()->get_available_next_arrows_list(),
				'condition' => array(
					'arrows' => 'true',
				),
			)
		);

		$this->add_control(
			'dots',
			array(
				'label'        => esc_html__( 'Show Dots Navigation', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_items_data',
			array(
				'label' => esc_html__( 'Items', 'rx-theme-assistant' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_image',
			array(
				'label'   => esc_html__( 'Image', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_advanced_icon_control(
			'item_icon',
			[
				'label'       => esc_html__( 'Icon', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::ICONS,
				'skin'    => 'inline',
				'label_block' => false,
				'file'    => '',
				'fa5_default' => [
					'value'   => 'fas fa-quote-left',
					'library' => 'solid',
				],
			],
			$repeater
		);

		$repeater->add_control(
			'item_title',
			array(
				'label'   => esc_html__( 'Title', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'item_comment',
			array(
				'label'   => esc_html__( 'Comment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'item_name',
			array(
				'label'   => esc_html__( 'Name', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'item_position',
			array(
				'label'   => esc_html_x( 'Position', 'Position at work', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'item_date',
			array(
				'label'   => esc_html__( 'Date', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'item_rating',
			array(
				'label'   => esc_html__( 'Rating', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 0,
				'options' => array(
					'0' => esc_html__( 'Hidden', 'rx-theme-assistant' ),
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
				),
			)
		);

		$this->add_control(
			'item_list',
			array(
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'item_comment'  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'rx-theme-assistant' ),
						'item_name'     => esc_html__( 'Mary Scott', 'rx-theme-assistant' ),
						'item_position' => esc_html__( 'Founder & CEO', 'rx-theme-assistant' ),
						'item_date'     => esc_html__( 'Thursday, August 31, 2017', 'rx-theme-assistant' ),
					),
					array(
						'item_comment'  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'rx-theme-assistant' ),
						'item_name'     => esc_html__( 'John Borthwick', 'rx-theme-assistant' ),
						'item_position' => esc_html__( 'Founder & CEO', 'rx-theme-assistant' ),
						'item_date'     => esc_html__( 'Thursday, August 31, 2017', 'rx-theme-assistant' ),
					),
					array(
						'item_comment'  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'rx-theme-assistant' ),
						'item_name'     => esc_html__( 'Jane Bill', 'rx-theme-assistant' ),
						'item_position' => esc_html__( 'Founder & CEO', 'rx-theme-assistant' ),
						'item_date'     => esc_html__( 'Thursday, August 31, 2017', 'rx-theme-assistant' ),
					),
					array(
						'item_comment'  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'rx-theme-assistant' ),
						'item_name'     => esc_html__( 'David Anderson', 'rx-theme-assistant' ),
						'item_position' => esc_html__( 'Founder & CEO', 'rx-theme-assistant' ),
						'item_date'     => esc_html__( 'Thursday, August 31, 2017', 'rx-theme-assistant' ),
					),
					array(
						'item_comment'  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'rx-theme-assistant' ),
						'item_name'     => esc_html__( 'Susan O’Neill', 'rx-theme-assistant' ),
						'item_position' => esc_html__( 'Founder & CEO', 'rx-theme-assistant' ),
						'item_date'     => esc_html__( 'Thursday, August 31, 2017', 'rx-theme-assistant' ),
					),
					array(
						'item_comment'  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'rx-theme-assistant' ),
						'item_name'     => esc_html__( 'Ryan King', 'rx-theme-assistant' ),
						'item_position' => esc_html__( 'Founder & CEO', 'rx-theme-assistant' ),
						'item_date'     => esc_html__( 'Thursday, August 31, 2017', 'rx-theme-assistant' ),
					),
				),
				'title_field' => '{{{ item_title }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_item_style',
			array(
				'label'      => esc_html__( 'Item', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'equal_height_cols',
			array(
				'label'        => esc_html__( 'Equal Items Height', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => '',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'item_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item_inner'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'item_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['item_inner'],
			)
		);

		$this->add_control(
			'item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item_inner'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item_inner'],
			)
		);

		$this->add_responsive_control(
			'item_margin',
			array(
				'label'       => esc_html__( 'Item Margin', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px' ),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['item_inner'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					//'{{WRAPPER}} ' . $css_scheme['instance']   => 'margin-right: -{{RIGHT}}{{UNIT}}; margin-left: -{{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'item_padding',
			array(
				'label'       => esc_html__( 'Item Padding', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px' ),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['item_inner'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);


		$this->end_controls_section();

		/*
		 * Image section
		 */
		$this->start_controls_section(
			'section_image_style',
			array(
				'label'      => esc_html__( 'Image', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'image_width',
			array(
				'label'      => esc_html__( 'Width', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 1000,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array(
					'size' => 150,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['image_tag'] => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_height',
			array(
				'label'      => esc_html__( 'Height', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 50,
						'max' => 800,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array(
					'size' => 150,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['image_tag'] => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'image_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['image'],
			)
		);

		$this->add_control(
			'image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['image'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['image'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'image_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['image'],
			)
		);

		$this->add_responsive_control(
			'image_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['image'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Arrows section
		 */
		$this->start_controls_section(
			'section_arrows_style',
			array(
				'label'      => esc_html__( 'Arrows', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_arrows_style' );

		$this->start_controls_tab(
			'tab_arrows_normal',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_group_control(
			\Rx_Theme_Assistant_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'arrows_style',
				'label'          => esc_html__( 'Arrows Style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['arrow'],
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_arrows_hover',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_group_control(
			\Rx_Theme_Assistant_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'arrows_hover_style',
				'label'          => esc_html__( 'Arrows Style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['arrow'] . ':hover',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prev_arrow_position',
			array(
				'label'     => esc_html__( 'Prev Arrow Position', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prev_vert_position',
			array(
				'label'   => esc_html__( 'Vertical Position by', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'    => esc_html__( 'Top', 'rx-theme-assistant' ),
					'bottom' => esc_html__( 'Bottom', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_responsive_control(
			'prev_top_position',
			array(
				'label'      => esc_html__( 'Top Indent', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'prev_vert_position' => 'top',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.prev-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'prev_bottom_position',
			array(
				'label'      => esc_html__( 'Bottom Indent', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'prev_vert_position' => 'bottom',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.prev-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				),
			)
		);

		$this->add_control(
			'prev_hor_position',
			array(
				'label'   => esc_html__( 'Horizontal Position by', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'  => esc_html__( 'Left', 'rx-theme-assistant' ),
					'right' => esc_html__( 'Right', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_responsive_control(
			'prev_left_position',
			array(
				'label'      => esc_html__( 'Left Indent', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'prev_hor_position' => 'left',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.prev-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'prev_right_position',
			array(
				'label'      => esc_html__( 'Right Indent', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'prev_hor_position' => 'right',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.prev-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			)
		);

		$this->add_control(
			'next_arrow_position',
			array(
				'label'     => esc_html__( 'Next Arrow Position', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'next_vert_position',
			array(
				'label'   => esc_html__( 'Vertical Position by', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'    => esc_html__( 'Top', 'rx-theme-assistant' ),
					'bottom' => esc_html__( 'Bottom', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_responsive_control(
			'next_top_position',
			array(
				'label'      => esc_html__( 'Top Indent', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'next_vert_position' => 'top',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.next-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'next_bottom_position',
			array(
				'label'      => esc_html__( 'Bottom Indent', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'next_vert_position' => 'bottom',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.next-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				),
			)
		);

		$this->add_control(
			'next_hor_position',
			array(
				'label'   => esc_html__( 'Horizontal Position by', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => array(
					'left'  => esc_html__( 'Left', 'rx-theme-assistant' ),
					'right' => esc_html__( 'Right', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_responsive_control(
			'next_left_position',
			array(
				'label'      => esc_html__( 'Left Indent', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'next_hor_position' => 'left',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.next-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'next_right_position',
			array(
				'label'      => esc_html__( 'Right Indent', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'next_hor_position' => 'right',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.next-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Dots section
		 */
		$this->start_controls_section(
			'section_dots_style',
			array(
				'label'      => esc_html__( 'Dots', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_dots_style' );

		$this->start_controls_tab(
			'tab_dots_normal',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_group_control(
			\Rx_Theme_Assistant_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style',
				'label'          => esc_html__( 'Dots Style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['dots'] .' li span',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_3,
						),
					),
				),
				'exclude' => array(
					'box_font_color',
					'box_font_size',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_hover',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_group_control(
			\Rx_Theme_Assistant_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style_hover',
				'label'          => esc_html__( 'Dots Style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['dots'] . ' li span:hover',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
				),
				'exclude' => array(
					'box_font_color',
					'box_font_size',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_active',
			array(
				'label' => esc_html__( 'Active', 'rx-theme-assistant' ),
			)
		);

		$this->add_group_control(
			\Rx_Theme_Assistant_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style_active',
				'label'          => esc_html__( 'Dots Style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['dots'] .' li.slick-active span',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						),
					),
				),
				'exclude' => array(
					'box_font_color',
					'box_font_size',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'dots_gap',
			array(
				'label' => esc_html__( 'Gap', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 5,
					'unit' => 'px',
				),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['dots'] . ' li' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'dots_margin',
			array(
				'label'      => esc_html__( 'Dots Box Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['dots'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'dots_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['dots'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Icon Style Section
		 */
		$this->start_controls_section(
			'section_icon_style',
			array(
				'label'      => esc_html__( 'Icon', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label' => esc_html__( 'Icon Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'icon_bg_color',
			array(
				'label' => esc_html__( 'Icon Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' ' . $css_scheme['icon_inner'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'icon_font_size',
			array(
				'label'      => esc_html__( 'Icon Font Size', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', 'rem',
				),
				'range'      => array(
					'px' => array(
						'min' => 18,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Icon Box Size', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 18,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' ' . $css_scheme['icon_inner'] => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'icon_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['icon'] . ' ' . $css_scheme['icon_inner'],
			)
		);

		$this->add_control(
			'icon_box_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' ' . $css_scheme['icon_inner'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_box_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' ' . $css_scheme['icon_inner'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'icon_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['icon'] . ' ' . $css_scheme['icon_inner'],
			)
		);

		$this->add_responsive_control(
			'icon_box_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Title Style Section
		 */
		$this->start_controls_section(
			'section_title_style',
			array(
				'label'      => esc_html__( 'Title', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'title_custom_width',
			array(
				'label'        => esc_html__( 'Custom width', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_responsive_control(
			'title_width',
			array(
				'label'      => esc_html__( 'Width', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 1000,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array(
					'size' => 350,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'title_custom_width' => 'yes',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'  => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
			)
		);

		$this->add_responsive_control(
			'title_padding',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Comment Style Section
		 */
		$this->start_controls_section(
			'section_comment_style',
			array(
				'label'      => esc_html__( 'Comment', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'comment_color',
			array(
				'label'  => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['comment'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'comment_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['comment'],
			)
		);

		$this->add_responsive_control(
			'comment_width',
			array(
				'label'      => esc_html__( 'Width', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 1000,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array(
					'size' => 350,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['comment'] => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'use_comment_corner',
			array(
				'label'        => esc_html__( 'Use comment corner', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'comment_corner_color',
			array(
				'label'   => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['comment'] . ':after' => 'border-color: {{VALUE}} transparent transparent transparent;',
				),
				'condition' => array(
					'use_comment_corner' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'comment_corner_position',
			array(
				'label'      => esc_html__( 'Corner Position', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['comment'] . ':after' => 'left: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'use_comment_corner' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'comment_corner_width',
			array(
				'label'      => esc_html__( 'Corner Width', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default' => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['comment'] . ':after' => 'border-right-width: {{SIZE}}{{UNIT}}; margin-left: calc({{SIZE}}{{UNIT}}/-2);',
				),
				'condition' => array(
					'use_comment_corner' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'comment_corner_height',
			array(
				'label'      => esc_html__( 'Corner Height', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default' => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['comment'] . ':after' => 'border-top-width: {{SIZE}}{{UNIT}}; bottom: -{{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'use_comment_corner' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'comment_corner_skew',
			array(
				'label'      => esc_html__( 'Corner Skew', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default' => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['comment'] . ':after' => 'border-left-width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'use_comment_corner' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'comment_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['comment'],
				/*'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
				),*/
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'comment_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['comment'],
			)
		);

		$this->add_control(
			'comment_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default' => array(
					'top'    => 5,
					'right'  => 5,
					'bottom' => 5,
					'left'   => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['comment'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'comment_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['comment'],
			)
		);

		$this->add_responsive_control(
			'comment_padding',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default' => array(
					'top'    => 25,
					'right'  => 15,
					'bottom' => 25,
					'left'   => 15,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['comment'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'comment_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['comment'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'comment_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['comment'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'comment_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['comment'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Name Style Section
		 */
		$this->start_controls_section(
			'section_name_style',
			array(
				'label'      => esc_html__( 'Name', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'name_custom_width',
			array(
				'label'        => esc_html__( 'Custom width', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_responsive_control(
			'name_width',
			array(
				'label'      => esc_html__( 'Width', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 1000,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array(
					'size' => 350,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['name'] => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'name_custom_width' => 'yes',
				),
			)
		);

		$this->add_control(
			'name_color',
			array(
				'label'  => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['name'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'name_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['name'],
			)
		);

		$this->add_responsive_control(
			'name_padding',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['name'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'name_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['name'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'name_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['name'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'name_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['name'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Position Style Section
		 */
		$this->start_controls_section(
			'section_position_style',
			array(
				'label'      => esc_html_x( 'Position', 'Position at work', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'position_custom_width',
			array(
				'label'        => esc_html__( 'Custom width', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_responsive_control(
			'position_width',
			array(
				'label'      => esc_html__( 'Width', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 1000,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array(
					'size' => 350,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['position'] => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'position_custom_width' => 'yes',
				),
			)
		);

		$this->add_control(
			'position_color',
			array(
				'label'  => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['position'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'position_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['position'],
			)
		);

		$this->add_responsive_control(
			'position_padding',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['position'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'position_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['position'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'position_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['position'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'position_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['position'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Date Style Section
		 */
		$this->start_controls_section(
			'section_date_style',
			array(
				'label'      => esc_html__( 'Date', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'date_custom_width',
			array(
				'label'        => esc_html__( 'Custom width', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_responsive_control(
			'date_width',
			array(
				'label'      => esc_html__( 'Width', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 1000,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array(
					'size' => 350,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['date'] => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'date_custom_width' => 'yes',
				),
			)
		);

		$this->add_control(
			'date_color',
			array(
				'label'  => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['date'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'date_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['date'],
			)
		);

		$this->add_responsive_control(
			'date_padding',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['date'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'date_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['date'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'date_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['date'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'date_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['date'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Rating Style Section
		 */
		$this->start_controls_section(
			'section_rating_style',
			array(
				'label'      => esc_html__( 'Rating', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'star_color',
			array(
				'label'  => esc_html__( 'Stars', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] . ' i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'rating_star_style',
			array(
				'label' => esc_html__( 'Stars Style', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => array(
					'solid' => array(
						'title' => esc_html__( 'Solid', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-star',
					),
					'outline' => array(
						'title' => esc_html__( 'Outline', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-star-o',
					),
				),
				'default' => 'solid',
			)
		);

		$this->add_control(
			'rating_active_star_color',
			array(
				'label'  => esc_html__( 'Active Stars', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'rating_active_star_style',
			array(
				'label' => esc_html__( 'Active Stars Style', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => array(
					'solid' => array(
						'title' => esc_html__( 'Solid', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-star',
					),
					'outline' => array(
						'title' => esc_html__( 'Outline', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-star-o',
					),
				),
				'default' => 'solid',
			)
		);

		$this->add_responsive_control(
			'rating_icon_size',
			array(
				'label' => esc_html__( 'Size', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => array(
					'unit' => 'px',
					'size' => '20',
				),
				'render_type' => 'template',
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'rating_icon_space',
			array(
				'label' => esc_html__( 'Spacing', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => array(
					'unit' => 'px',
					'size' => '7',
				),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'selectors' => array(
					'body:not(.rtl) {{WRAPPER}} i:not(:last-of-type)' => 'margin-right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} i:not(:last-of-type)' => 'margin-left: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'rating_star_margin',
			array(
				'label'       => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px' ),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Order Style Section
		 */
		$this->start_controls_section(
			'section_order_style',
			array(
				'label'      => esc_html__( 'Content Order and Alignment', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'image_order',
			array(
				'label'   => esc_html__( 'Image Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'max'     => 8,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['image'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_order',
			array(
				'label'   => esc_html__( 'Icon Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 8,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['icon'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_order',
			array(
				'label'   => esc_html__( 'Title Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 8,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['title'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'comment_order',
			array(
				'label'   => esc_html__( 'Description Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 1,
				'max'     => 8,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['comment'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'name_order',
			array(
				'label'   => esc_html__( 'Name Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5,
				'min'     => 1,
				'max'     => 8,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['name'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'position_order',
			array(
				'label'   => esc_html__( 'Position Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'max'     => 8,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['position'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'date_order',
			array(
				'label'   => esc_html__( 'Date Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 7,
				'min'     => 1,
				'max'     => 8,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['date'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'rating_order',
			array(
				'label'   => esc_html__( 'Rating Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'max'     => 8,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['rating'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'content_alignment',
			array(
				'label'   => esc_html__( 'Cover Content Vertical Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => array(
					'flex-start'    => esc_html__( 'Top', 'rx-theme-assistant' ),
					'center'        => esc_html__( 'Center', 'rx-theme-assistant' ),
					'flex-end'      => esc_html__( 'Bottom', 'rx-theme-assistant' ),
					'space-between' => esc_html__( 'Space between', 'rx-theme-assistant' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['content'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();
		include $this->__get_global_template( 'index' );
		$this->__close_wrap();
	}

	protected function render_stars() {

		$settings = $this->get_settings();
		$stars_html = '';

		for ( $stars = 1; $stars <= 5; $stars++ ) {
			$star_style = ( "outline" === $settings['rating_star_style'] ) ? 'f006' : 'f005' ;
			$active_star_style = ( "outline" === $settings['rating_active_star_style'] ) ? 'f006' : 'f005' ;
			$stars_html .= '<i class="fa" aria-hidden="true" data-star-style="&#x' . $star_style .'" data-active-star-style="&#x' . $active_star_style .'"></i>';
		}
		return $stars_html;
	}

	/**
	 * Generate setting json
	 *
	 * @return string
	 */
	public function generate_setting_json() {
		$settings = $this->get_settings();

		$instance_settings = array(
			'slidesToShow'   => array(
				'desktop' => absint( $settings['slides_to_show'] ),
				'tablet'  => absint( $settings['slides_to_show_tablet'] ),
				'mobile'  => absint( $settings['slides_to_show_mobile'] ),
			),
			'autoplaySpeed'  => absint( $settings['autoplay_speed'] ),
			'autoplay'       => filter_var( $settings['autoplay'], FILTER_VALIDATE_BOOLEAN ),
			'infinite'       => filter_var( $settings['infinite'], FILTER_VALIDATE_BOOLEAN ),
			'adaptiveHeight' => filter_var( $settings['adaptive_height'], FILTER_VALIDATE_BOOLEAN ),
			'pauseOnHover'   => filter_var( $settings['pause_on_hover'], FILTER_VALIDATE_BOOLEAN ),
			'speed'          => absint( $settings['speed'] ),
			'arrows'         => filter_var( $settings['arrows'], FILTER_VALIDATE_BOOLEAN ),
			'dots'           => filter_var( $settings['dots'], FILTER_VALIDATE_BOOLEAN ),
			'slidesToScroll' => absint( $settings['slides_to_scroll'] ),
			'prevArrow'      => rx_theme_assistant_tools()->get_carousel_arrow(
				array( $settings['prev_arrow'], 'prev-arrow' )
			),
			'nextArrow'      => rx_theme_assistant_tools()->get_carousel_arrow(
				array( $settings['next_arrow'], 'next-arrow' )
			),
			'rtl' => is_rtl(),
		);

		if ( 'fade' === $settings['effect'] ) {
			$instance_settings['fade'] = true;
		}

		$instance_settings = json_encode( $instance_settings );

		return sprintf( 'data-settings=\'%1$s\'', $instance_settings );
	}

	public function __get_testimonials_image() {
		$image_item = $this->__processed_item['item_image'];

		if ( empty( $image_item['url'] ) ) {
			return;
		}

		return sprintf( '<figure class="rx-theme-assistant-testimonials__figure"><img class="rx-theme-assistant-testimonials__tag-img" src="%1$s" alt="%2$s"></figure>',
			$image_item['url'],
			esc_attr( Control_Media::get_image_alt( $image_item ) )
		);
	}
}
