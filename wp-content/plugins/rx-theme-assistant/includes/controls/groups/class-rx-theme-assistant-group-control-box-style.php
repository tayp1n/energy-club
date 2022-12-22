<?php

use Elementor\Group_Control_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rx_Theme_Assistant_Group_Control_Box_Style extends Group_Control_Base {

	protected static $fields;

	public static function get_type() {
		return 'rx-theme-assistant-box-style';
	}

	protected function init_fields() {

		$fields = [];

		$fields['box_font_color'] = array(
			'label'     => esc_html__( 'Font Color', 'rx-theme-assistant' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{SELECTOR}}' => 'color: {{VALUE}}',
			),
		);

		$fields['background'] = array(
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
			'label_block' => false,
			'render_type' => 'ui',
		);

		$fields['color'] = array(
			'label'     => _x( 'Color', 'Background Control', 'rx-theme-assistant' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'title'     => _x( 'Background Color', 'Background Control', 'rx-theme-assistant' ),
			'selectors' => array(
				'{{SELECTOR}}' => 'background-color: {{VALUE}};',
			),
			'condition' => array(
				'background' => array( 'color', 'gradient' ),
			),
		);

		$fields['color_stop'] = array(
			'label'      => _x( 'Location', 'Background Control', 'rx-theme-assistant' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array( '%' ),
			'default'    => array(
				'unit' => '%',
				'size' => 0,
			),
			'render_type' => 'ui',
			'condition' => array(
				'background' => array( 'gradient' ),
			),
			'of_type' => 'gradient',
		);

		$fields['color_b'] = array(
			'label'       => _x( 'Second Color', 'Background Control', 'rx-theme-assistant' ),
			'type'        => Controls_Manager::COLOR,
			'default'     => '#f2295b',
			'render_type' => 'ui',
			'condition'   => array(
				'background' => array( 'gradient' ),
			),
			'of_type' => 'gradient',
		);

		$fields['color_b_stop'] = array(
			'label'      => _x( 'Location', 'Background Control', 'rx-theme-assistant' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array( '%' ),
			'default'    => array(
				'unit' => '%',
				'size' => 100,
			),
			'render_type' => 'ui',
			'condition'   => array(
				'background' => array( 'gradient' ),
			),
			'of_type' => 'gradient',
		);

		$fields['gradient_type'] = array(
			'label'   => _x( 'Type', 'Background Control', 'rx-theme-assistant' ),
			'type'    => Controls_Manager::SELECT,
			'options' => array(
				'linear' => _x( 'Linear', 'Background Control', 'rx-theme-assistant' ),
				'radial' => _x( 'Radial', 'Background Control', 'rx-theme-assistant' ),
			),
			'default'     => 'linear',
			'render_type' => 'ui',
			'condition'   => array(
				'background' => array( 'gradient' ),
			),
			'of_type' => 'gradient',
		);

		$fields['gradient_angle'] = array(
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
				'{{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
			),
			'condition' => array(
				'background'    => array( 'gradient' ),
				'gradient_type' => 'linear',
			),
			'of_type' => 'gradient',
		);

		$fields['gradient_position'] = array(
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
				'{{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
			),
			'condition' => array(
				'background'    => array( 'gradient' ),
				'gradient_type' => 'radial',
			),
			'of_type' => 'gradient',
		);

		$fields['box_font_size'] = array(
			'label'      => esc_html__( 'Icon Size', 'rx-theme-assistant' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array(
				'px', 'em', 'rem',
			),
			'responsive' => true,
			'range'      => array(
				'px' => array(
					'min' => 5,
					'max' => 500,
				),
			),
			'selectors'  => array(
				'{{SELECTOR}}:before' => 'font-size: {{SIZE}}{{UNIT}}',
				'{{SELECTOR}}'        => 'font-size: {{SIZE}}{{UNIT}}',
				'{{SELECTOR}} svg'    => 'width: {{SIZE}}{{UNIT}}',
			),
		);

		$fields['box_size'] = array(
			'label'      => esc_html__( 'Box Size', 'rx-theme-assistant' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array(
				'px', 'em', '%',
			),
			'range'      => array(
				'px' => array(
					'min' => 5,
					'max' => 500,
				),
			),
			'responsive' => true,
			'selectors'  => array(
				'{{SELECTOR}}' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			),
		);

		$fields['box_border'] = array(
			'label'   => _x( 'Border Type', 'Border Control', 'rx-theme-assistant' ),
			'type'    => Controls_Manager::SELECT,
			'options' => array(
				''       => __( 'None', 'rx-theme-assistant' ),
				'solid'  => _x( 'Solid', 'Border Control', 'rx-theme-assistant' ),
				'double' => _x( 'Double', 'Border Control', 'rx-theme-assistant' ),
				'dotted' => _x( 'Dotted', 'Border Control', 'rx-theme-assistant' ),
				'dashed' => _x( 'Dashed', 'Border Control', 'rx-theme-assistant' ),
			),
			'selectors' => array(
				'{{SELECTOR}}' => 'border-style: {{VALUE}};',
			),
		);

		$fields['box_border_width'] = array(
			'label'     => _x( 'Width', 'Border Control', 'rx-theme-assistant' ),
			'type'      => Controls_Manager::DIMENSIONS,
			'selectors' => array(
				'{{SELECTOR}}' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
			'condition' => array(
				'box_border!' => '',
			),
		);

		$fields['box_border_color'] = array(
			'label' => _x( 'Color', 'Border Control', 'rx-theme-assistant' ),
			'type' => Controls_Manager::COLOR,
			'default' => '',
			'selectors' => array(
				'{{SELECTOR}}' => 'border-color: {{VALUE}};',
			),
			'condition' => array(
				'box_border!' => '',
			),
		);

		$fields['box_border_radius'] = array(
			'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', '%' ),
			'selectors'  => array(
				'{{SELECTOR}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		);

		$fields['allow_box_shadow'] = array(
			'label' => _x( 'Box Shadow', 'Box Shadow Control', 'rx-theme-assistant' ),
			'type' => Controls_Manager::SWITCHER,
			'label_on' => esc_html__( 'Yes', 'rx-theme-assistant' ),
			'label_off' => esc_html__( 'No', 'rx-theme-assistant' ),
			'return_value' => 'yes',
			'separator' => 'before',
			'render_type' => 'ui',
		);

		$fields['box_shadow'] = array(
			'label'     => _x( 'Box Shadow', 'Box Shadow Control', 'rx-theme-assistant' ),
			'type'      => Controls_Manager::BOX_SHADOW,
			'condition' => array(
				'allow_box_shadow!' => '',
			),
			'selectors' => array(
				'{{SELECTOR}}' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}} {{box_shadow_position.VALUE}};',
			),
		);

		$fields['box_shadow_position'] = array(
			'label' => _x( 'Position', 'Box Shadow Control', 'rx-theme-assistant' ),
			'type' => Controls_Manager::SELECT,
			'options' => array(
				' '     => _x( 'Outline', 'Box Shadow Control', 'rx-theme-assistant' ),
				'inset' => _x( 'Inset', 'Box Shadow Control', 'rx-theme-assistant' ),
			),
			'condition' => array(
				'allow_box_shadow!' => '',
			),
			'default' => ' ',
			'render_type' => 'ui',
		);

		return $fields;
	}
}
