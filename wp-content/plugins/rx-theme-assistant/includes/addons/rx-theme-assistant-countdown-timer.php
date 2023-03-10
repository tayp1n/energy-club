<?php
/**
 * Class: Rx_Theme_Assistant_Countdown_Timer
 * Name: Countdown Timer
 * Slug: rxta-countdown-timer
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

class Rx_Theme_Assistant_Countdown_Timer extends Rx_Theme_Assistant_Base {

	public function get_name() {
		return 'rx-theme-assistant-countdown-timer';
	}

	public function get_title() {
		return esc_html__( 'Countdown Timer', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return array( 'rx-theme-assistant' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'General', 'rx-theme-assistant' ),
			)
		);

		$default_date = date(
			'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS )
		);

		$this->add_control(
			'due_date',
			array(
				'label'       => esc_html__( 'Due Date', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => $default_date,
				'description' => sprintf(
					esc_html__( 'Date set according to your timezone: %s.', 'rx-theme-assistant' ),
					Utils::get_timezone_string()
				),
			)
		);

		$this->add_control(
			'show_days',
			array(
				'label'        => esc_html__( 'Days', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'Hide', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'label_days',
			array(
				'label'       => esc_html__( 'Days Label', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Days', 'rx-theme-assistant' ),
				'placeholder' => esc_html__( 'Days', 'rx-theme-assistant' ),
				'condition'   => array(
					'show_days'      => 'yes',
				),
			)
		);

		$this->add_control(
			'show_hours',
			array(
				'label'        => esc_html__( 'Hours', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'Hide', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'label_hours',
			array(
				'label'       => esc_html__( 'Hours Label', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Hours', 'rx-theme-assistant' ),
				'placeholder' => esc_html__( 'Hours', 'rx-theme-assistant' ),
				'condition'   => array(
					'show_hours'      => 'yes',
				),
			)
		);

		$this->add_control(
			'show_min',
			array(
				'label'        => esc_html__( 'Minutes', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'Hide', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'label_min',
			array(
				'label'       => esc_html__( 'Minutes Label', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Minutes', 'rx-theme-assistant' ),
				'placeholder' => esc_html__( 'Minutes', 'rx-theme-assistant' ),
				'condition'   => array(
					'show_min'      => 'yes',
				),
			)
		);

		$this->add_control(
			'show_sec',
			array(
				'label'        => esc_html__( 'Seconds', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'Hide', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'label_sec',
			array(
				'label'       => esc_html__( 'Seconds Label', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Seconds', 'rx-theme-assistant' ),
				'placeholder' => esc_html__( 'Seconds', 'rx-theme-assistant' ),
				'condition'   => array(
					'show_sec'      => 'yes',
				),
			)
		);

		$this->add_control(
			'blocks_sep',
			array(
				'label'       => esc_html__( 'Blocks Separator', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => ':',
			)
		);

		$this->end_controls_section();

		$css_scheme = apply_filters(
			'rx-theme-assistant/countdown-timer/css-scheme',
			array(
				'item'  => '.rxta-countdown-timer__item',
				'label' => '.rxta-countdown-timer__item-label',
				'value' => '.rxta-countdown-timer__item-value',
				'sep'   => '.rxta-countdown-timer__separator',
				'digit' => '.rxta-countdown-timer__digit',
			)
		);

		$this->start_controls_section(
			'section_item_styles',
			array(
				'label'      => esc_html__( 'Item', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'items_size',
			array(
				'label'   => esc_html__( 'Items Size', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fixed',
				'options' => array(
					'auto'  => esc_html__( 'Auto', 'rx-theme-assistant' ),
					'fixed' => esc_html__( 'Fixed', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_responsive_control(
			'items_size_val',
			array(
				'label'      => esc_html__( 'Width', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 110,
				),
				'range'      => array(
					'px' => array(
						'min' => 60,
						'max' => 600,
					),
					'em' => array(
						'min' => 1,
						'max' => 20,
					),
				),
				'render_type' => 'template',
				'condition'   => array(
					'items_size' => 'fixed',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'items_width_val',
			array(
				'label'      => esc_html__( 'Height', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 110,
				),
				'range'      => array(
					'px' => array(
						'min' => 60,
						'max' => 600,
					),
					'em' => array(
						'min' => 1,
						'max' => 20,
					),
				),
				'render_type' => 'template',
				'condition'   => array(
					'items_size' => 'fixed',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'item_bg',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'],
			)
		);

		$this->add_responsive_control(
			'item_padding',
			array(
				'label'      => esc_html__( 'Item Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['item'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'item_margin',
			array(
				'label'      => esc_html__( 'Item Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['item'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'border',
				'placeholder' => '1px',
				'fields_options' => array(
					'border' => array(
						'default' => 'solid',
					),
					'width' => array(
						'default' => array(
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						),
					),
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_3,
						),
					),
				),
				'selector'    => '{{WRAPPER}} ' . $css_scheme['item'],
			)
		);

		$this->add_control(
			'item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'item_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'],
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_label_styles',
			array(
				'label'      => esc_html__( 'Labels', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'label_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['label'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'label_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['label'],
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'label_bg',
				'selector' => '{{WRAPPER}} ' . $css_scheme['label'],
			)
		);

		$this->add_responsive_control(
			'label_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['label'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'label_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['label'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'label_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['label'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'label_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['label'],
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_digit_styles',
			array(
				'label'      => esc_html__( 'Digits', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'value_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['value'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'value_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['value'],
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'value_bg',
				'selector' => '{{WRAPPER}} ' . $css_scheme['value'],
			)
		);

		$this->add_responsive_control(
			'value_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['value'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'value_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['value'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'value_border',
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['value'],
			)
		);

		$this->add_control(
			'value_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['value'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'value_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['value'],
			)
		);

		$this->add_control(
			'digit_item_heading',
			array(
				'label'     => esc_html__( 'Digit Item Styles', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'digit_bg',
				'selector' => '{{WRAPPER}} ' . $css_scheme['digit'],
			)
		);

		$this->add_responsive_control(
			'digit_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['digit'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'digit_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['digit'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'digit_border',
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['digit'],
			)
		);

		$this->add_control(
			'digit_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['digit'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'digit_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['digit'],
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_sep_styles',
			array(
				'label'      => esc_html__( 'Separator Styles', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'sep_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['sep'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'sep_size',
			array(
				'label'      => esc_html__( 'Size', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 30,
				),
				'range'      => array(
					'px' => array(
						'min' => 12,
						'max' => 300,
					),
					'em' => array(
						'min' => 1,
						'max' => 20,
					),
				),
				'render_type' => 'template',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['sep'] => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'sep_font',
			array(
				'label'     => esc_html__( 'Font', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::FONT,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['sep'] => 'font-family: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'sep_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['sep'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'label'      => esc_html__( 'Order', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'value_order',
			array(
				'label'   => esc_html__( 'Digit Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'max'     => 2,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['value'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'label_order',
			array(
				'label'   => esc_html__( 'Label Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 2,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['label'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

	}

	public function due_date() {
		return strtotime( $this->get_settings( 'due_date' ) ) - ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );
	}

	public function date_placeholder() {
		return '<span class="rxta-countdown-timer__digit">0</span><span class="rxta-countdown-timer__digit">0</span>';
	}

	/**
	 * Blocks separator
	 *
	 * @return string
	 */
	public function blocks_separator() {

		$separator = $this->get_settings( 'blocks_sep' );

		if ( ! $separator ) {
			return;
		}

		$format = apply_filters(
			'rx-theme-assistant/countdown-timer/blocks-separator-format',
			'<div class="rxta-countdown-timer__separator">%s</div>'
		);

		return sprintf( $format, $separator );
	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();
		include $this->__get_global_template( 'index' );
		$this->__close_wrap();
	}

}
