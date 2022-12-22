<?php
/**
 * Class: Rx_Theme_Assistant_Accordion
 * Name: Advanced Accordion
 * Slug: rx-theme-assistant-accordion
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
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rx_Theme_Assistant_Accordion extends Rx_Theme_Assistant_Base {

	public function get_name() {
		return 'rx-theme-assistant-accordion';
	}

	public function get_title() {
		return esc_html__( 'Advanced Accordion', 'rx-theme-assistant' );
	}

	public function get_help_url() {
		return '#';
	}

	public function get_icon() {
		return 'eicon-accordion';
	}

	public function get_categories() {
		return array( 'rx-theme-assistant' );
	}

	protected function register_controls() {
		$css_scheme = apply_filters(
			'rx-theme-assistant/accordion/css-scheme',
			array(
				'instance'       => '> .elementor-widget-container > .rx-theme-assistant-accordion',
				'toggle'         => '> .elementor-widget-container > .rx-theme-assistant-accordion > .rx-theme-assistant-accordion__inner > .rx-theme-assistant-toggle',
				'control'        => '> .elementor-widget-container > .rx-theme-assistant-accordion > .rx-theme-assistant-accordion__inner > .rx-theme-assistant-toggle > .rx-theme-assistant-toggle__control',
				'active_control' => '> .elementor-widget-container > .rx-theme-assistant-accordion > .rx-theme-assistant-accordion__inner > .rx-theme-assistant-toggle.active-toggle > .rx-theme-assistant-toggle__control',
				'content'        => '> .elementor-widget-container > .rx-theme-assistant-accordion > .rx-theme-assistant-accordion__inner > .rx-theme-assistant-toggle > .rx-theme-assistant-toggle__content',
				'label'          => '.rx-theme-assistant-toggle__label-text',
				'icon'           => '.rx-theme-assistant-toggle__label-icon',
			)
		);

		$this->start_controls_section(
			'section_items_data',
			array(
				'label' => esc_html__( 'Items', 'rx-theme-assistant' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_active',
			array(
				'label'        => esc_html__( 'Active', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_advanced_icon_control(
			'item_icon',
			array(
				'label'       => esc_html__( 'Icon', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::ICONS,
				'file'        => '',
				'default'     => 'fa fa-plus',
				'skin'        => 'inline',
				'label_block' => false,
			),
			$repeater
		);

		$this->add_advanced_icon_control(
			'item_active_icon',
			array(
				'label'       => esc_html__( 'Active Icon', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::ICONS,
				'file'        => '',
				'default'     => 'fa fa-minus',
				'skin'        => 'inline',
				'label_block' => false,
			),
			$repeater
		);

		$repeater->add_control(
			'item_label',
			array(
				'label'   => esc_html__( 'Label', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'New Tab', 'rx-theme-assistant' ),
				'dynamic' => [
					'active' => true,
				],
			)
		);

		$templates = rx_theme_assistant_tools()->elementor()->templates_manager->get_source( 'local' )->get_items();

		$options = [
			'0' => '— ' . esc_html__( 'Select', 'rx-theme-assistant' ) . ' —',
		];

		$types = [];

		foreach ( $templates as $template ) {
			$options[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
			$types[ $template['template_id'] ] = $template['type'];
		}

		$repeater->add_control(
			'content_type',
			[
				'label'       => esc_html__( 'Content Type', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'template',
				'options'     => [
					'template' => esc_html__( 'Template', 'rx-theme-assistant' ),
					'editor'   => esc_html__( 'Editor', 'rx-theme-assistant' ),
				],
				'label_block' => 'true',
			]
		);

		$repeater->add_control(
			'item_template_id',
			array(
				'label'       => esc_html__( 'Choose Template', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => $options,
				'types'       => $types,
				'label_block' => 'true',
				'condition'   => [
					'content_type' => 'template',
				]
			)
		);

		$repeater->add_control(
			'item_editor_content',
			[
				'label'      => __( 'Content', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::WYSIWYG,
				'default'    => __( 'Tab Item Content', 'rx-theme-assistant' ),
				'dynamic' => [
					'active' => true,
				],
				'condition'   => [
					'content_type' => 'editor',
				]
			]
		);

		$this->add_control(
			'toggles',
			array(
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'item_label'  => esc_html__( 'Toggle #1', 'rx-theme-assistant' ),
					),
					array(
						'item_label'  => esc_html__( 'Toggle #2', 'rx-theme-assistant' ),
					),
					array(
						'item_label'  => esc_html__( 'Toggle #3', 'rx-theme-assistant' ),
					),
				),
				'title_field' => '{{{ item_label }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings_data',
			array(
				'label' => esc_html__( 'Settings', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'collapsible',
			array(
				'label'        => esc_html__( 'Collapsible', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'show_effect',
			array(
				'label'       => esc_html__( 'Show Effect', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'move-up',
				'options' => array(
					'none'             => esc_html__( 'None', 'rx-theme-assistant' ),
					'fade'             => esc_html__( 'Fade', 'rx-theme-assistant' ),
					'zoom-in'          => esc_html__( 'Zoom In', 'rx-theme-assistant' ),
					'zoom-out'         => esc_html__( 'Zoom Out', 'rx-theme-assistant' ),
					'move-up'          => esc_html__( 'Move Up', 'rx-theme-assistant' ),
					'fall-perspective' => esc_html__( 'Fall Perspective', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_control(
			'ajax_template',
			array(
				'label'        => esc_html__( 'Use Ajax Loading for Template', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'Off', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_accordion_container_style',
			array(
				'label'      => esc_html__( 'Accordion Container', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'instance_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'],
			));

		$this->add_responsive_control(
			'instance_padding',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'instance_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['instance'],
			));

		$this->add_control(
			'instance_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			));

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'instance_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'],
			));

		$this->end_controls_section();

		/**
		 * Toggle Style Section
		 */
		$this->start_controls_section(
			'section_toggle_style',
			array(
				'label'      => esc_html__( 'Toggle', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'toggle_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['toggle'],
			));

		$this->add_responsive_control(
			'toggle_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['toggle'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			));

		$this->add_responsive_control(
			'toggle_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['toggle'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			));

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'toggle_border',
				'label'          => esc_html__( 'Border', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['toggle'],
			));

		$this->add_control(
			'toggle_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['toggle'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			));

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'toggle_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['toggle'],
			));

		$this->end_controls_section();

		/**
		 * Toggle Control Style Section
		 */
		$this->start_controls_section(
			'section_toggle_control_style',
			array(
				'label'      => esc_html__( 'Toggle Control', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'toggle_icon_heading',
			array(
				'label' => esc_html__( 'Icon ', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::HEADING,
			));

		$this->add_control(
			'toggle_icon_position',
			array(
				'label'   => esc_html__( 'Position', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default' => 'left',
				'label_block' => false,
			));

		$this->add_responsive_control(
			'toggle_icon_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['control'] . ' ' . $css_scheme['icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			));

		$this->add_responsive_control(
			'toggle_label_aligment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'flex-start',
				'options' => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-arrow-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'space-between' => array(
						'title' => esc_html__( 'Justify', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-justify',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-arrow-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['control'] => 'justify-content: {{VALUE}};',
				),
				'separator' => 'before',
			));

		$this->start_controls_tabs( 'toggle_general_styles' );

		$this->start_controls_tab(
			'toggle_control_normal',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'toggle_label_color',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['control'] . ' ' . $css_scheme['label'] => 'color: {{VALUE}}',
				),
			));

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'toggle_label_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} '. $css_scheme['control'] . ' ' . $css_scheme['label'],
			));

		$this->add_group_control(
			\Rx_Theme_Assistant_Group_Control_Box_Style::get_type(),
			array(
				'label'    => esc_html__( 'Icon', 'rx-theme-assistant' ),
				'name'     => 'toggle_icon_box',
				'selector' => '{{WRAPPER}} ' . $css_scheme['control'] . ' ' . $css_scheme['icon'] . ' .icon-normal',
			));

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'toggle_control_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['control'],
			));

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'toggle_control_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['control'],
			));

		$this->end_controls_tab();

		$this->start_controls_tab(
			'toggle_control_hover',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'toggle_label_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['control'] . ':hover ' . $css_scheme['label'] => 'color: {{VALUE}}',
				),
			));

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'toggle_label_typography_hover',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} '. $css_scheme['control'] . ':hover  ' . $css_scheme['label'],
			));

		$this->add_group_control(
			\Rx_Theme_Assistant_Group_Control_Box_Style::get_type(),
			array(
				'label'    => esc_html__( 'Icon', 'rx-theme-assistant' ),
				'name'     => 'toggle_icon_box_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['control'] . ':hover ' . $css_scheme['icon'] . ' .icon-normal',
			));

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'toggle_control_background_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['control'] . ':hover',
			));

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'toggle_control_border_hover',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['control'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'toggle_control_active',
			array(
				'label' => esc_html__( 'Active', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'toggle_label_color_active',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['active_control'] . ' ' . $css_scheme['label'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'toggle_label_typography_active',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} '. $css_scheme['active_control'] . ' ' . $css_scheme['label'],
			)
		);

		$this->add_group_control(
			\Rx_Theme_Assistant_Group_Control_Box_Style::get_type(),
			array(
				'label'    => esc_html__( 'Icon', 'rx-theme-assistant' ),
				'name'     => 'toggle_icon_box_active',
				'selector' => '{{WRAPPER}} ' . $css_scheme['toggle'] . '.active-toggle ' . $css_scheme['icon'] . ' .icon-active',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'toggle_control_background_active',
				'selector' => '{{WRAPPER}} ' . $css_scheme['toggle'] . '.active-toggle > .rx-theme-assistant-toggle__control',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'toggle_control_border_active',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['toggle'] . '.active-toggle > .rx-theme-assistant-toggle__control',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'toggle_control_padding',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['control'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'toggle_control_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['control'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'toggle_control_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['control'],
			)
		);

		$this->end_controls_section();

		/**
		 * Toggle Content Style Section
		 */
		$this->start_controls_section(
			'section_tabs_content_style',
			array(
				'label'      => esc_html__( 'Toggle Content', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tabs_content_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['content'],
			)
		);

		$this->add_control(
			'tabs_content_text_color',
			array(
				'label' => esc_html__( 'Text color', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['content'] => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'tabs_content_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['content'],
			)
		);

		$this->add_responsive_control(
			'tabs_content_padding',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content'] . ' > .rx-theme-assistant-toggle__content-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tabs_content_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'tabs_content_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['content'],
			)
		);

		$this->add_responsive_control(
			'tabs_content_radius',
			array(
				'label'      => __( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'tabs_content_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['content'],
			)
		);

		$this->add_control(
			'tabs_content_loader_style_heading',
			array(
				'label'     => esc_html__( 'Loader Styles', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'ajax_template' => 'yes',
				],
			)
		);

		$this->add_control(
			'tabs_content_loader_color',
			array(
				'label' => esc_html__( 'Loader color', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['content'] . ' .rx-theme-assistant-loader' => 'border-color: {{VALUE}}; border-top-color: white;',
				),
				'condition' => [
					'ajax_template' => 'yes',
				],
			)
		);

		$this->end_controls_section();
	}

	/**
	 * [render description]
	 * @return [type] [description]
	 */
	protected function render() {

		$this->__context = 'render';

		$toggles = $this->get_settings_for_display( 'toggles' );

		$id_int = substr( $this->get_id_int(), 0, 3 );

		$show_effect = $this->get_settings( 'show_effect' );

		$ajax_template = filter_var( $this->get_settings( 'ajax_template' ), FILTER_VALIDATE_BOOLEAN );

		$settings = array(
			'collapsible'  => filter_var( $this->get_settings( 'collapsible' ), FILTER_VALIDATE_BOOLEAN ),
			'ajaxTemplate' => $ajax_template,
		);

		$this->add_render_attribute( 'instance', array(
			'class' => array(
				'rx-theme-assistant-accordion',
			),
			'data-settings' => json_encode( $settings ),
			'role' => 'tablist',
		) );

		$toggle_icon_position = $this->get_settings( 'toggle_icon_position' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'instance' ); ?>>
			<div class="rx-theme-assistant-accordion__inner">
				<?php
					foreach ( $toggles as $index => $item ) {

						$this->__processed_item = $item;

						$toggle_count = $index + 1;

						$toggle_setting_key         = $this->get_repeater_setting_key( 'rx_theme_assistant', 'toggles', $index );
						$toggle_control_setting_key = $this->get_repeater_setting_key( 'rx_theme_assistant_control', 'toggles', $index );
						$toggle_content_setting_key = $this->get_repeater_setting_key( 'rx_theme_assistant_content', 'toggles', $index );

						$is_item_active = filter_var( $item['item_active'], FILTER_VALIDATE_BOOLEAN );

						$this->add_render_attribute( $toggle_control_setting_key, array(
							'id'            => 'rx-theme-assistant-toggle-control-' . $id_int . $toggle_count,
							'class'         => array(
								'rx-theme-assistant-toggle__control',
								'elementor-menu-anchor',
							),
							'data-toggle'   => $toggle_count,
							'role'          => 'tab',
							'aria-controls' => 'rx-theme-assistant-toggle-content-' . $id_int . $toggle_count,
							'aria-expanded' => $is_item_active ? 'true' : 'false',
							'data-template-id' => '0' !== $item['item_template_id'] ? $item['item_template_id'] : 'false',
						) );

						$toggle_control_icon_html = '';
						if ( ! empty( $item['selected_item_icon'] ) && ! empty( $item['selected_item_active_icon'] ) ) {

							$item_icon = $this->__get_icon( 'item_icon', '%s' );
							$item_active_icon = $this->__get_icon( 'item_active_icon', '%s' );

							$toggle_control_icon_html .= sprintf( '<div class="rx-theme-assistant-toggle__label-icon rx-theme-assistant-toggle-icon-position-%3$s"><span class="rx-theme-assistant-toggle__icon icon-normal">%1$s</span><span class="rx-theme-assistant-toggle__icon icon-active">%2$s</span></div>',
								$item_icon,
								$item_active_icon,
								$toggle_icon_position
							);
						}

						$toggle_control_label_html = '';

						if ( ! empty( $item['item_label'] ) ) {
							$toggle_control_label_html = sprintf( '<div class="rx-theme-assistant-toggle__label-text">%1$s</div>', $item['item_label'] );
						}

						$this->add_render_attribute( $toggle_content_setting_key, array(
							'id'          => 'rx-theme-assistant-toggle-content-' . $id_int . $toggle_count,
							'class'       => array(
								'rx-theme-assistant-toggle__content'
							),
							'data-toggle' => $toggle_count,
							'role'        => 'tabpanel',
							'aria-hidden' => $is_item_active ? 'false' : 'true',
							'data-template-id' => '0' !== $item['item_template_id'] ? $item['item_template_id'] : 'false',
						) );

						$content_html = '';

						switch ( $item[ 'content_type' ] ) {
							case 'template':

								if ( '0' !== $item['item_template_id'] ) {

									// for multi-language plugins
									$template_id = apply_filters( 'rx-theme-assistant/widgets/template_id', $item['item_template_id'], $this );

									$template_content = rx_theme_assistant_tools()->elementor()->frontend->get_builder_content_for_display( $template_id );

									if ( ! empty( $template_content ) ) {

										if ( ! $ajax_template ) {
											$content_html .= $template_content;
										} else {
											$content_html .= '<div class="rx-theme-assistant-loader"></div>';
										}

										if ( rx_theme_assistant_tools()->is_edit_mode() ) {
											$link = add_query_arg(
												array(
													'elementor'       => '',
												),
												get_permalink( $item['item_template_id'] )
											);

											$content_html .= sprintf( '<a class="rx-theme-assistant-toggle__edit-cover elementor-clickable" href="%s" target="_blank"><span>%s</span></a>', $link, esc_html__( 'Edit Template', 'rx-theme-assistant' ) );
										}
									} else {
										$content_html = $this->no_template_content_message();
									}

								} else {
									$content_html = $this->no_templates_message();
								}
							break;

							case 'editor':
								$content_html = $this->parse_text_editor( $item['item_editor_content'] );
							break;
						}

						$this->add_render_attribute( $toggle_setting_key, array(
							'class'         => array(
								'rx-theme-assistant-accordion__item',
								'rx-theme-assistant-toggle',
								'rx-theme-assistant-toggle-' . $show_effect . '-effect',
								$is_item_active ? 'active-toggle' : '',
							),
						) );

						?><div <?php echo $this->get_render_attribute_string( $toggle_setting_key ); ?>>
							<div <?php echo $this->get_render_attribute_string( $toggle_control_setting_key ); ?>>
								<?php echo $toggle_control_icon_html;
									echo $toggle_control_label_html;?>
							</div>
							<div <?php echo $this->get_render_attribute_string( $toggle_content_setting_key ); ?>>
								<div class="rx-theme-assistant-toggle__content-inner"><?php echo $content_html; ?></div>
							</div>
						</div><?php
					}

				$this->__processed_item = false;
			?></div>
		</div><?php
	}

	/**
	 * [empty_templates_message description]
	 * @return [type] [description]
	 */
	public function empty_templates_message() {
		return '<div id="elementor-widget-template-empty-templates">
				<div class="elementor-widget-template-empty-templates-icon"><i class="eicon-nerd"></i></div>
				<div class="elementor-widget-template-empty-templates-title">' . esc_html__( 'You Haven’t Saved Templates Yet.', 'rx-theme-assistant' ) . '</div>
				<div class="elementor-widget-template-empty-templates-footer">' . esc_html__( 'What is Library?', 'rx-theme-assistant' ) . ' <a class="elementor-widget-template-empty-templates-footer-url" href="https://go.elementor.com/docs-library/" target="_blank">' . esc_html__( 'Read our tutorial on using Library templates.', 'rx-theme-assistant' ) . '</a></div>
				</div>';
	}

	/**
	 * [no_templates_message description]
	 * @return [type] [description]
	 */
	public function no_templates_message() {
		$message = '<span>' . esc_html__( 'Template is not defined. ', 'rx-theme-assistant' ) . '</span>';

		$link = add_query_arg(
			array(
				'post_type'     => 'elementor_library',
				'action'        => 'elementor_new_post',
				'_wpnonce'      => wp_create_nonce( 'elementor_action_new_post' ),
				'template_type' => 'section',
			),
			esc_url( admin_url( '/edit.php' ) )
		);

		$new_link = '<span>' . esc_html__( 'Select an existing template or create a ', 'rx-theme-assistant' ) . '</span><a class="rx-theme-assistant-toggle-new-template-link elementor-clickable" target="_blank" href="' . $link . '">' . esc_html__( 'new one', 'rx-theme-assistant' ) . '</a>' ;

		return sprintf(
			'<div class="rx-theme-assistant-toggle-no-template-message">%1$s%2$s</div>',
			$message,
			rx_theme_assistant_tools()->in_elementor() ? $new_link : ''
		);
	}

	/**
	 * [no_template_content_message description]
	 * @return [type] [description]
	 */
	public function no_template_content_message() {
		$message = '<span>' . esc_html__( 'The toggles are working. Please, note, that you have to add a template to the library in order to be able to display it inside the toggles.', 'rx-theme-assistant' ) . '</span>';

		return sprintf( '<div class="rx-theme-assistant-toggle-no-template-message">%1$s</div>', $message );
	}

	/**
	 * [get_template_edit_link description]
	 * @param  [type] $template_id [description]
	 * @return [type]              [description]
	 */
	public function get_template_edit_link( $template_id ) {

		$link = add_query_arg( 'elementor', '', get_permalink( $template_id ) );

		return '<a target="_blank" class="elementor-edit-template elementor-clickable" href="' . $link .'"><i class="fa fa-pencil"></i> ' . esc_html__( 'Edit Template', 'rx-theme-assistant' ) . '</a>';
	}

}
