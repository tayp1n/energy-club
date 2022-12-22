<?php
/**
 * Class: Rx_Theme_Assistant_Dynamic_Breadcrumbs
 * Name: Page & Post Breadcrumbs
 * Slug: rx-theme-assistant-dynamic-breadcrumbs
 */

namespace Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rx_Theme_Assistant_Dynamic_Breadcrumbs extends Rx_Theme_Assistant_Base {

	public $module_css_class = array();

	public function get_name() {
		return 'rx-theme-assistant-dynamic-breadcrumbs';
	}

	public function get_title() {
		return esc_html__( 'Page & Post Breadcrumbs', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-post-title';
	}

	public function get_categories() {
		return array( 'rx-dynamic-posts' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'settings',
			array(
				'label' => esc_html__( 'Settings', 'rx-theme-assistant' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_title',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Show Title', 'rx-theme-assistant' ),
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'show_items',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Show Items', 'rx-theme-assistant' ),
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'separator_items',
			array(
				'label'     => esc_html__( 'Separator Items', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '/',
				'condition' => array(
					'show_items' => 'true',
				),
			)
		);

		$this->add_control(
			'path_type',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Full Breadcrums', 'rx-theme-assistant' ),
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
				'condition' => array(
					'show_items' => 'true',
				),
			)
		);

		$this->add_control(
			'disable_on_page',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Disable On Page', 'rx-theme-assistant' ),
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'disable_page_slug',
			array(
				'type'      => Controls_Manager::SELECT2,
				'label'     => esc_html__( 'Select page', 'rx-theme-assistant' ),
				'default'   => '',
				'multiple'   => true,
				'options'   => rx_theme_assistant_tools()->get_post_by_type( 'page' ),
				'condition' => array(
					'disable_on_page' => 'true',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content',
			array(
				'label' => esc_html__( 'Content', 'rx-theme-assistant' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'show_browse',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Show Text Before Items', 'rx-theme-assistant' ),
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'browse_text',
			[
				'label'     => esc_html__( 'Text Before Items', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Browse:', 'rx-theme-assistant' ),
				'condition' => [
					'show_browse' => 'true',
				],
			]
		);

		$this->add_control(
			'description_type',
			[
				'label' => esc_html__( 'Description Type', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'static_content',
				'options' => [
					'none'           => esc_html__( 'None', 'rx-theme-assistant' ),
					'static_content' => esc_html__( 'Static Content', 'rx-theme-assistant' ),
					'post_excerpt'   => esc_html__( 'Excerpt Post / Page', 'rx-theme-assistant' ),
				],
			]
		);

		$this->add_control(
			'static_content',
			[
				'label' => __( 'Static Content', 'rx-theme-assistant' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => '',
				'placeholder' => __( 'Type your description here', 'rx-theme-assistant' ),
				'condition' => [
					'description_type' => 'static_content',
				],
			]
		);

		$this->add_control(
			'home_text',
			array(
				'label'     => esc_html__( 'Home Page Label', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Home', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'not_found_text',
			array(
				'label'     => esc_html__( '404 Page Label', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Oops! That page can&rsquo;t be found.', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'search_page_text',
			array(
				'label'     => esc_html__( 'Search Page Label', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Search results for', 'rx-theme-assistant' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'responsive',
			array(
				'label' => esc_html__( 'Responsive', 'rx-theme-assistant' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_tablet',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Show On Tablet', 'rx-theme-assistant' ),
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'show_mobile',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Show On Mobile', 'rx-theme-assistant' ),
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General Style', 'rx-theme-assistant' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'general_align',
			[
				'label' => esc_html__( 'Direction', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'column',
				'options' => [
					'column' => esc_html__( 'Column', 'rx-theme-assistant' ),
					'column-reverse' => esc_html__( 'Reverse Column', 'rx-theme-assistant' ),
					'row' => esc_html__( 'Row', 'rx-theme-assistant' ),
					'row-reverse' => esc_html__( 'Reverse Row', 'rx-theme-assistant' ),
				],
			]
		);

		$this->add_control(
			'content_in_box',
			[
				'label'        => esc_html__( 'Content In Box', 'plugin-domain' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
			]
		);

		$this->add_responsive_control(
			'content_min_height',
			[
				'label' => esc_html__( 'Content Min Height', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 5,
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
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'background_style',
			[
				'label' => esc_html__( 'Background Style', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'general_background',
				'label' => esc_html__( 'Background', 'rx-theme-assistant' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .rxta-dynamic-breadcrumbs',
			]
		);

		$this->add_control(
			'overlay_background_style',
			[
				'label' => esc_html__( 'Overlay Background Style', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_overlay',
				'selector' => '{{WRAPPER}} .rxta-dynamic-breadcrumbs > .rxta-dynamic-breadcrumbs_bg-overlay',
			]
		);

		$this->add_control(
			'background_overlay_opacity',
			[
				'label' => esc_html__( 'Opacity', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => .5,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs > .rxta-dynamic-breadcrumbs_bg-overlay' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'background_overlay_background' => [ 'classic', 'gradient' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .rxta-dynamic-breadcrumbs > .rxta-dynamic-breadcrumbs_bg-overlay',
			]
		);

		$this->add_control(
			'overlay_blend_mode',
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
					'luminosity' => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs > .rxta-dynamic-breadcrumbs_bg-overlay' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'breadcrumbs_shape_divider',
			[
				'label' => esc_html__( 'Shape Divider', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_shape_dividers' );

		$shapes_options = [
			'' => esc_html__( 'None', 'rx-theme-assistant' ),
		];

		foreach ( Shapes::get_shapes() as $shape_name => $shape_props ) {
			$shapes_options[ $shape_name ] = $shape_props['title'];
		}

		foreach ( [
			'top' => esc_html__( 'Top', 'rx-theme-assistant' ),
			'bottom' => esc_html__( 'Bottom', 'rx-theme-assistant' ),
		] as $side => $side_label ) {
			$base_control_key = "shape_divider_$side";

			$this->start_controls_tab(
				"tab_$base_control_key",
				[
					'label' => $side_label,
				]
			);

			$this->add_control(
				$base_control_key,
				[
					'label' => esc_html__( 'Type', 'rx-theme-assistant' ),
					'type' => Controls_Manager::SELECT,
					'options' => $shapes_options,
					'frontend_available' => true,
				]
			);

			$this->add_control(
				$base_control_key . '_color',
				[
					'label' => esc_html__( 'Color', 'rx-theme-assistant' ),
					'type' => Controls_Manager::COLOR,
					'condition' => [
						"shape_divider_$side!" => '',
					],
					'selectors' => [
						"{{WRAPPER}} .rxta-dynamic-breadcrumbs > .elementor-shape-$side .elementor-shape-fill" => 'fill: {{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				$base_control_key . '_width',
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
					'range' => [
						'%' => [
							'min' => 100,
							'max' => 300,
						],
					],
					'condition' => [
						"shape_divider_$side" => array_keys( Shapes::filter_shapes( 'height_only', Shapes::FILTER_EXCLUDE ) ),
					],
					'selectors' => [
						"{{WRAPPER}} .rxta-dynamic-breadcrumbs > .elementor-shape-$side svg" => 'width: calc({{SIZE}}{{UNIT}} + 1.3px)',
					],
				]
			);

			$this->add_responsive_control(
				$base_control_key . '_height',
				[
					'label' => esc_html__( 'Height', 'rx-theme-assistant' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 500,
						],
					],
					'condition' => [
						"shape_divider_$side!" => '',
					],
					'selectors' => [
						"{{WRAPPER}} .rxta-dynamic-breadcrumbs > .elementor-shape-$side svg" => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				$base_control_key . '_flip',
				[
					'label' => esc_html__( 'Flip', 'rx-theme-assistant' ),
					'type' => Controls_Manager::SWITCHER,
					'condition' => [
						"shape_divider_$side" => array_keys( Shapes::filter_shapes( 'has_flip' ) ),
					],
					'selectors' => [
						"{{WRAPPER}} .rxta-dynamic-breadcrumbs > .elementor-shape-$side svg" => 'transform: translateX(-50%) rotateY(180deg)',
					],
				]
			);

			$this->add_control(
				$base_control_key . '_negative',
				[
					'label' => esc_html__( 'Invert', 'rx-theme-assistant' ),
					'type' => Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'condition' => [
						"shape_divider_$side" => array_keys( Shapes::filter_shapes( 'has_negative' ) ),
					],
				]
			);

			$this->add_control(
				$base_control_key . '_above_content',
				[
					'label' => esc_html__( 'Bring to Front', 'rx-theme-assistant' ),
					'type' => Controls_Manager::SWITCHER,
					'selectors' => [
						"{{WRAPPER}} .rxta-dynamic-breadcrumbs > .elementor-shape-$side" => 'z-index: 2; pointer-events: none',
					],
					'condition' => [
						"shape_divider_$side!" => '',
					],
				]
			);

			$this->end_controls_tab();
		}

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'rx-theme-assistant' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'title_align',
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
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .page-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_typography_heading',
			[
				'label' => esc_html__( 'Title Typography', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
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
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .page-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .page-title',
			]
		);

		$this->add_control(
			'title_border_heading',
			[
				'label' => esc_html__( 'Title Border', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'title_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '0px',
				'selector'    => '{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .page-title',
			)
		);

		$this->add_control(
			'title_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .page-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
				),
			)
		);

		$this->add_control(
			'title_size_heading',
			[
				'label' => esc_html__( 'Title Size', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .page-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .page-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_description_style',
			[
				'label' => esc_html__( 'Description', 'rx-theme-assistant' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'description_align',
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
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rx-theme-assistant-db' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'description_typography_heading',
			[
				'label' => esc_html__( 'Description Typography', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rx-theme-assistant-db' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rx-theme-assistant-db',
			]
		);

		$this->add_control(
			'description_border_heading',
			[
				'label' => esc_html__( 'Description Border', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'description_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '0px',
				'selector'    => '{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rx-theme-assistant-db',
			)
		);

		$this->add_control(
			'description_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rx-theme-assistant-db' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
				),
			)
		);

		$this->add_control(
			'description_size_heading',
			[
				'label' => esc_html__( 'Description Size', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'description_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rx-theme-assistant-db' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'description_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rx-theme-assistant-db' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_breadcrumbs_style',
			[
				'label' => esc_html__( 'Breadcrumbs', 'rx-theme-assistant' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'breadcrumbs_align',
			[
				'label' => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rxta-dynamic-breadcrumbs_content' => 'align-self: {{VALUE}};',
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rxta-dynamic-breadcrumbs_content' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'breadcrumbs_item_space',
			[
				'label' => esc_html__( 'Breadcrumbs Item Space', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 5,
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
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rxta-dynamic-breadcrumbs_browse' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rxta-dynamic-breadcrumbs_wrap .rxta-dynamic-breadcrumbs_item' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'breadcrumbs_typography_heading',
			[
				'label' => esc_html__( 'Breadcrumbs Typography', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'breadcrumbs_color',
			[
				'label' => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rxta-dynamic-breadcrumbs_content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'breadcrumbs_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rxta-dynamic-breadcrumbs_content',
			]
		);

		$this->start_controls_tabs( 'text_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			]
		);
		$this->add_control(
			'breadcrumbs_link_color',
			[
				'label' => esc_html__( 'Link Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rxta-dynamic-breadcrumbs_content a' => 'color: {{VALUE}};',
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
			'breadcrumbs_link_hover_color',
			[
				'label' => esc_html__( 'Link Hover Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rxta-dynamic-breadcrumbs_content a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'breadcrumbs_border_heading',
			[
				'label' => esc_html__( 'Breadcrumbs Border', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'breadcrumbs_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '0px',
				'selector'    => '{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rxta-dynamic-breadcrumbs_content',
			)
		);

		$this->add_control(
			'breadcrumbs_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rxta-dynamic-breadcrumbs_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
				),
			)
		);

		$this->add_control(
			'breadcrumbs_size_heading',
			[
				'label' => esc_html__( 'Breadcrumbs Size', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'breadcrumbs_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rxta-dynamic-breadcrumbs_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'breadcrumbs_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rxta-dynamic-breadcrumbs-module .rxta-dynamic-breadcrumbs_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$blog_slug = get_post_field( 'post_name', get_option('page_for_posts') );

		if( ! empty( $settings['disable_page_slug'] ) && ( is_page( $settings['disable_page_slug'] ) || ( in_array($blog_slug, $settings['disable_page_slug']) && rx_theme_assistant_tools()->is_blog() ) ) ){
			return;
		}

		$css_scheme = apply_filters(
			'rx-theme-assistant/dynamic-breadcrumbs/css-scheme',
			array(
				'module'    => 'rxta-dynamic-breadcrumbs-module',
				'content'   => 'rxta-dynamic-breadcrumbs_content',
				'wrap'      => 'rxta-dynamic-breadcrumbs_wrap',
				'browse'    => 'rxta-dynamic-breadcrumbs_browse',
				'item'      => 'rxta-dynamic-breadcrumbs_item',
				'separator' => 'rxta-dynamic-breadcrumbs_item_sep',
				'link'      => 'rxta-dynamic-breadcrumbs_item_link',
				'target'    => 'rxta-dynamic-breadcrumbs_item_target',
			)
		);
		$date_labels = apply_filters(
			'rx-theme-assistant/dynamic-breadcrumbs/date-labels',
			array(
				'archive_minute_hour' => 'g:i a',
				'archive_minute'      => 'i',
				'archive_hour'        => 'g a',
				'archive_year'        => 'Y',
				'archive_month'       => 'F',
				'archive_day'         => 'j',
				'archive_week'        => 'W',
			)
		);
		$path_type = filter_var( $settings['path_type'], FILTER_VALIDATE_BOOLEAN ) ? 'full' : 'minified' ;

		$this->module_css_class[] = 'rxta-breadcrumbs-' . $settings['general_align'];

		if( 'true' === $settings['content_in_box'] ){
			$this->module_css_class[]= 'container';
		}

		add_filter( 'cx_breadcrumbs/wrapper_classes', array( $this, 'add_css_class' ) );
		if( !empty( $settings['home_text'] ) ){
			add_filter( 'cx_breadcrumbs/custom_home_title', array( $this, 'use_custom_home_title' ) );
		}

		$title = apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/html-page-title-format', '<h1 class="page-title">%s</h1>' );
		$description = '';
		$description_format = apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/html-page-description-format', '<div class="rx-theme-assistant-db %1$s">%2$s</div>' );

		switch ( $settings['description_type'] ) {
			case 'static_content':
				if ( $settings['static_content'] ) {
					$description = sprintf( $description_format, '', $settings['static_content'] );
				}
			break;
			case 'post_excerpt':
				$description = rx_theme_assistant_post_tools()->get_post_content( array(
					'html'         => $description_format,
					'content_type' => 'excerpt',
					'echo'         => false,
				) );

				if ( rx_theme_assistant_tools()->is_edit_mode() ) {
					$description = sprintf( $description_format, '', 'This widget displays the content of posts, pages, products. On a lot of content - Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.' );
				}
			break;
		}

		$cx_breadcrumbs_instants = new \CX_Breadcrumbs_Extendt( array(
			'separator'         => $settings['separator_items'],
			'show_mobile'       => filter_var( $settings['show_mobile'], FILTER_VALIDATE_BOOLEAN ),
			'show_tablet'       => filter_var( $settings['show_tablet'], FILTER_VALIDATE_BOOLEAN ),
			'show_title'        => filter_var( $settings['show_title'], FILTER_VALIDATE_BOOLEAN ),
			'show_items'        => filter_var( $settings['show_items'], FILTER_VALIDATE_BOOLEAN ),
			'show_browse'       => filter_var( $settings['show_browse'], FILTER_VALIDATE_BOOLEAN ),
			'path_type'         => $path_type,
			'show_on_front'     => true,
			'network'           => true,
			'strings'           => array(
				'browse'              => $settings['browse_text'],
				'home'                => $settings['home_text'],
				'error_404'           => $settings['not_found_text'],
				'search'              => $settings['search_page_text'] . ' &#8220;%s&#8221;',
				'archives'            => apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/format-archives', esc_html__( 'Archives', 'rx-theme-assistant' ) ),
				'paged'               => apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/format-paged', esc_html__( 'Page %s', 'rx-theme-assistant' ) ),
				'archive_minute'      => apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/format-archive-minute', esc_html__( 'Minute %s', 'rx-theme-assistant' ) ),
				'archive_week'        => apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/format-archive-week', esc_html__( 'Week %s', 'rx-theme-assistant' ) ),
				'archive_minute_hour' => apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/format-archive-minute-hour', '%s' ),
				'archive_hour'        => apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/format-archive-hour', '%s' ),
				'archive_day'         => apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/format-archive-day', '%s' ),
				'archive_month'       => apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/format-archive-month', '%s' ),
				'archive_year'        => apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/format-archive-year', '%s' ),
			),
			'date_labels'       => $date_labels,
			'css_namespace'     => $css_scheme,
			'wrapper_format'    => apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/html-wrapper-format', '%1$s%2$s' ),
			'page_title_format' => $title . $description,
			'item_format'       => apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/html-item-format', '<div class="%2$s">%1$s</div>' ),
			'home_format'       => apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/html-home-format', '<a href="%4$s" class="%2$s is-home" rel="home" title="%3$s">%1$s</a>' ),
			'link_format'       => apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/html-link-format', '<a href="%4$s" class="%2$s" rel="tag" title="%3$s">%1$s</a>' ),
			'target_format'     => apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/html-target-format', '<span class="%2$s">%1$s</span>' ),
			'action'            => '',
		) );

		$this->__context = 'render';
		$this->__open_wrap( 'rxta-dynamic-breadcrumbs' );

		echo apply_filters( 'rx-theme-assistant/widget-dynamic-breadcrumbs/format-bg-overlay', '<div class="rxta-dynamic-breadcrumbs_bg-overlay"></div>' );

		if ( $settings['shape_divider_top'] ) {
			$this->print_shape_divider( 'top' );
		}

		if ( $settings['shape_divider_bottom'] ) {
			$this->print_shape_divider( 'bottom' );
		}

		$cx_breadcrumbs_instants->get_trail();

		$this->__close_wrap();
	}

	public function use_custom_home_title( $use ){
		return false;
	}

	public function add_css_class( $class ){
		$class = array_merge( $class, $this->module_css_class ) ;
		return $class;
	}

	/**
	 * Print section shape divider.
	 *
	 * Used to generate the shape dividers HTML.
	 *
	 * @since 1.1.0
	 * @access private
	 *
	 * @param string $side Shape divider side, used to set the shape key.
	 */
	private function print_shape_divider( $side ) {
		$settings = $this->get_active_settings();
		$base_setting_key = "shape_divider_$side";
		$negative = ! empty( $settings[ $base_setting_key . '_negative' ] );

		?>
		<div class="elementor-shape elementor-shape-<?php echo esc_attr( $side ); ?>" data-negative="<?php echo var_export( $negative ); ?>">
			<?php include Shapes::get_shape_path( $settings[ $base_setting_key ], ! empty( $settings[ $base_setting_key . '_negative' ] ) ); ?>
		</div>
		<?php
	}
}
