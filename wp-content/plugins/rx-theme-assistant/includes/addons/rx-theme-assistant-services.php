<?php
/**
 * Class: Rx_Theme_Assistant_Services
 * Name: Services
 * Slug: rx-theme-assistant-services
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

class Rx_Theme_Assistant_Services extends Rx_Theme_Assistant_Base {

	public function get_name() {
		return 'rx-theme-assistant-services';
	}

	public function get_title() {
		return esc_html__( 'Service', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-tools';
	}

	public function get_categories() {
		return array( 'rx-theme-assistant' );
	}

	protected function register_controls() {
		$css_scheme = apply_filters(
			'rx-theme-assistant/services/css-scheme',
			array(
				'instance'         => '.rx-theme-assistant-services',
				'instance_inner'   => '.rx-theme-assistant-services__inner',
				'header'           => '.rx-theme-assistant-services__header',
				'cover'            => '.rx-theme-assistant-services__cover',
				'figure'           => '.rx-theme-assistant-services__figure',
				'content'          => '.rx-theme-assistant-services__content',
				'media'            => '.rx-theme-assistant-services__media',
				'title'            => '.rx-theme-assistant-services__title',
				'title_icon'       => '.rx-theme-assistant-services__title-icon',
				'title_text'       => '.rx-theme-assistant-services__title-text',
				'desc'             => '.rx-theme-assistant-services__desc',
				'button'           => '.rx-theme-assistant-services__button',
				'button_icon'      => '.rx-theme-assistant-services__button-icon',
			)
		);

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'services_media_type',
			array(
				'label'   => esc_html__( 'Media Type', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'icon'   => esc_html__( 'Icon', 'rx-theme-assistant' ),
					'image'   => esc_html__( 'Image', 'rx-theme-assistant' ),
				),
				'default' => 'icon',
			)
		);

		$this->add_advanced_icon_control(
			'services_icon',
			[
				'label'   => esc_html__( 'Icon', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::ICONS,
				'skin'    => 'inline',
				'label_block' => false,
				'file'    => '',
				'fa5_default' => [
					'value'   => 'fas fa-cogs',
					'library' => 'solid',
				],
				'condition'   => array(
					'services_media_type' => 'icon',
				),
			]
		);

		$this->add_control(
			'services_image',
			array(
				'label'   => esc_html__( 'Image', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'dynamic' => array( 'active' => true ),
				'condition'   => array(
					'services_media_type' => 'image',
				),
			)
		);

		$this->add_control(
			'services_title',
			array(
				'label'   => esc_html__( 'Title', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title', 'rx-theme-assistant' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'services_title_size',
			array(
				'label'   => esc_html__( 'Title HTML Tag', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1'   => esc_html__( 'H1', 'rx-theme-assistant' ),
					'h2'   => esc_html__( 'H2', 'rx-theme-assistant' ),
					'h3'   => esc_html__( 'H3', 'rx-theme-assistant' ),
					'h4'   => esc_html__( 'H4', 'rx-theme-assistant' ),
					'h5'   => esc_html__( 'H5', 'rx-theme-assistant' ),
					'h6'   => esc_html__( 'H6', 'rx-theme-assistant' ),
					'div'  => esc_html__( 'div', 'rx-theme-assistant' ),
					'span' => esc_html__( 'span', 'rx-theme-assistant' ),
					'p'    => esc_html__( 'p', 'rx-theme-assistant' ),
				),
				'default' => 'h3',
			)
		);

		$this->add_control(
			'services_description',
			array(
				'label'   => esc_html__( 'Description', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'rx-theme-assistant' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'More', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'button_url',
			array(
				'label'       => esc_html__( 'Button Link', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default' => array(
					'url' => '',
				),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->end_controls_section();

		/**
		 * General Style Section
		 */
		$this->start_controls_section(
			'section_services_general_style',
			array(
				'label'      => esc_html__( 'General', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'container_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance_inner'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'container_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['instance_inner'],
			)
		);

		$this->add_responsive_control(
			'container_border_radius',
			array(
				'label'      => __( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance_inner'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_padding',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance_inner'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'container_box_shadow',
				'exclude' => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance_inner'],
			)
		);

		$this->end_controls_section();

		/**
		 * Header Style Section
		 */
		$this->start_controls_section(
			'section_services_header_style',
			array(
				'label'      => esc_html__( 'Header', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'header_position',
			array(
				'label'   => esc_html__( 'Header Position', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'left'  => esc_html__( 'Left', 'rx-theme-assistant' ),
					'top'   => esc_html__( 'Top', 'rx-theme-assistant' ),
					'right' => esc_html__( 'Right', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_control(
			'custom_header_size',
			array(
				'label'        => esc_html__( 'Custom size', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_responsive_control(
			'header_width',
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
					'size' => 80,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['header'] => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'custom_header_size' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'header_height',
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
					'size' => 80,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['header'] => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'custom_header_size' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'header_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['header'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'header_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['header'],
			)
		);

		$this->add_responsive_control(
			'header_border_radius',
			array(
				'label'      => __( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['header'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['figure'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'header_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['header'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'header_box_shadow',
				'exclude' => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['header'],
			)
		);

		$this->end_controls_section();

		/**
		 * Media Style Section
		 */
		$this->start_controls_section(
			'section_services_icon_style',
			array(
				'label'      => esc_html__( 'Media', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'icon_cover_location',
			array(
				'label'        => esc_html__( 'Display in header', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label' => esc_html__( 'Icon Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['media'] . ' i' => 'color: {{VALUE}}',
				),
				'condition'   => array(
					'services_media_type' => 'icon',
				),
			)
		);

		$this->add_control(
			'icon_bg_color',
			array(
				'label' => esc_html__( 'Icon Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['media'] . ' .inner' => 'background-color: {{VALUE}}',
				),
				'condition'   => array(
					'services_media_type' => 'icon',
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
					'{{WRAPPER}} ' . $css_scheme['media'] . ' i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
				'condition'   => array(
					'services_media_type' => 'icon',
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
					'{{WRAPPER}} ' . $css_scheme['media'] . ' .inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'services_media_type' => 'icon',
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
				'selector'    => '{{WRAPPER}} ' . $css_scheme['media'],
			)
		);

		$this->add_control(
			'icon_box_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['media'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} ' . $css_scheme['media'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'icon_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['media'],
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
					'{{WRAPPER}} ' . $css_scheme['media'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Title Style Section
		 */
		$this->start_controls_section(
			'section_services_title_style',
			array(
				'label'      => esc_html__( 'Title', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'title_cover_location',
			array(
				'label'        => esc_html__( 'Display in header', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'use_title_icon',
			array(
				'label'        => esc_html__( 'Use title icon?', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_advanced_icon_control(
			'title_icon',
			[
				'label'   => esc_html__( 'Title Icon', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::ICONS,
				'skin'    => 'inline',
				'label_block' => false,
				'file'    => '',
				'fa5_default' => [],
				'condition'   => array(
					'use_title_icon' => 'yes',
				),
			]
		);

		$this->add_control(
			'title_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title_icon'] => 'color: {{VALUE}}',
				),
				'condition' => array(
					'use_title_icon' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'title_icon_size',
			array(
				'label'      => esc_html__( 'Icon Font Size', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'use_title_icon' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'title_icon_margin',
			array(
				'label'      => __( 'Icon Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title_icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'  => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title_text'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} ' . $css_scheme['title_text'],
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
		 * Description Style Section
		 */
		$this->start_controls_section(
			'section_services_desc_style',
			array(
				'label'      => esc_html__( 'Description', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'desc_cover_location',
			array(
				'label'        => esc_html__( 'Display in header', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'desc_color',
			array(
				'label'  => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'desc_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['desc'],
			)
		);

		$this->add_responsive_control(
			'desc_padding',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'desc_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'desc_alignment',
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
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'desc_text_alignment',
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
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Action Button Style Section
		 */
		$this->start_controls_section(
			'section_action_button_style',
			array(
				'label'      => esc_html__( 'Action Button', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'button_cover_location',
			array(
				'label'        => esc_html__( 'Display in header', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_responsive_control(
			'button_alignment',
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
					'{{WRAPPER}} ' . $css_scheme['button'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'add_button_icon',
			array(
				'label'        => esc_html__( 'Add Icon', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_advanced_icon_control(
			'button_icon',
			[
				'label'   => esc_html__( 'Icon', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::ICONS,
				'skin'    => 'inline',
				'label_block' => false,
				'file'    => '',
				'fa5_default' => [
					'value'   => 'fas fa-check',
					'library' => 'solid',
				],
				'condition' => array(
					'add_button_icon' => 'yes',
				),
			]
		);

		$this->add_control(
			'button_icon_position',
			array(
				'label'   => esc_html__( 'Icon Position', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'before'  => esc_html__( 'Before Text', 'rx-theme-assistant' ),
					'after' => esc_html__( 'After Text', 'rx-theme-assistant' ),
				),
				'default'     => 'after',
				'render_type' => 'template',
				'condition' => array(
					'add_button_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'button_icon_size',
			array(
				'label' => esc_html__( 'Icon Size', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 7,
						'max' => 90,
					),
				),
				'condition' => array(
					'add_button_icon' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button_icon'] . ':before' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'button_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'add_button_icon' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button_icon'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'button_icon_margin',
			array(
				'label'      => esc_html__( 'Icon Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button_icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'button_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button'],
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'primary_button_hover_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_hover_typography',
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_responsive_control(
			'button_hover_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_hover_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_hover_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Overlay Style Section
		 */
		$this->start_controls_section(
			'section_services_overlay_style',
			array(
				'label'      => esc_html__( 'Overlay', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'show_on_hover',
			array(
				'label'        => esc_html__( 'Show on hover', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'overlay_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['cover'] . ':before',
			)
		);

		$this->add_responsive_control(
			'overlay_paddings',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['cover'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'icon_order',
			array(
				'label'   => esc_html__( 'Icon Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'max'     => 4,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['media'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_order',
			array(
				'label'   => esc_html__( 'Title Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 4,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['title'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'desc_order',
			array(
				'label'   => esc_html__( 'Description Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 4,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['desc'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_order',
			array(
				'label'   => esc_html__( 'Button Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 1,
				'max'     => 4,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['button'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'cover_alignment',
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
					'{{WRAPPER}} '. $css_scheme['cover'] => 'justify-content: {{VALUE}};',
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

	/**
	 * [__generate_media description]
	 * @param  boolean $cover_location [description]
	 * @return [type]                  [description]
	 */
	public function __generate_media( $cover_location = false ) {
		$type  = $this->get_settings_for_display( 'services_media_type' );
		$icon  = $this->__get_icon( 'services_icon' );
		$image = $this->get_settings_for_display( 'services_image' );

		$is_cover = filter_var( $this->get_settings_for_display( 'icon_cover_location' ), FILTER_VALIDATE_BOOLEAN );

		if ( ( $cover_location && ! $is_cover ) || ( ! $cover_location && $is_cover ) ) {
			return;
		}

		$html = '';

		switch ( $type ) {
			case 'icon':

				if ( empty( $icon ) ) {
					return false;
				}

				$format = apply_filters( 'rx-theme-assistant/services/icon-format', '<div class="rx-theme-assistant-services__media"><div class="inner">%s</div></div>' );

				$html = sprintf( $format, $icon );
			break;

			case 'image':
				if ( empty( $image['id'] ) ) {
					return;
				}

				$image = wp_get_attachment_image_src( $image['id'], 'full' );
				$format = apply_filters( 'rx-theme-assistant/services/image-format', '<figure class="rx-theme-assistant-services__media"><img class="rx-theme-assistant-services__img-tag" src="%s" alt=""></figure>' );

				$html = sprintf( $format, $image['0'] );
			break;
		}

		return $html;
	}

	/**
	 * [__generate_title description]
	 * @param  boolean $cover_location [description]
	 * @return [type]                  [description]
	 */
	public function __generate_title( $cover_location = false ) {
		$title_icon = $this->__get_icon( 'title_icon' );
		$title = $this->get_settings_for_display( 'services_title' );

		$is_cover = filter_var( $this->get_settings_for_display( 'title_cover_location' ), FILTER_VALIDATE_BOOLEAN );

		$icon_html = '';
		$title_html = '';

		if ( ( $cover_location && ! $is_cover ) || ( ! $cover_location && $is_cover ) ) {
			return;
		}

		if ( empty( $title_icon ) && empty( $title ) ) {
			return;
		}

		if ( ! empty( $title_icon ) ) {
			$icon_html = sprintf( '<span class="rx-theme-assistant-services__title-icon">%s</span>', $title_icon );
		}

		if ( ! empty( $title ) ) {

			$title_html = sprintf( '<span class="rx-theme-assistant-services__title-text">%s</span>', $title );
		}

		$title_tag = $this->get_settings_for_display( 'services_title_size' );

		$format = apply_filters( 'rx-theme-assistant/services/name-format', '<%3$s class="rx-theme-assistant-services__title">%1$s%2$s</%3$s>' );

		return sprintf( $format, $icon_html, $title_html, $title_tag );

	}

	public function __generate_description( $cover_location = false ) {
		$desc = $this->get_settings_for_display( 'services_description' );
		$is_cover = filter_var( $this->get_settings_for_display( 'desc_cover_location' ), FILTER_VALIDATE_BOOLEAN );

		if ( ( $cover_location && ! $is_cover ) || ( ! $cover_location && $is_cover ) ) {
			return;
		}

		if ( empty( $desc ) ) {
			return false;
		}

		$format = apply_filters( 'rx-theme-assistant/services/description-format', '<p class="rx-theme-assistant-services__desc">%s</p>' );

		return sprintf( $format, $desc );
	}

	public function __generate_action_button( $cover_location = false ) {
		$button_url    = $this->get_settings_for_display( 'button_url' );
		$button_text   = $this->get_settings_for_display( 'button_text' );
		$button_icon   = $this->__get_icon( 'button_icon', '%s', 'rx-theme-assistant-services__button-icon' );
		$use_icon      = $this->get_settings_for_display( 'add_button_icon' );
		$icon_position = $this->get_settings_for_display( 'button_icon_position' );
		$icon_html     = '';

		$is_cover = filter_var( $this->get_settings_for_display( 'button_cover_location' ), FILTER_VALIDATE_BOOLEAN );

		if ( ( $cover_location && ! $is_cover ) || ( ! $cover_location && $is_cover ) ) {
			return;
		}

		if ( empty( $button_url ) ) {
			return false;
		}

		if ( is_array( $button_url ) && empty( $button_url['url'] ) ) {
			return false;
		}

		if ( filter_var( $use_icon, FILTER_VALIDATE_BOOLEAN ) ) {
			$icon_html = $button_icon ;
		}

		$this->add_render_attribute( 'url', 'class', array(
			'elementor-button',
			'elementor-size-md',
			'rx-theme-assistant-services__button',
			'rx-theme-assistant-services__button--icon-' . $icon_position,
		) );

		if ( is_array( $button_url ) ) {
			$this->add_render_attribute( 'url', 'href', $button_url['url'] );

			if ( $button_url['is_external'] ) {
				$this->add_render_attribute( 'url', 'target', '_blank' );
			}

			if ( ! empty( $button_url['nofollow'] ) ) {
				$this->add_render_attribute( 'url', 'rel', 'nofollow' );
			}

		} else {
			$this->add_render_attribute( 'url', 'href', $button_url );
		}

		$format = apply_filters( 'rx-theme-assistant/services/action-button-format', '<a %1$s><span class="rx-theme-assistant-services__button-text">%2$s</span>%3$s</a>' );

		return sprintf( $format, $this->get_render_attribute_string( 'url' ), $button_text, $icon_html );
	}

}
