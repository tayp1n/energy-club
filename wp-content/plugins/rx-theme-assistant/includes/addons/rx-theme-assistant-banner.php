<?php
/**
 * Class: Rx_Theme_Assistant_Banner
 * Name: Banner
 * Slug: rx-theme-assistant-banner
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
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rx_Theme_Assistant_Banner extends Rx_Theme_Assistant_Base {

	public function get_name() {
		return 'rx-theme-assistant-banner';
	}

	public function get_title() {
		return esc_html__( 'Banner', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-banner';
	}

	public function get_categories() {
		return array( 'rx-theme-assistant' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'banner_image',
			array(
				'label'   => esc_html__( 'Image', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'banner_image_size',
			array(
				'type'       => 'select',
				'label'      => esc_html__( 'Image Size', 'rx-theme-assistant' ),
				'default'    => 'full',
				'options'    => rx_theme_assistant_tools()->get_image_sizes(),
			)
		);

		$this->add_control(
			'banner_title',
			array(
				'label'   => esc_html__( 'Title', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'banner_title_html_tag',
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
				'default' => 'h5',
			)
		);

		$this->add_control(
			'banner_text',
			array(
				'label'   => esc_html__( 'Description', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'banner_link',
			array(
				'label'   => esc_html__( 'Link', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array(
					'active' => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
			)
		);

		$this->add_control(
			'banner_link_target',
			array(
				'label'        => esc_html__( 'Open link in new window', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => '_blank',
				'condition'    => array(
					'banner_link!' => '',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings',
			array(
				'label' => esc_html__( 'Settings', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'animation_effect',
			array(
				'label'   => esc_html__( 'Animation Effect', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'lily',
				'options' => array(
					'none'   => esc_html__( 'None', 'rx-theme-assistant' ),
					'lily'   => esc_html__( 'Lily', 'rx-theme-assistant' ),
					'sadie'  => esc_html__( 'Sadie', 'rx-theme-assistant' ),
					'layla'  => esc_html__( 'Layla', 'rx-theme-assistant' ),
					'oscar'  => esc_html__( 'Oscar', 'rx-theme-assistant' ),
					'marley' => esc_html__( 'Marley', 'rx-theme-assistant' ),
					'ruby'   => esc_html__( 'Ruby', 'rx-theme-assistant' ),
					'roxy'   => esc_html__( 'Roxy', 'rx-theme-assistant' ),
					'bubba'  => esc_html__( 'Bubba', 'rx-theme-assistant' ),
					'romeo'  => esc_html__( 'Romeo', 'rx-theme-assistant' ),
					'sarah'  => esc_html__( 'Sarah', 'rx-theme-assistant' ),
					'chico'  => esc_html__( 'Chico', 'rx-theme-assistant' ),
				),
			)
		);

		$this->end_controls_section();

		$css_scheme = apply_filters(
			'rx-theme-assistant/banner/css-scheme',
			array(
				'banner'         => '.rx-banner',
				'banner_content' => '.rx-banner__content',
				'banner_overlay' => '.rx-banner__overlay',
				'banner_title'   => '.rx-banner__title',
				'banner_text'    => '.rx-banner__text',
			)
		);

		$this->start_controls_section(
			'section_banner_item_style',
			array(
				'label'      => esc_html__( 'General', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_background' );

		$this->start_controls_tab(
			'tab_background_normal',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'items_content_color',
			array(
				'label'     => esc_html__( 'Additional Elements Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-effect-layla ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-layla ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-oscar ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-marley ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-ruby ' . $css_scheme['banner_text'] => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-roxy ' . $css_scheme['banner_text'] . '::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-roxy ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-bubba ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-bubba ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-romeo ' . $css_scheme['banner_content'] . '::before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-romeo ' . $css_scheme['banner_content'] . '::after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-sarah ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-chico ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['banner_overlay'],
			)
		);

		$this->add_control(
			'normal_opacity',
			array(
				'label'   => esc_html__( 'Opacity', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '0',
				'min'     => 0,
				'max'     => 1,
				'step'    => 0.1,
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['banner_overlay'] => 'opacity: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_background_hover',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'items_content_hover_color',
			array(
				'label'     => esc_html__( 'Additional Elements Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-effect-layla:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-layla:hover ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-oscar:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-marley:hover ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-ruby:hover ' . $css_scheme['banner_text'] => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-roxy:hover ' . $css_scheme['banner_text'] . '::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-roxy:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-bubba:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-bubba:hover ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-romeo:hover ' . $css_scheme['banner_content'] . '::before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-romeo:hover ' . $css_scheme['banner_content'] . '::after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-sarah:hover ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .rx-effect-chico:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'background_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['banner'] . ':hover ' . $css_scheme['banner_overlay'],
			)
		);

		$this->add_control(
			'hover_opacity',
			array(
				'label'   => esc_html__( 'Opacity', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '0.4',
				'min'     => 0,
				'max'     => 1,
				'step'    => 0.1,
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['banner'] . ':hover ' . $css_scheme['banner_overlay'] => 'opacity: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'banner_padding',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['banner'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'banner_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['banner'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'banner_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['banner'],
			)
		);

		$this->add_control(
			'banner_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['banner'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'banner_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['banner'],
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_banner_title_style',
			array(
				'label'      => esc_html__( 'Title Typography', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'banner_title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['banner_title'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'banner_title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['banner_title'],
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['banner_title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'left'    => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-arrow-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-arrow-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['banner_title'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_banner_text_style',
			array(
				'label'      => esc_html__( 'Description Typography', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'banner_text_color',
			array(
				'label'     => esc_html__( 'Description Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['banner_text'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'banner_text_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['banner_text'],
			)
		);

		$this->add_responsive_control(
			'text_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['banner_text'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'text_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-arrow-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'fa fa-arrow-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['banner_text'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_order_style',
			array(
				'label'      => esc_html__( 'Content Order', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'banner_title_order',
			array(
				'label'   => esc_html__( 'Title Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'max'     => 2,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['banner_title'] => 'order: {{VALUE}};',
				),
			)
		);


		$this->add_control(
			'banner_text_order',
			array(
				'label'   => esc_html__( 'Description Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 2,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['banner_text'] => 'order: {{VALUE}};',
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

	public function __get_banner_image() {

		$image = $this->get_settings_for_display( 'banner_image' );

		if ( empty( $image['id'] ) && empty( $image['url'] ) ) {
			return;
		}

		$format = apply_filters( 'rx-theme-assistant/banner/image-format', '<img src="%s" alt="" class="rx-banner__img">' );

		if ( empty( $image['id'] ) ) {
			return sprintf( $format, $image['url'] );
		}

		$size = $this->get_settings_for_display( 'banner_image_size' );

		if ( ! $size ) {
			$size = 'full';
		}

		$image_url = wp_get_attachment_image_url( $image['id'], $size );

		return sprintf( $format, $image_url );
	}

}
