<?php
/**
 * Class: Rx_Theme_Assistant_Register
 * Name: Registration Form
 * Slug: rx-theme-assistant-register
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

class Rx_Theme_Assistant_Register extends Rx_Theme_Assistant_Base {

	public function get_name() {
		return 'rx-theme-assistant-register';
	}

	public function get_title() {
		return esc_html__( 'Registration Form', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
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
			'label_username',
			array(
				'label'   => esc_html__( 'Username Label', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Username', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'placeholder_username',
			array(
				'label'   => esc_html__( 'Username Placeholder', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Username', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'label_email',
			array(
				'label'   => esc_html__( 'Email Label', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Email', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'placeholder_email',
			array(
				'label'   => esc_html__( 'Email Placeholder', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Email', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'label_pass',
			array(
				'label'   => esc_html__( 'Password Label', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Password', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'placeholder_pass',
			array(
				'label'   => esc_html__( 'Password Placeholder', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Password', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'confirm_password',
			array(
				'label'        => esc_html__( 'Show Confirm Password Field', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'label_pass_confirm',
			array(
				'label'     => esc_html__( 'Confirm Password Label', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Please Confirm Password', 'rx-theme-assistant' ),
				'condition' => array(
					'confirm_password' => 'yes'
				)
			)
		);

		$this->add_control(
			'placeholder_pass_confirm',
			array(
				'label'     => esc_html__( 'Confirm Password Placeholder', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Confirm Password', 'rx-theme-assistant' ),
				'condition' => array(
					'confirm_password' => 'yes'
				)
			)
		);

		$this->add_control(
			'label_submit',
			array(
				'label'   => esc_html__( 'Register Button Label', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Register', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'register_redirect',
			array(
				'type'       => 'select',
				'label'      => esc_html__( 'Redirect After Register', 'rx-theme-assistant' ),
				'default'    => 'home',
				'options'    => array(
					'home'   => esc_html__( 'Home page', 'rx-theme-assistant' ),
					'left'   => esc_html__( 'Stay on the current page', 'rx-theme-assistant' ),
					'custom' => esc_html__( 'Custom URL', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_control(
			'register_redirect_url',
			array(
				'label'     => esc_html__( 'Redirect URL', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array(
					'register_redirect' => 'custom',
				),
			)
		);

		$this->add_control(
			'label_registered',
			array(
				'label'   => esc_html__( 'User Registered Message', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'You already registered', 'rx-theme-assistant' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'register_fields_style',
			array(
				'label'      => esc_html__( 'Fields', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'input_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-register__input' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'input_color',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-register__input' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'input_typography',
				'selector' => '{{WRAPPER}} .rx-register__input',
			)
		);

		$this->add_control(
			'placeholder_style',
			array(
				'label'     => esc_html__( 'Placeholder', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'input_placeholder_color',
			array(
				'label'  => esc_html__( 'Placeholder Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-register__input::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .rx-register__input::-moz-placeholder'          => 'color: {{VALUE}}',
					'{{WRAPPER}} .rx-register__input:-ms-input-placeholder'      => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'input_placeholder_typography',
				'selector' => '{{WRAPPER}} .rx-register__input::-webkit-input-placeholder',
			)
		);

		$this->add_responsive_control(
			'input_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .rx-register__input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'input_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-register__input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'input_border',
				'label'          => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} .rx-register__input',
			)
		);

		$this->add_responsive_control(
			'input_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-register__input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'input_box_shadow',
				'selector' => '{{WRAPPER}} .rx-register__input',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'register_labels_style',
			array(
				'label'      => esc_html__( 'Labels', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'labels_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-register__label' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'labels_color',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-register__label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'labels_typography',
				'selector' => '{{WRAPPER}} .rx-register__label',
			)
		);

		$this->add_responsive_control(
			'labels_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-register__label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'labels_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-register__label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'labels_border',
				'label'          => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} .rx-register__label',
			)
		);

		$this->add_responsive_control(
			'labels_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-register__label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'labels_box_shadow',
				'selector' => '{{WRAPPER}} .rx-register__label',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'register_submit_style',
			array(
				'label'      => esc_html__( 'Submit', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_form_submit_style' );

		$this->start_controls_tab(
			'register_form_submit_normal',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'register_submit_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-register__submit' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'register_submit_color',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-register__submit' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'register_form_submit_hover',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'register_submit_bg_color_hover',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-register__submit:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'register_submit_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-register__submit:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'register_submit_hover_border_color',
			array(
				'label' => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'register_submit_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .rx-register__submit:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'register_submit_typography',
				'selector' => '{{WRAPPER}} .rx-register__submit',
			)
		);

		$this->add_responsive_control(
			'register_submit_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-register__submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'register_submit_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-register__submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'register_submit_border',
				'label'          => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} .rx-register__submit',
			)
		);

		$this->add_responsive_control(
			'register_submit_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-register__submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'register_submit_box_shadow',
				'selector' => '{{WRAPPER}} .rx-register__submit',
			)
		);

		$this->add_responsive_control(
			'register_submit_alignment',
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
					'{{WRAPPER}} .rx-register-submit' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'login_errors_style',
			array(
				'label'      => esc_html__( 'Errors', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'errors_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-register-message' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'errors_color',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-register-message' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'errors_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-register-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'errors_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-register-message' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'errors_border',
				'label'          => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} .rx-register-message',
			)
		);

		$this->add_responsive_control(
			'errors_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-register-message' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'errors_box_shadow',
				'selector' => '{{WRAPPER}} .rx-register-message',
			)
		);

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		$settings = $this->get_settings();

		if ( is_user_logged_in() && ! rx_theme_assistant_integration()->in_elementor() ) {

			$this->__open_wrap();
			echo $settings['label_registered'];
			$this->__close_wrap();

			return;
		}

		$registration_enabled = get_option( 'users_can_register' );

		if ( ! $registration_enabled && ! rx_theme_assistant_integration()->in_elementor() ) {

			$this->__open_wrap();
			esc_html_e( 'Registration disabled', 'rx-theme-assistant' );
			$this->__close_wrap();

			return;
		}

		$this->__open_wrap();

		$redirect_url = site_url( $_SERVER['REQUEST_URI'] );

		switch ( $settings['register_redirect'] ) {

			case 'home':
				$redirect_url = esc_url( home_url( '/' ) );
				break;

			case 'custom':
				$redirect_url = $settings['register_redirect_url'];
				break;
		}

		if ( ! $registration_enabled ) {
			esc_html_e( 'Registration currently disabled and this form will not be visible for guest users. Please, enable registration in Settings/General or remove this widget from the page.', 'rx-theme-assistant' );
		}

		include $this->__get_global_template( 'index' );

		$this->__close_wrap();
	}

}
