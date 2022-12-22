<?php
/**
 * Class: Rx_Theme_Assistant_Logo
 * Name: Logo
 * Slug: rx-theme-assistant-logo
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

class Rx_Theme_Assistant_Logo extends Rx_Theme_Assistant_Base {

	public function get_name() {
		return 'rx-theme-assistant-logo';
	}

	public function get_title() {
		return esc_html__( 'Site Logo', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-logo';
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
			'logo_type',
			array(
				'type'    => 'select',
				'label'   => esc_html__( 'Logo Type', 'rx-theme-assistant' ),
				'default' => 'text',
				'options' => array(
					'text'  => esc_html__( 'Text', 'rx-theme-assistant' ),
					'image' => esc_html__( 'Image', 'rx-theme-assistant' ),
					'both'  => esc_html__( 'Both Text and Image', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_control(
			'logo_image',
			array(
				'label'     => esc_html__( 'Logo Image', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => array(
					'logo_type!' => 'text',
				),
			)
		);

		$this->add_control(
			'logo_image_2x',
			array(
				'label'     => esc_html__( 'Retina Logo Image', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => array(
					'logo_type!' => 'text',
				),
			)
		);

		$this->add_control(
			'logo_text_from',
			array(
				'type'       => 'select',
				'label'      => esc_html__( 'Logo Text From', 'rx-theme-assistant' ),
				'default'    => 'site_name',
				'options'    => array(
					'site_name' => esc_html__( 'Site Name', 'rx-theme-assistant' ),
					'custom'    => esc_html__( 'Custom', 'rx-theme-assistant' ),
				),
				'condition' => array(
					'logo_type!' => 'image',
				),
			)
		);

		$this->add_control(
			'logo_text',
			array(
				'label'     => esc_html__( 'Custom Logo Text', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'logo_text_from' => 'custom',
					'logo_type!'     => 'image',
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
			'linked_logo',
			array(
				'label'        => esc_html__( 'Linked Logo', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'remove_link_on_front',
			array(
				'label'        => esc_html__( 'Remove Link on Front Page', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => '',
			)
		);

		$this->add_control(
			'logo_display',
			array(
				'type'        => 'select',
				'label'       => esc_html__( 'Display Logo Image and Text', 'rx-theme-assistant' ),
				'label_block' => true,
				'default'     => 'block',
				'options'     => array(
					'inline' => esc_html__( 'Inline', 'rx-theme-assistant' ),
					'block'  => esc_html__( 'Text Below Image', 'rx-theme-assistant' ),
				),
				'condition' => array(
					'logo_type' => 'both',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'logo_style',
			array(
				'label'      => esc_html__( 'Logo', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'logo_alignment',
			array(
				'label'   => esc_html__( 'Logo Alignment', 'rx-theme-assistant' ),
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
				),
				'selectors' => array(
					'{{WRAPPER}} .rx-logo' => 'justify-content: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Image Width', 'rx-theme-assistant' ),
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
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rx-logo img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'logo_type!' => 'text',
				],
			]
		);

		$this->add_control(
			'vertical_logo_alignment',
			array(
				'label'       => esc_html__( 'Image and Text Vertical Alignment', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'center',
				'label_block' => true,
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Top', 'rx-theme-assistant' ),
						'icon' => 'eicon-v-align-top',
					),
					'center' => array(
						'title' => esc_html__( 'Middle', 'rx-theme-assistant' ),
						'icon' => 'eicon-v-align-middle',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Bottom', 'rx-theme-assistant' ),
						'icon' => 'eicon-v-align-bottom',
					),
					'baseline' => array(
						'title' => esc_html__( 'Baseline', 'rx-theme-assistant' ),
						'icon' => 'eicon-v-align-bottom',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .rx-logo__link' => 'align-items: {{VALUE}}',
				),
				'condition' => array(
					'logo_type'    => 'both',
					'logo_display' => 'inline',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'text_logo_style',
			array(
				'label'      => esc_html__( 'Text', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'text_logo_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				),
				'selectors' => array(
					'{{WRAPPER}} .rx-logo__text' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_logo_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rx-logo__text',
			)
		);

		$this->add_control(
			'text_logo_gap',
			array(
				'label'      => esc_html__( 'Gap', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 5,
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .rx-logo-display-block .rx-logo__img'  => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .rx-logo-display-inline .rx-logo__img' => 'margin-right: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'logo_type' => 'both',
				),
			)
		);

		$this->add_responsive_control(
			'text_logo_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
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
				'selectors' => array(
					'{{WRAPPER}} .rx-logo__text' => 'text-align: {{VALUE}}',
				),
				'condition' => array(
					'logo_type'    => 'both',
					'logo_display' => 'block',
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
	 * Check if logo is linked
	 */
	public function __is_linked() {

		$settings = $this->get_settings();

		if ( empty( $settings['linked_logo'] ) ) {
			return false;
		}

		if ( 'true' === $settings['remove_link_on_front'] && is_front_page() ) {
			return false;
		}

		return true;

	}

	/**
	 * Returns logo text
	 */
	public function __get_logo_text() {

		$settings    = $this->get_settings();
		$type        = isset( $settings['logo_type'] ) ? esc_attr( $settings['logo_type'] ) : 'text';
		$text_from   = isset( $settings['logo_text_from'] ) ? esc_attr( $settings['logo_text_from'] ) : 'site_name';
		$custom_text = isset( $settings['logo_text'] ) ? esc_attr( $settings['logo_text'] ) : '';

		if ( 'image' === $type ) {
			return;
		}

		if ( 'site_name' === $text_from ) {
			$text = get_bloginfo( 'name' );
		} else {
			$text = $custom_text;
		}

		$format = apply_filters(
			'rx-theme-assistant/widgets/logo/text-foramt',
			'<div class="rx-logo__text">%s</div>'
		);

		return sprintf( $format, $text );
	}

	/**
	 * Returns logo classes string
	 */
	public function __get_logo_classes() {

		$settings = $this->get_settings();

		$classes = array(
			'rx-logo',
			'rx-logo-type-' . $settings['logo_type'],
			'rx-logo-display-' . $settings['logo_display'],
		);

		return implode( ' ', $classes );
	}

	/**
	 * Returns logo image
	 */
	public function __get_logo_image() {

		$settings = $this->get_settings();
		$type     = isset( $settings['logo_type'] ) ? esc_attr( $settings['logo_type'] ) : 'text';
		$image    = isset( $settings['logo_image'] ) ? $settings['logo_image'] : false;
		$image_2x = isset( $settings['logo_image_2x'] ) ? $settings['logo_image_2x'] : false;

		if ( 'text' === $type || ! $image ) {
			return;
		}

		if ( empty( $image['url'] ) && empty( $image_2x['url'] ) ) {
			return;
		}

		$format = apply_filters(
			'rx-theme-assistant/widgets/logo/image-format',
			'<img src="%1$s" class="rx-logo__img" alt="%2$s"%3$s>'
		);

		$image_data = wp_get_attachment_image_src( $image['id'], 'full' );
		$image_2x_data = wp_get_attachment_image_src( $image_2x['id'], 'full' );
		$image['url'] = $image_data[0];
		$image_2x['url'] = $image_2x_data[0];
		$width      = isset( $image_data[1] ) ? $image_data[1] : false;
		$height     = isset( $image_data[2] ) ? $image_data[2] : false;

		$attrs = sprintf(
			'%1$s%2$s%3$s',
			$width ? ' width="' . $width . '"' : '',
			$height ? ' height="' . $height . '"' : '',
			( ! empty( $image_2x['url'] ) ? ' srcset="' . $image_2x['url'] . ' 2x"' : '' )
		);

		return sprintf( $format, $image['url'], get_bloginfo( 'name' ), $attrs );
	}
}
