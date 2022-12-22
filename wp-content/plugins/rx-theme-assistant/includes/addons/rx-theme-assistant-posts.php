<?php
/**
 * Class: Rx_Theme_Assistant_Posts
 * Name: Posts
 * Slug: rx-theme-assistant-posts
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

class Rx_Theme_Assistant_Posts extends Rx_Theme_Assistant_Base {

	public function get_name() {
		return 'rx-theme-assistant-posts';
	}

	public function get_title() {
		return esc_html__( 'Posts', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return array( 'rx-theme-assistant' );
	}

	public function __shortcode() {
		return rx_theme_assistant_shortcodes()->get_shortcode( $this->get_name() );
	}

	public function is_reload_preview_required() {
		return true;
	}

	public function get_script_depends() {
		return array( 'jquery-slick' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'General', 'rx-theme-assistant' ),
			)
		);

		$attributes = $this->__shortcode()->get_atts();

		foreach ( $attributes as $attr => $settings ) {

			if ( empty( $settings['type'] ) ) {
				continue;
			}

			if ( ! empty( $settings['responsive'] ) ) {
				$this->add_responsive_control( $attr, $settings );
			} else {
				$this->add_control( $attr, $settings );
			}

		}

		$this->end_controls_section();

		$css_scheme = apply_filters(
			'rx-theme-assistant/rx-theme-assistant-posts/css-scheme',
			array(
				'wrap'          => '.rx-theme-assistant-posts',
				'column'        => '.rx-theme-assistant-posts .rx-theme-assistant-posts__item',
				'inner-box'     => '.rx-theme-assistant-posts .rx-theme-assistant-posts__inner-box',
				'inner-content' => '.rx-theme-assistant-posts .rx-theme-assistant-posts__inner-content',
				'thumb'         => '.rx-theme-assistant-posts .post-thumbnail',
				'title'         => '.rx-theme-assistant-posts .entry-title',
				'meta'          => '.rx-theme-assistant-posts .post-meta',
				'meta-item'     => '.rx-theme-assistant-posts .post-meta__item',
				'excerpt'       => '.rx-theme-assistant-posts .entry-excerpt',
				'button'        => '.rx-theme-assistant-posts .rx-theme-assistant-more',
				'button_icon'   => '.rx-theme-assistant-posts .rx-theme-assistant-more-icon',
			)
		);

		$this->start_controls_section(
			'section_carousel',
			array(
				'label' => esc_html__( 'Carousel', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'carousel_enabled',
			array(
				'label'        => esc_html__( 'Enable Carousel', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_responsive_control(
			'slides_min_height',
			array(
				'label'       => esc_html__( 'Slides Minimal Height', 'rx-theme-assistant' ),
				'label_block' => true,
				'type'        => Controls_Manager::NUMBER,
				'default'     => '',
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['inner-box'] => 'min-height: {{VALUE}}px;',
				),

			)
		);

		$this->add_control(
			'slides_to_scroll',
			array(
				'label'     => esc_html__( 'Slides to Scroll', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => rx_theme_assistant_tools()->get_select_range( 4 ),
				'condition' => array(
					'columns!' => '1',
				),
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
				'default'      => 'true',
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
				'default'      => '',
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
					'columns' => '1',
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_posts_custom_fields',
			array(
				'label' => esc_html__( 'Custom Fields', 'rx-theme-assistant' ),
			)
		);

		$this->add_meta_controls( 'title_related', esc_html__( 'Before/After Title', 'rx-theme-assistant' ) );

		$this->add_meta_controls( 'content_related', esc_html__( 'Before/After Content', 'rx-theme-assistant' ) );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_column_style',
			array(
				'label'      => esc_html__( 'Column', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'column_padding',
			array(
				'label'       => esc_html__( 'Column Padding', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px' ),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['column'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['wrap'] => 'margin-right: -{{RIGHT}}{{UNIT}}; margin-left: -{{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			array(
				'label'      => esc_html__( 'Post Item', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'box_bg',
			array(
				'label' => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['inner-box'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'box_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['inner-box'],
			)
		);

		$this->add_responsive_control(
			'box_border_radius',
			array(
				'label'      => __( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['inner-box'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'inner_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['inner-box'],
			)
		);

		$this->add_responsive_control(
			'box_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['inner-box'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_thumb_style',
			array(
				'label'      => esc_html__( 'Post Thumbnail (Image)', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'thumb_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['thumb'],
			)
		);

		$this->add_responsive_control(
			'thumb_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'thumb_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['thumb'],
			)
		);

		$this->add_responsive_control(
			'thumb_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['thumb'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'thumb_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['thumb'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			array(
				'label'      => esc_html__( 'Post Item Content', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'content_bg',
			array(
				'label' => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['inner-content'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'content_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['inner-content'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			array(
				'label'      => esc_html__( 'Title', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'title_bg',
			array(
				'label' => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_title_color' );

		$this->start_controls_tab(
			'tab_title_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] . ' a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'title_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] . ' a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
			)
		);

		$this->add_responsive_control(
			'title_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'left',
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

		$this->add_responsive_control(
			'title_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_meta_style',
			array(
				'label'      => esc_html__( 'Meta', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'meta_bg',
			array(
				'label' => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['meta'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['meta'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'meta_link_color',
			array(
				'label' => esc_html__( 'Links Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['meta'] . ' a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'meta_link_color_hover',
			array(
				'label' => esc_html__( 'Links Hover Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['meta'] . ' a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'meta_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['meta'],
			)
		);

		$this->add_responsive_control(
			'meta_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['meta'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'meta_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['meta'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'meta_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'left',
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
					'{{WRAPPER}} ' . $css_scheme['meta'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'meta_divider',
			array(
				'label'     => esc_html__( 'Meta Divider', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['meta-item'] . ':not(:first-child):before' => 'content: "{{VALUE}}";',
				),
			)
		);

		$this->add_control(
			'meta_divider_gap',
			array(
				'label'      => esc_html__( 'Divider Gap', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['meta-item'] . ':not(:first-child):before' => 'margin-left: {{SIZE}}{{UNIT}};margin-right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_excerpt_style',
			array(
				'label'      => esc_html__( 'Excerpt', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'excerpt_bg',
			array(
				'label' => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'excerpt_color',
			array(
				'label' => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'excerpt_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['excerpt'],
			)
		);

		$this->add_responsive_control(
			'excerpt_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'left',
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
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'excerpt_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['excerpt'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'excerpt_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['excerpt'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			array(
				'label'      => esc_html__( 'Button', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'add_button_icon',
			array(
				'label'        => esc_html__( 'Customize Icon', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'button_icon_position',
			array(
				'label'   => esc_html__( 'Icon Position', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'left'  => esc_html__( 'Before Text', 'rx-theme-assistant' ),
					'right' => esc_html__( 'After Text', 'rx-theme-assistant' ),
				),
				'default'     => 'right',
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['button_icon'] => 'float: {{VALUE}}',
				),
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
			'button_bg',
			array(
				'label'       => _x( 'Background Type', 'Background Control', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'color' => array(
						'title' => _x( 'Classic', 'Background Control', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-paint-brush',
					),
					'gradient' => array(
						'title' => _x( 'Gradient', 'Background Control', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-barcode',
					),
				),
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			)
		);

		$this->add_control(
			'button_bg_color',
			array(
				'label'     => _x( 'Color', 'Background Control', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'title'     => _x( 'Background Color', 'Background Control', 'rx-theme-assistant' ),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_bg_color_stop',
			array(
				'label'      => _x( 'Location', 'Background Control', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'unit' => '%',
					'size' => 0,
				),
				'render_type' => 'ui',
				'condition' => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_color_b',
			array(
				'label'       => _x( 'Second Color', 'Background Control', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2295b',
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_color_b_stop',
			array(
				'label'      => _x( 'Location', 'Background Control', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_gradient_type',
			array(
				'label'   => _x( 'Type', 'Background Control', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'linear' => _x( 'Linear', 'Background Control', 'rx-theme-assistant' ),
					'radial' => _x( 'Radial', 'Background Control', 'rx-theme-assistant' ),
				),
				'default'     => 'linear',
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_gradient_angle',
			array(
				'label'      => _x( 'Angle', 'Background Control', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'deg' ),
				'default'    => array(
					'unit' => 'deg',
					'size' => 180,
				),
				'range' => array(
					'deg' => array(
						'step' => 10,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{button_bg_color.VALUE}} {{button_bg_color_stop.SIZE}}{{button_bg_color_stop.UNIT}}, {{button_bg_color_b.VALUE}} {{button_bg_color_b_stop.SIZE}}{{button_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_bg'               => array( 'gradient' ),
					'button_bg_gradient_type' => 'linear',
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_gradient_position',
			array(
				'label'   => _x( 'Position', 'Background Control', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'center center' => _x( 'Center Center', 'Background Control', 'rx-theme-assistant' ),
					'center left'   => _x( 'Center Left', 'Background Control', 'rx-theme-assistant' ),
					'center right'  => _x( 'Center Right', 'Background Control', 'rx-theme-assistant' ),
					'top center'    => _x( 'Top Center', 'Background Control', 'rx-theme-assistant' ),
					'top left'      => _x( 'Top Left', 'Background Control', 'rx-theme-assistant' ),
					'top right'     => _x( 'Top Right', 'Background Control', 'rx-theme-assistant' ),
					'bottom center' => _x( 'Bottom Center', 'Background Control', 'rx-theme-assistant' ),
					'bottom left'   => _x( 'Bottom Left', 'Background Control', 'rx-theme-assistant' ),
					'bottom right'  => _x( 'Bottom Right', 'Background Control', 'rx-theme-assistant' ),
				),
				'default' => 'center center',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{button_bg_color.VALUE}} {{button_bg_color_stop.SIZE}}{{button_bg_color_stop.UNIT}}, {{button_bg_color_b.VALUE}} {{button_bg_color_b_stop.SIZE}}{{button_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_bg'               => array( 'gradient' ),
					'button_bg_gradient_type' => 'radial',
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label' => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button'],
			)
		);

		$this->add_control(
			'button_text_decor',
			array(
				'label'   => esc_html__( 'Text Decoration', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'none'      => esc_html__( 'None', 'rx-theme-assistant' ),
					'underline' => esc_html__( 'Underline', 'rx-theme-assistant' ),
				),
				'default' => 'none',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'text-decoration: {{VALUE}}',
				),
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
			'button_hover_bg',
			array(
				'label'       => _x( 'Background Type', 'Background Control', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'color' => array(
						'title' => _x( 'Classic', 'Background Control', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-paint-brush',
					),
					'gradient' => array(
						'title' => _x( 'Gradient', 'Background Control', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-barcode',
					),
				),
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			)
		);

		$this->add_control(
			'button_hover_bg_color',
			array(
				'label'     => _x( 'Color', 'Background Control', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'title'     => _x( 'Background Color', 'Background Control', 'rx-theme-assistant' ),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_bg_color_stop',
			array(
				'label'      => _x( 'Location', 'Background Control', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'unit' => '%',
					'size' => 0,
				),
				'render_type' => 'ui',
				'condition' => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_color_b',
			array(
				'label'       => _x( 'Second Color', 'Background Control', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2295b',
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_color_b_stop',
			array(
				'label'      => _x( 'Location', 'Background Control', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_gradient_type',
			array(
				'label'   => _x( 'Type', 'Background Control', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'linear' => _x( 'Linear', 'Background Control', 'rx-theme-assistant' ),
					'radial' => _x( 'Radial', 'Background Control', 'rx-theme-assistant' ),
				),
				'default'     => 'linear',
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_gradient_angle',
			array(
				'label'      => _x( 'Angle', 'Background Control', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'deg' ),
				'default'    => array(
					'unit' => 'deg',
					'size' => 180,
				),
				'range' => array(
					'deg' => array(
						'step' => 10,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{button_hover_bg_color.VALUE}} {{button_hover_bg_color_stop.SIZE}}{{button_hover_bg_color_stop.UNIT}}, {{button_hover_bg_color_b.VALUE}} {{button_hover_bg_color_b_stop.SIZE}}{{button_hover_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_hover_bg'               => array( 'gradient' ),
					'button_hover_bg_gradient_type' => 'linear',
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_gradient_position',
			array(
				'label'   => _x( 'Position', 'Background Control', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'center center' => _x( 'Center Center', 'Background Control', 'rx-theme-assistant' ),
					'center left'   => _x( 'Center Left', 'Background Control', 'rx-theme-assistant' ),
					'center right'  => _x( 'Center Right', 'Background Control', 'rx-theme-assistant' ),
					'top center'    => _x( 'Top Center', 'Background Control', 'rx-theme-assistant' ),
					'top left'      => _x( 'Top Left', 'Background Control', 'rx-theme-assistant' ),
					'top right'     => _x( 'Top Right', 'Background Control', 'rx-theme-assistant' ),
					'bottom center' => _x( 'Bottom Center', 'Background Control', 'rx-theme-assistant' ),
					'bottom left'   => _x( 'Bottom Left', 'Background Control', 'rx-theme-assistant' ),
					'bottom right'  => _x( 'Bottom Right', 'Background Control', 'rx-theme-assistant' ),
				),
				'default' => 'center center',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{button_hover_bg_color.VALUE}} {{button_hover_bg_color_stop.SIZE}}{{button_hover_bg_color_stop.UNIT}}, {{button_hover_bg_color_b.VALUE}} {{button_hover_bg_color_b_stop.SIZE}}{{button_hover_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_hover_bg'               => array( 'gradient' ),
					'button_hover_bg_gradient_type' => 'radial',
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label' => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'button_hover_typography',
				'label' => esc_html__( 'Typography', 'rx-theme-assistant' ),
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_control(
			'button_hover_text_decor',
			array(
				'label'   => esc_html__( 'Text Decoration', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'none'      => esc_html__( 'None', 'rx-theme-assistant' ),
					'underline' => esc_html__( 'Underline', 'rx-theme-assistant' ),
				),
				'default' => 'none',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'text-decoration: {{VALUE}}',
				),
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

		$this->add_responsive_control(
			'button_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'flex-start',
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
					'none' => array(
						'title' => esc_html__( 'Fullwidth', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-justify',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'align-self: {{VALUE}};',
				),
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_arrows_style',
			array(
				'label'      => esc_html__( 'Carousel Arrows', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_arrows_style' );

		$this->start_controls_tab(
			'tab_prev',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_group_control(
			\Rx_Theme_Assistant_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'arrows_style',
				'label'          => esc_html__( 'Arrows Style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} .rx-theme-assistant-posts .rx-theme-assistant-arrow',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_next_hover',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_group_control(
			\Rx_Theme_Assistant_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'arrows_hover_style',
				'label'          => esc_html__( 'Arrows Style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} .rx-theme-assistant-posts .rx-theme-assistant-arrow:hover',
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
					'{{WRAPPER}} .rx-theme-assistant-posts .rx-theme-assistant-arrow.prev-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
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
					'{{WRAPPER}} .rx-theme-assistant-posts .rx-theme-assistant-arrow.prev-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
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
					'{{WRAPPER}} .rx-theme-assistant-posts .rx-theme-assistant-arrow.prev-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
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
					'{{WRAPPER}} .rx-theme-assistant-posts .rx-theme-assistant-arrow.prev-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
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
					'{{WRAPPER}} .rx-theme-assistant-posts .rx-theme-assistant-arrow.next-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
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
					'{{WRAPPER}} .rx-theme-assistant-posts .rx-theme-assistant-arrow.next-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
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
					'{{WRAPPER}} .rx-theme-assistant-posts .rx-theme-assistant-arrow.next-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
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
					'{{WRAPPER}} .rx-theme-assistant-posts .rx-theme-assistant-arrow.next-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dots_style',
			array(
				'label'      => esc_html__( 'Carousel Dots', 'rx-theme-assistant' ),
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
				'selector'       => '{{WRAPPER}} .rx-theme-assistant-carousel .rx-theme-assistant-slick-dots li span',
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
				'selector'       => '{{WRAPPER}} .rx-theme-assistant-carousel .rx-theme-assistant-slick-dots li span:hover',
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
				'selector'       => '{{WRAPPER}} .rx-theme-assistant-carousel .rx-theme-assistant-slick-dots li.slick-active span',
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
					'{{WRAPPER}} .rx-theme-assistant-carousel .rx-theme-assistant-slick-dots li' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'dots_margin',
			array(
				'label'      => esc_html__( 'Dots Box Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-theme-assistant-carousel .rx-theme-assistant-slick-dots' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .rx-theme-assistant-carousel .rx-theme-assistant-slick-dots' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_custom_fields_style',
			array(
				'label'      => esc_html__( 'Custom Fields', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_meta_style_controls(
			'title_related',
			esc_html__( 'Before/After Title', 'rx-theme-assistant' ),
			'rx-theme-assistant-title-fields'
		);

		$this->add_meta_style_controls(
			'content_related',
			esc_html__( 'Before/After Content', 'rx-theme-assistant' ),
			'rx-theme-assistant-content-fields'
		);

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();

		$attributes    = array();
		$tag           = $this->get_name();
		$settings      = $this->get_settings();
		$shortcode_obj = $this->__shortcode();

		$cutom_fields_atts = array(
			'show_title_related_meta',
			'show_content_related_meta',
			'meta_title_related_position',
			'meta_content_related_position',
			'title_related_meta',
			'content_related_meta',
		);

		foreach ( $shortcode_obj->get_atts() as $attr => $data ) {

			if ( in_array( $attr, $cutom_fields_atts ) ) {
				continue;
			}

			$attr_val            = isset( $settings[ $attr ] ) ? $settings[ $attr ] : '';
			$attr_val            = ! is_array( $attr_val ) ? $attr_val : implode( ',', $attr_val );
			$attributes[ $attr ] = $attr_val;
		}

		// Add custom fields attributes
		foreach ( $cutom_fields_atts as $attr ) {
			$attributes[ $attr ] = isset( $settings[ $attr ] ) ? $settings[ $attr ] : false;
		}

		echo $this->maybe_apply_carousel_wrappers( $shortcode_obj->do_shortcode( $attributes ), $settings );

		$this->__close_wrap();
	}

	/**
	 * Apply carousel wrappers for shortcode content if carousel is enabled.
	 *
	 * @param  string $content  Module content.
	 * @param  array  $settings Module settings.
	 * @return string
	 */
	public function maybe_apply_carousel_wrappers( $content = null, $settings = array() ) {

		if ( 'yes' !== $settings['carousel_enabled'] ) {
			return $content;
		}

		$is_rtl = is_rtl();

		$options = array(
			'slidesToShow'   => array(
				'desktop' => absint( $settings['columns'] ),
				'tablet'  => absint( $settings['columns_tablet'] ),
				'mobile'  => absint( $settings['columns_mobile'] ),
			),
			'autoplaySpeed'  => absint( $settings['autoplay_speed'] ),
			'autoplay'       => filter_var( $settings['autoplay'], FILTER_VALIDATE_BOOLEAN ),
			'infinite'       => filter_var( $settings['infinite'], FILTER_VALIDATE_BOOLEAN ),
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
			'rtl' => $is_rtl,
		);

		if ( 1 === absint( $settings['columns'] ) ) {
			$options['fade'] = ( 'fade' === $settings['effect'] );
		}

		$dir = $is_rtl ? 'rtl' : 'ltr';

		return sprintf(
			'<div class="rx-theme-assistant-carousel elementor-slick-slider" data-slider_options="%1$s" dir="%3$s">%2$s</div>',
			htmlspecialchars( json_encode( $options ) ), $content, $dir
		);
	}

	protected function _content_template() {}

	/**
	 * Add meta controls for selected poition
	 *
	 * @param  [type] $position [description]
	 * @return [type]           [description]
	 */
	public function add_meta_controls( $position_slug, $position_name ) {

		$this->add_control(
			'show_' . $position_slug . '_meta',
			array(
				'label'        => sprintf( esc_html__( 'Show Meta %s', 'rx-theme-assistant' ), $position_name ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'meta_' . $position_slug . '_position',
			array(
				'label'   => esc_html__( 'Meta Fields Position', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'before',
				'options' => array(
					'before' => esc_html__( 'Before', 'rx-theme-assistant' ),
					'after'  => esc_html__( 'After', 'rx-theme-assistant' ),
				),
				'condition'   => array(
					'show_' . $position_slug . '_meta' => 'yes',
				),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'meta_key',
			array(
				'label'       => esc_html__( 'Key', 'rx-theme-assistant' ),
				'description' => esc_html__( 'Meta key from postmeta table in database', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			)
		);

		$repeater->add_control(
			'meta_label',
			array(
				'label'   => esc_html__( 'Label', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$repeater->add_control(
			'meta_format',
			array(
				'label'       => esc_html__( 'Value Format', 'rx-theme-assistant' ),
				'description' => esc_html__( 'Value format string, accepts HTML markup. %s - is meta value', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '%s',
			)
		);

		$repeater->add_control(
			'meta_callback',
			array(
				'label'   => esc_html__( 'Prepare meta value with callback', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''                        => esc_html__( 'Clean', 'rx-theme-assistant' ),
					'get_permalink'           => 'get_permalink',
					'get_the_title'           => 'get_the_title',
					'wp_get_attachment_url'   => 'wp_get_attachment_url',
					'wp_get_attachment_image' => 'wp_get_attachment_image',
				),
			)
		);

		$repeater->add_control(
			'meta_custom_class',
			array(
				'label'       => esc_html__( 'Custom Class', 'rx-theme-assistant' ),
				'description' => esc_html__( 'Custom Class for meta field', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			$position_slug . '_meta',
			array(
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'meta_label' => esc_html__( 'Label', 'rx-theme-assistant' ),
					)
				),
				'title_field' => '{{{ meta_key }}}',
				'condition'   => array(
					'show_' . $position_slug . '_meta' => 'yes',
				),
			)
		);

	}

	/**
	 * Add meta controls for selected poition
	 *
	 * @param  [type] $position [description]
	 * @return [type]           [description]
	 */
	public function add_meta_style_controls( $position_slug, $position_name, $base ) {

		$this->add_control(
			$position_slug . '_meta_styles',
			array(
				'label'     => sprintf( esc_html__( 'Meta Styles %s', 'rx-theme-assistant' ), $position_name ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			$position_slug . '_meta_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .' . $base => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			$position_slug . '_meta_label_heading',
			array(
				'label'     => esc_html__( 'Meta Label', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			$position_slug . '_meta_label_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .' . $base . '__item-label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => $position_slug . '_meta_label_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .' . $base . '__item-label',
			)
		);

		$this->add_control(
			$position_slug . '_meta_label_display',
			array(
				'label'   => esc_html__( 'Dispaly Meta Label and Value', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'inline-block' => esc_html__( 'Inline', 'rx-theme-assistant' ),
					'block'        => esc_html__( 'As Blocks', 'rx-theme-assistant' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .' . $base . '__item-label' => 'display: {{VALUE}}',
					'{{WRAPPER}} .' . $base . '__item-value' => 'display: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			$position_slug . '_meta_label_gap',
			array(
				'label'       => esc_html__( 'Horizontal Gap Between Label and Value', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 5,
				'min'         => 0,
				'max'         => 20,
				'step'        => 1,
				'selectors' => array(
					'{{WRAPPER}} .' . $base . '__item-label' => 'margin-right: {{VALUE}}px',
				),
			)
		);

		$this->add_control(
			$position_slug . '_meta_value_heading',
			array(
				'label'     => esc_html__( 'Meta Value', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			$position_slug . '_meta_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .' . $base . '__item-value' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => $position_slug . '_meta_typography',
				'selector' => '{{WRAPPER}} .' . $base . '__item-value',
			)
		);

		$this->add_responsive_control(
			$position_slug . '_meta_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .' . $base => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			$position_slug . '_meta_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .' . $base => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			$position_slug . '_meta_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .' . $base => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	}
}
