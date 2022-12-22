<?php
/**
 * Class: Rx_Theme_Assistant_Navigation
 * Name: Navigation
 * Slug: rx-theme-assistant-navigation
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

class Rx_Theme_Assistant_Navigation extends Rx_Theme_Assistant_Base {

	public $page_with_anchor = '';

	public function get_name() {
		return 'rx-theme-assistant-navigation';
	}

	public function get_title() {
		return esc_html__( 'Navigation', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-nav-menu';
	}

	public function get_script_depends() {
		return array( 'hoverIntent' );
	}

	public function get_categories() {
		return array( 'rx-theme-assistant' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_menu',
			array(
				'label' => esc_html__( 'Menu', 'rx-theme-assistant' ),
			)
		);

		$menus   = $this->get_available_menus();
		$admin_nav_page_url = admin_url( 'nav-menus.php?action=locations' );
		$default = '';

		if ( ! empty( $menus ) ) {
			$slugs     = array_keys( $menus );
			$default = $slugs[0];
		}

		$this->add_control(
			'nav_menu',
			array(
				'label'   => esc_html__( 'Select Menu', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => $default,
				'options' => $menus,
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => array(
					'horizontal' => esc_html__( 'Horizontal', 'rx-theme-assistant' ),
					'vertical'   => esc_html__( 'Vertical', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_control(
			'dropdown_position',
			array(
				'label'   => esc_html__( 'Dropdown Placement', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right-side',
				'options' => array(
					'left-side'  => esc_html__( 'Left Side', 'rx-theme-assistant' ),
					'right-side' => esc_html__( 'Right Side', 'rx-theme-assistant' ),
					'bottom'     => esc_html__( 'At the bottom', 'rx-theme-assistant' ),
				),
				'condition' => array(
					'layout' => 'vertical',
				)
			)
		);

		$this->add_advanced_icon_control(
			'dropdown_icon',
			array(
				'label'       => esc_html__( 'Dropdown Icon', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::ICONS,
				'file'        => '',
				'fa5_default' => [
					'value'   => 'fas fa-angle-down',
					'library' => 'solid',
				],
				'exclude_inline_options' => [ 'svg' ],
				'skin'        => 'inline',
				'label_block' => false,
			)
		);

		$this->add_responsive_control(
			'menu_alignment',
			array(
				'label'   => esc_html__( 'Menu Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'flex-start',
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
					'space-between' => array(
						'title' => esc_html__( 'Justified', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-justify',
					),
				),
				'selectors_dictionary' => array(
					'flex-start'    => 'justify-content: flex-start; text-align: left;',
					'center'        => 'justify-content: center; text-align: center;',
					'flex-end'      => 'justify-content: flex-end; text-align: right;',
					'space-between' => 'justify-content: space-between; text-align: left;',
				),
				'selectors' => array(
					'{{WRAPPER}} .rx-navigation--horizontal' => '{{VALUE}}',
					'{{WRAPPER}} .rx-navigation--vertical .menu-item-link-top' => '{{VALUE}}',
					'{{WRAPPER}} .rx-navigation--vertical-sub-bottom .menu-item-link-sub' => '{{VALUE}}',

					'(mobile){{WRAPPER}} .rx-mobile-menu .menu-item-link' => '{{VALUE}}',
				),
				'prefix_class' => 'rx-navigation%s-align-',
			)
		);

		$this->add_control(
			'mobile_trigger_visible',
			array(
				'label'     => esc_html__( 'Enable Mobile Trigger', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'use_on_mobile',
			array(
				'label'     => esc_html__( 'Use On Mobile Panes', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'description' => sprintf( esc_html__( 'If none of the menus have this option enabled, then the menu that is selected in the option %1$sAppearance -> Menus -> Manage Locations -> Main%2$s will be displayed in the mobile panede.', 'rx-theme-assistant' ), '<a href="' . $admin_nav_page_url . '" target="_blank">' , '</a>') ,
				'condition' => array(
					'mobile_trigger_visible' => 'yes',
				),
			)
		);

		$this->add_control(
			'mobile_trigger_alignment',
			array(
				'label'   => esc_html__( 'Mobile Trigger Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => array(
					'left' => array(
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
				'condition' => array(
					'mobile_trigger_visible' => 'yes',
				),
			)
		);

		$this->add_advanced_icon_control(
			'mobile_trigger_icon',
			array(
				'label'       => esc_html__( 'Mobile Trigger Icon', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::ICONS,
				'file'        => '',
				'fa5_default' => [
					'value'   => 'fas fa-bars',
					'library' => 'solid',
				],
				'exclude_inline_options' => [ 'svg' ],
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => array(
					'mobile_trigger_visible' => 'yes',
				),
			)
		);

		$this->add_advanced_icon_control(
			'mobile_trigger_close_icon',
			array(
				'label'       => esc_html__( 'Mobile Trigger Close Icon', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::ICONS,
				'file'        => '',
				'fa5_default' => [
					'value'   => 'fas fa-times',
					'library' => 'solid',
				],
				'exclude_inline_options' => [ 'svg' ],
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => array(
					'mobile_trigger_visible' => 'yes',
				),
			)
		);

		$this->add_control(
			'mobile_menu_layout',
			array(
				'label' => esc_html__( 'Mobile Menu Layout', 'rx-theme-assistant' ),
				'label_block' => true,
				'type'  => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default'    => esc_html__( 'Default', 'rx-theme-assistant' ),
					'full-width' => esc_html__( 'Full Width', 'rx-theme-assistant' ),
					'left-side'  => esc_html__( 'Slide From The Left Side ', 'rx-theme-assistant' ),
					'right-side' => esc_html__( 'Slide From The Right Side ', 'rx-theme-assistant' ),
				),
				'condition' => array(
					'mobile_trigger_visible' => 'yes',
				),
			)
		);

		$this->add_control(
			'anchor_menu',
			array(
				'label'       => esc_html__( 'Enable Anchor Menu', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'separator'   => 'before',
				'description' => esc_html__( 'Menu items should be created as "Custom Links" and the "URL" parameter should read #. For example: "#contact"', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'page_with_anchor',
			array(
				'label' => esc_html__( 'Page With Anchor', 'rx-theme-assistant' ),
				'label_block' => true,
				'type'  => Controls_Manager::SELECT,
				'default' => '0',
				'options' => rx_theme_assistant_tools()->get_post_by_type( 'page', 'slug', esc_html__( 'Select Page', 'rx-theme-assistant' ) ),
				'condition' => array(
					'anchor_menu' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'nav_items_style',
			array(
				'label'      => esc_html__( 'Top Level Items', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'nav_vertical_menu_width',
			array(
				'label' => esc_html__( 'Vertical Menu Width', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range' => array(
					'px' => array(
						'min' => 100,
						'max' => 1000,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .rx-navigation-wrap' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'layout' => 'vertical',
				),
			)
		);

		$this->add_responsive_control(
				'nav_vertical_menu_align',
				array(
					'label' => esc_html__( 'Vertical Menu Alignment', 'rx-theme-assistant' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => array(
						'left' => array(
							'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
							'icon'  => 'eicon-h-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
							'icon'  => 'eicon-h-align-center',
						),
						'right' => array(
							'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
							'icon'  => 'eicon-h-align-right',
						),
					),
					'selectors_dictionary' => array(
						'left'   => 'margin-left: 0; margin-right: auto;',
						'center' => 'margin-left: auto; margin-right: auto;',
						'right'  => 'margin-left: auto; margin-right: 0;',
					),
					'selectors' => array(
						'{{WRAPPER}} .rx-navigation-wrap' => '{{VALUE}}',
					),
					'condition' => array(
						'layout' => 'vertical',
					),
				)
			);

		$this->start_controls_tabs( 'tabs_nav_items_style' );

		$this->start_controls_tab(
			'nav_items_normal',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'nav_items_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-top' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_color',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-top' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_text_bg_color',
			array(
				'label'  => esc_html__( 'Text Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-top .rx-navigation-link-text' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_text_icon_color',
			array(
				'label'  => esc_html__( 'Dropdown Icon Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-top .rx-navigation-arrow' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'nav_items_typography',
				'selector' => '{{WRAPPER}} .menu-item-link-top .rx-navigation-link-text',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'nav_items_hover',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'nav_items_bg_color_hover',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item:hover > .menu-item-link-top,
					{{WRAPPER}} .menu-item.rx-navigation-hover > .menu-item-link-top' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item:hover > .menu-item-link-top' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_hover_border_color',
			array(
				'label' => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'nav_items_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .menu-item:hover > .menu-item-link-top' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'nav_items_text_bg_color_hover',
			array(
				'label'  => esc_html__( 'Text Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item:hover > .menu-item-link-top .rx-navigation-link-text' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_text_icon_color_hover',
			array(
				'label'  => esc_html__( 'Dropdown Icon Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item:hover > .menu-item-link-top .rx-navigation-arrow' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'nav_items_typography_hover',
				'selector' => '{{WRAPPER}} .menu-item:hover > .menu-item-link-top .rx-navigation-link-text',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'nav_items_active',
			array(
				'label' => esc_html__( 'Active', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'nav_items_bg_color_active',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_color_active',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_active_border_color',
			array(
				'label' => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'nav_items_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'nav_items_text_bg_color_active',
			array(
				'label'  => esc_html__( 'Text Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top .rx-navigation-link-text' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_text_icon_color_active',
			array(
				'label'  => esc_html__( 'Dropdown Icon Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top .rx-navigation-arrow' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'nav_items_typography_active',
				'selector' => '{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top .rx-navigation-link-text',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'nav_items_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .menu-item-link-top' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'nav_items_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-navigation > .rx-navigation__item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'nav_items_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} .menu-item-link-top',
			)
		);

		$this->add_responsive_control(
			'nav_items_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .menu-item-link-top' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'nav_items_icon_size',
			array(
				'label'      => esc_html__( 'Dropdown Icon Size', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-top .rx-navigation-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .menu-item-link-top .rx-navigation-arrow svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'nav_items_icon_gap',
			array(
				'label'      => esc_html__( 'Gap Before Dropdown Icon', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 20,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .menu-item-link-top .rx-navigation-arrow' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rx-navigation--vertical-sub-left-side .menu-item-link-top .rx-navigation-arrow' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',

					'(mobile){{WRAPPER}} .rx-mobile-menu .rx-navigation--vertical-sub-left-side .menu-item-link-top .rx-navigation-arrow' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				),
			)
		);

		$this->add_control(
			'nav_items_desc_heading',
			array(
				'label'     => esc_html__( 'Description', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'nav_items_desc_typography',
				'selector' => '{{WRAPPER}} .menu-item-link-top .rx-navigation-item-desc',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'sub_items_style',
			array(
				'label'      => esc_html__( 'Dropdown', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'sub_items_container_style_heading',
			array(
				'label' => esc_html__( 'Container Styles', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_responsive_control(
			'sub_items_container_width',
			array(
				'label'      => esc_html__( 'Container Width', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 100,
						'max' => 500,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .rx-navigation__sub' => 'width: {{SIZE}}{{UNIT}};',
				),
				'conditions' => array(
					'relation' => 'or',
					'terms' => array(
						array(
							'name'     => 'layout',
							'operator' => '===',
							'value'    => 'horizontal',
						),
						array(
							'relation' => 'and',
							'terms' => array(
								array(
									'name'     => 'layout',
									'operator' => '===',
									'value'    => 'vertical',
								),
								array(
									'name'     => 'dropdown_position',
									'operator' => '!==',
									'value'    => 'bottom',
								)
							),
						),
					),
				),
			)
		);

		$this->add_control(
			'sub_items_container_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-navigation__sub' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'sub_items_container_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} .rx-navigation__sub',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'sub_items_container_box_shadow',
				'selector' => '{{WRAPPER}} .rx-navigation__sub',
			)
		);

		$this->add_responsive_control(
			'sub_items_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-navigation__sub' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .rx-navigation__sub > .menu-item:first-child > .menu-item-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
					'{{WRAPPER}} .rx-navigation__sub > .menu-item:last-child > .menu-item-link' => 'border-radius: 0 0 {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'sub_items_container_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-navigation__sub' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'sub_items_container_top_gap',
			array(
				'label'      => esc_html__( 'Gap Before 1st Level Sub', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .rx-navigation--horizontal .rx-navigation-depth-0' => 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rx-navigation--vertical-sub-left-side .rx-navigation-depth-0' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rx-navigation--vertical-sub-right-side .rx-navigation-depth-0' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
				'conditions' => array(
					'relation' => 'or',
					'terms' => array(
						array(
							'name'     => 'layout',
							'operator' => '===',
							'value'    => 'horizontal',
						),
						array(
							'relation' => 'and',
							'terms' => array(
								array(
									'name'     => 'layout',
									'operator' => '===',
									'value'    => 'vertical',
								),
								array(
									'name'     => 'dropdown_position',
									'operator' => '!==',
									'value'    => 'bottom',
								)
							),
						),
					),
				),
			)
		);

		$this->add_responsive_control(
			'sub_items_container_left_gap',
			array(
				'label'      => esc_html__( 'Gap Before 2nd Level Sub', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .rx-navigation-depth-0 .rx-navigation__sub' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rx-navigation--vertical-sub-left-side .rx-navigation-depth-0 .rx-navigation__sub' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',
				),
				'conditions' => array(
					'relation' => 'or',
					'terms' => array(
						array(
							'name'     => 'layout',
							'operator' => '===',
							'value'    => 'horizontal',
						),
						array(
							'relation' => 'and',
							'terms' => array(
								array(
									'name'     => 'layout',
									'operator' => '===',
									'value'    => 'vertical',
								),
								array(
									'name'     => 'dropdown_position',
									'operator' => '!==',
									'value'    => 'bottom',
								)
							),
						),
					),
				),
			)
		);

		$this->add_control(
			'sub_items_style_heading',
			array(
				'label'     => esc_html__( 'Items Styles', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sub_items_typography',
				'selector' => '{{WRAPPER}} .menu-item-link-sub .rx-navigation-link-text',
			)
		);

		$this->start_controls_tabs( 'tabs_sub_items_style' );

		$this->start_controls_tab(
			'sub_items_normal',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'sub_items_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-sub' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'sub_items_color',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-sub' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'sub_items_hover',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'sub_items_bg_color_hover',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item:hover > .menu-item-link-sub' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'sub_items_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item:hover > .menu-item-link-sub' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'sub_items_active',
			array(
				'label' => esc_html__( 'Active', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'sub_items_bg_color_active',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item.current-menu-item > .menu-item-link-sub' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'sub_items_color_active',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item.current-menu-item > .menu-item-link-sub' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'sub_items_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .menu-item-link-sub' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'sub_items_icon_size',
			array(
				'label'      => esc_html__( 'Dropdown Icon Size', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-sub .rx-navigation-arrow'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .menu-item-link-sub .rx-navigation-arrow svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'sub_items_icon_gap',
			array(
				'label'      => esc_html__( 'Gap Before Dropdown Icon', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 20,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .menu-item-link-sub .rx-navigation-arrow' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rx-navigation--vertical-sub-left-side .menu-item-link-sub .rx-navigation-arrow' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',

					'(mobile){{WRAPPER}} .rx-mobile-menu .rx-navigation--vertical-sub-left-side .menu-item-link-sub .rx-navigation-arrow' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				),
			)
		);

		$this->add_control(
			'sub_items_divider_heading',
			array(
				'label'     => esc_html__( 'Divider', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'sub_items_divider',
				'selector' => '{{WRAPPER}} .rx-navigation__sub > .rx-navigation-item-sub:not(:last-child)',
				'exclude'  => array( 'width' ),
			)
		);

		$this->add_control(
			'sub_items_divider_width',
			array(
				'label' => esc_html__( 'Border Width', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'max' => 50,
					),
				),
				'default' => array(
					'size' => 1,
				),
				'selectors' => array(
					'{{WRAPPER}} .rx-navigation__sub > .rx-navigation-item-sub:not(:last-child)' => 'border-width: 0; border-bottom-width: {{SIZE}}{{UNIT}}',
				),
				'condition' => array(
					'sub_items_divider_border!' => '',
				),
			)
		);

		$this->add_control(
			'sub_items_desc_heading',
			array(
				'label'     => esc_html__( 'Description', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sub_items_desc_typography',
				'selector' => '{{WRAPPER}} .menu-item-link-sub .rx-navigation-item-desc',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'mobile_trigger_styles',
			array(
				'label'      => esc_html__( 'Mobile Trigger', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_mobile_trigger_style' );

		$this->start_controls_tab(
			'mobile_trigger_normal',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'mobile_trigger_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-navigation__mobile-trigger' => 'background-color: {{VALUE}}',
					'.rx-navigation--on-mobile-panel .rvdx-mobile-panel__control--mobile-menu' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'mobile_trigger_color',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-navigation__mobile-trigger' => 'color: {{VALUE}}',
					'.rx-navigation--on-mobile-panel .rvdx-mobile-panel__control--mobile-menu .rvdx-mobile-panel__control-inner i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'mobile_trigger_hover',
			array(
				'label' => esc_html__( 'Active', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'mobile_trigger_bg_color_hover',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-navigation__mobile-trigger:hover' => 'background-color: {{VALUE}}',
					'.rx-navigation--on-mobile-panel .rvdx-mobile-panel__control--mobile-menu.active' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'mobile_trigger_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-navigation__mobile-trigger:hover' => 'color: {{VALUE}}',
					'.rx-navigation--on-mobile-panel .rvdx-mobile-panel__control--mobile-menu.active .rvdx-mobile-panel__control-inner i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'mobile_trigger_hover_border_color',
			array(
				'label' => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'mobile_trigger_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .rx-navigation__mobile-trigger:hover' => 'border-color: {{VALUE}};',
					'.rx-navigation--on-mobile-panel .rvdx-mobile-panel__control--mobile-menu.active' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'mobile_trigger_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} .rx-navigation__mobile-trigger, .rx-navigation--on-mobile-panel .rvdx-mobile-panel__control--mobile-menu',
				'separator'   => 'before',
			)
		);

		$this->add_control(
			'mobile_trigger_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-navigation__mobile-trigger, .rx-navigation--on-mobile-panel .rvdx-mobile-panel__control--mobile-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'mobile_trigger_width',
			array(
				'label'      => esc_html__( 'Width', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 200,
					),
					'%' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .rx-navigation__mobile-trigger, .rx-navigation--on-mobile-panel .rvdx-mobile-panel__control--mobile-menu' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'mobile_trigger_height',
			array(
				'label'      => esc_html__( 'Height', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .rx-navigation__mobile-trigger, .rx-navigation--on-mobile-panel .rvdx-mobile-panel__control--mobile-menu' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'mobile_trigger_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .rx-navigation__mobile-trigger i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rx-navigation__mobile-trigger svg' => 'width: {{SIZE}}{{UNIT}};',
					'.rx-navigation--on-mobile-panel .rvdx-mobile-panel__control--mobile-menu i' => 'font-size: {{SIZE}}{{UNIT}};',
					'.rx-navigation--on-mobile-panel .rvdx-mobile-panel__control--mobile-menu svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'mobile_menu_styles',
			array(
				'label' => esc_html__( 'Mobile Menu', 'rx-theme-assistant' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'mobile_menu_width',
			array(
				'label' => esc_html__( 'Width', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range' => array(
					'px' => array(
						'min' => 150,
						'max' => 400,
					),
					'%' => array(
						'min' => 30,
						'max' => 100,
					),
				),
				'selectors' => array(
					'(mobile){{WRAPPER}} .rx-navigation' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'mobile_menu_layout' => array(
						'left-side',
						'right-side',
					),
				),
			)
		);

		$this->add_control(
			'mobile_menu_max_height',
			array(
				'label' => esc_html__( 'Max Height', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range' => array(
					'px' => array(
						'min' => 100,
						'max' => 500,
					),
					'vh' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors' => array(
					'(mobile){{WRAPPER}} .rx-navigation' => 'max-height: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'mobile_menu_layout' => 'full-width',
				),
			)
		);

		$this->start_controls_tabs( 'mobile_menu_items_style' );

		$this->start_controls_tab(
			'mobile_menu_items_normal',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'mobile_menu_items_color',
			array(
				'label'  => esc_html__( 'Top Links Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'(mobile){{WRAPPER}} .menu-item > .menu-item-link-top' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'mobile_menu_sub_items_color',
			array(
				'label'  => esc_html__( 'Dropdown Link Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'(mobile){{WRAPPER}} .menu-item-link-sub' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'mobile_menu_items_hover_2',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'mobile_menu_items_color_hover',
			array(
				'label'  => esc_html__( 'Top Links Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'(mobile){{WRAPPER}} .menu-item:hover  > .menu-item-link-top' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'mobile_menu_sub_items_color_hover',
			array(
				'label'  => esc_html__( 'Dropdown Link Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'(mobile){{WRAPPER}} .menu-item:hover > .menu-item-link-sub' => 'color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'mobile_menu_items_active',
			array(
				'label' => esc_html__( 'Active', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'mobile_menu_items_color_active',
			array(
				'label'  => esc_html__( 'Top Links Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'(mobile){{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'mobile_menu_sub_items_color_active',
			array(
				'label'  => esc_html__( 'Dropdown Link Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'(mobile){{WRAPPER}} .menu-item.current-menu-item > .menu-item-link-sub' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'mobile_menu_bg_color',
			array(
				'label' => esc_html__( 'Background color', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => array(
					'(mobile){{WRAPPER}} .rx-navigation-wrap__inner .rx-navigation' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'mobile_menu_dropdown_bg_color',
			array(
				'label'  => esc_html__( 'Dropdown Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'(mobile){{WRAPPER}} .rx-navigation-wrap__inner .rx-navigation__sub' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'mobile_menu_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'(mobile){{WRAPPER}} .rx-navigation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'mobile_menu_box_shadow',
				'selector' => '(mobile){{WRAPPER}} .rx-mobile-menu-active .rx-navigation',
			)
		);

		$this->add_control(
			'mobile_close_icon_heading',
			array(
				'label' => esc_html__( 'Close icon', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'mobile_menu_layout' => array(
						'full-width',
						'left-side',
						'right-side',
					),
				),
			)
		);

		$this->add_control(
			'mobile_close_icon_color',
			array(
				'label' => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-navigation__mobile-close-btn' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'mobile_menu_layout' => array(
						'full-width',
						'left-side',
						'right-side',
					),
				),
			)
		);

		$this->add_control(
			'mobile_close_icon_font_size',
			array(
				'label' => esc_html__( 'Font size', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range' => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .rx-navigation__mobile-close-btn'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rx-navigation__mobile-close-btn svg' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'mobile_menu_layout' => array(
						'full-width',
						'left-side',
						'right-side',
					),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Returns available icons for dropdown list
	 */
	public function dropdown_arrow_icons_list() {

		return apply_filters( 'rx-theme-assistant/navigation/dropdown-icons', array(
			'fa fa-angle-down'          => esc_html__( 'Angle', 'rx-theme-assistant' ),
			'fa fa-angle-double-down'   => esc_html__( 'Angle Double', 'rx-theme-assistant' ),
			'fa fa-chevron-down'        => esc_html__( 'Chevron', 'rx-theme-assistant' ),
			'fa fa-chevron-circle-down' => esc_html__( 'Chevron Circle', 'rx-theme-assistant' ),
			'fa fa-caret-down'          => esc_html__( 'Caret', 'rx-theme-assistant' ),
			'fa fa-plus'                => esc_html__( 'Plus', 'rx-theme-assistant' ),
			'fa fa-plus-square-o'       => esc_html__( 'Plus Square', 'rx-theme-assistant' ),
			'fa fa-plus-circle'         => esc_html__( 'Plus Circle', 'rx-theme-assistant' ),
			''                          => esc_html__( 'None', 'rx-theme-assistant' ),
		) );

	}

	/**
	 * Get available menus list
	 */
	public function get_available_menus() {
		$nav_menus = wp_get_nav_menus();
		$menus     = wp_list_pluck( $nav_menus, 'name', 'slug' );

		return $menus;
	}

	/**
	 * Change anchor link.
	 */
	public function change_anchor_link( $items ) {
		global $page_url_link;

		$page_url_id = get_page_by_path( $this->page_with_anchor );
		$page_url_link = get_permalink( $page_url_id );

		$items = preg_replace_callback(
			'/href="#\S+"/',
			function ( $matches ) {
				global $page_url_link;

				$result = str_replace( 'href="', 'href="' . $page_url_link , $matches );

				return $result[0];
			},
			$items
		);

		return $items;
	}

	/**
	 * Change anchor link.
	 */
	public function set_mobile_panel_settings( $settings ) {
		$settings['mobile-menu']['icon'] = $this->navigation_widget_settings['selected_mobile_trigger_icon']['value'];
		$settings['mobile-menu']['close-icon'] = $this->navigation_widget_settings['selected_mobile_trigger_close_icon']['value'];

		return $settings;
	}

	/**
	 * [render description]
	 * @return [type] [description]
	 */
	protected function render() {
		$settings = $this->get_settings();

		if ( ! $settings['nav_menu'] ) {
			return;
		}

		$trigger_visible     = filter_var( $settings['mobile_trigger_visible'], FILTER_VALIDATE_BOOLEAN );
		$trigger_align       = $settings['mobile_trigger_alignment'];
		$trigger_icon        = isset( $settings['selected_mobile_trigger_icon'] ) ? $settings['selected_mobile_trigger_icon']['value'] : 'fa fa-bars';
		$trigger_close_icon  = isset( $settings['selected_mobile_trigger_close_icon'] ) ? $settings['selected_mobile_trigger_close_icon']['value'] : 'fa fa-times';
		$mobile_active_class = 'rx-mobile-menu-active';

		$GLOBALS['rx_navigation_widget_data'] = [
			'mobile_trigger_icon'       => $trigger_icon,
			'mobile_trigger_close_icon' => $trigger_close_icon,
		];

		require_once rx_theme_assistant()->plugin_path( 'includes/nav-walker.php' );

		if ( isset( $settings['use_on_mobile'] ) && 'yes' === $settings['use_on_mobile'] ) {
			$mobile_active_class = '';
			$this->navigation_widget_settings = $settings;

			$this->add_render_attribute( 'nav-wrapper', 'class', 'rx-menu-on-mobile-panel' );

			add_filter( 'rvdx-theme/mobile-panel/mobile-panel-controls', array( $this, 'set_mobile_panel_settings' ) );
		}

		if ( $trigger_visible ) {
			$this->add_render_attribute( 'nav-wrapper', 'class', 'rx-mobile-menu' );

			if ( isset( $settings['mobile_menu_layout'] ) ) {
				$this->add_render_attribute( 'nav-wrapper', 'class', sprintf( 'rx-mobile-menu--%s', esc_attr( $settings['mobile_menu_layout'] ) ) );
				$this->add_render_attribute( 'nav-wrapper', 'data-mobile-layout', esc_attr( $settings['mobile_menu_layout'] ) );
			}
		}

		$this->add_render_attribute( 'nav-menu', 'class', 'rx-navigation' );
		$this->add_render_attribute( 'nav-wrapper', 'class', 'rx-navigation-wrap' );
		$this->add_render_attribute( 'nav-wrapper', 'data-menu-active-class', $mobile_active_class );

		if ( isset( $settings['layout'] ) ) {
			$this->add_render_attribute( 'nav-menu', 'class', 'rx-navigation--' . esc_attr( $settings['layout'] ) );

			if ( 'vertical' === $settings['layout'] && isset( $settings['dropdown_position'] ) ) {
				$this->add_render_attribute( 'nav-menu', 'class', 'rx-navigation--vertical-sub-' . esc_attr( $settings['dropdown_position'] ) );
			}
		}

		$menu_html = '<div ' . $this->get_render_attribute_string( 'nav-menu' ) . '>%3$s</div>';

		if ( $trigger_visible && in_array( $settings['mobile_menu_layout'], array( 'left-side', 'right-side', 'default' ) ) ) {

			$close_btn = $this->__get_icon( 'mobile_trigger_close_icon', '<div class="rx-navigation__mobile-close-btn">%s</div>' );

			$menu_html = '<div ' . $this->get_render_attribute_string( 'nav-menu' ) . '>%3$s' . $close_btn . '</div>';
		}

		if ( isset( $settings['anchor_menu'] ) && 'yes' === $settings['anchor_menu'] && '0' !== $settings['page_with_anchor'] ){
			$this->page_with_anchor = $settings['page_with_anchor'];
			add_filter( 'wp_nav_menu_items', array( $this, 'change_anchor_link' ) );
		}

		$args = array(
			'menu'            => $settings['nav_menu'],
			'fallback_cb'     => '',
			'items_wrap'      => $menu_html,
			'walker'          => new \Rx_Theme_Assistant_Nav_Walker,
			'widget_settings' => array(
				'dropdown_icon' => $this->__get_icon( 'dropdown_icon', '<span class="rx-navigation-arrow">%s</span>' ),
			),
			'container_class' => 'rx-navigation-wrap__inner'
		);

		echo '<div ' . $this->get_render_attribute_string( 'nav-wrapper' ) . '>';

			if ( $trigger_visible ) {
				include $this->__get_global_template( 'mobile-menu-trigger' );
			}
			wp_nav_menu( $args );
		echo '</div>';

		if ( isset( $settings['anchor_menu'] ) && 'yes' === $settings['anchor_menu'] && '0' !== $settings['page_with_anchor'] ){
			remove_filter( 'wp_nav_menu_items', array( $this, 'change_anchor_link' ) );
		}
	}
}
