<?php
/**
 * Class: Rx_Theme_Assistant_Dynamic_Title
 * Name: Page & Post Title
 * Slug: rx-theme-assistant-dynamic-title
 */

namespace Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rx_Theme_Assistant_Dynamic_Title extends Rx_Theme_Assistant_Base {

	public function get_name() {
		return 'rx-theme-assistant-dynamic-title';
	}

	public function get_title() {
		return esc_html__( 'Page & Post Title', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-heading';
	}

	public function get_categories() {
		return array( 'rx-dynamic-posts' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'title_tag',
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
			'size',
			[
				'label' => esc_html__( 'Size', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'rx-theme-assistant' ),
					'small' => esc_html__( 'Small', 'rx-theme-assistant' ),
					'medium' => esc_html__( 'Medium', 'rx-theme-assistant' ),
					'large' => esc_html__( 'Large', 'rx-theme-assistant' ),
					'xl' => esc_html__( 'XL', 'rx-theme-assistant' ),
					'xxl' => esc_html__( 'XXL', 'rx-theme-assistant' ),
				],
			]
		);

		$this->add_control(
			'title_link',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Title Link', 'rx-theme-assistant' ),
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => '',
			)
		);

		$this->add_control(
			'cut_title',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Cut Title', 'rx-theme-assistant' ),
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => '',
			)
		);

		$this->add_control(
			'title_length',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Title Length', 'rx-theme-assistant' ),
				'default'   => 10,
				'min'       => 1,
				'max'       => 500,
				'step'      => 1,
				'condition' => array(
					'cut_title'    => 'true',
				),
			)
		);

		$this->add_control(
			'title_ending',
			array(
				'label'   => esc_html__( 'Text Ending', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'condition' => array(
					'cut_title'    => 'true',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'rx-theme-assistant' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'text_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .elementor-widget-heading .elementor-heading-title a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-widget-heading .elementor-heading-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__( 'Text Hover Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .elementor-widget-heading .elementor-heading-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-heading-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-heading-title',
			]
		);

		$this->add_control(
			'blend_mode',
			[
				'label' => esc_html__( 'Blend Mode', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Normal', 'rx-theme-assistant' ),
					'multiply' => 'Multiply',
					'screen' => 'Screen',
					'overlay' => 'Overlay',
					'darken' => 'Darken',
					'lighten' => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'saturation' => 'Saturation',
					'color' => 'Color',
					'difference' => 'Difference',
					'exclusion' => 'Exclusion',
					'hue' => 'Hue',
					'luminosity' => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->add_control(
			'header_size',
			[
				'label' => __( 'Header size', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .entry-title' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'min_height',
			[
				'label' => esc_html__( 'Min Height', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .entry-title' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$title_link   = $settings['title_link'] ? '<a href="%2$s">%4$s</a>' : '%4$s' ;
		$title_length = ! $settings['cut_title'] ? -1 : $settings['title_length'] ;
		$html_format  = sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['title_tag'], '%1$s', $title_link );

		$this->__context = 'render';
		$this->__open_wrap( 'elementor-widget-heading rxta-dynamic-title' );

		rx_theme_assistant_post_tools()->get_post_title( array(
			'class'        => 'entry-title elementor-heading-title elementor-size-' . $settings['size'],
			'html'         => $html_format,
			'trimmed_type' => 'letters',
			'length'       => $title_length ,
			'ending'       => $settings['title_ending'],
			'echo'         => true,
		) );

		$this->__close_wrap();
	}
}
