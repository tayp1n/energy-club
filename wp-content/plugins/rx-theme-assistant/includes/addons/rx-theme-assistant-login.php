<?php
/**
 * Class: Rx_Theme_Assistant_Login
 * Name: Login Form
 * Slug: rx-theme-assistant-login
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

class Rx_Theme_Assistant_Login extends Rx_Theme_Assistant_Base {

	public function get_name() {
		return 'rx-theme-assistant-login';
	}

	public function get_title() {
		return esc_html__( 'Login Form', 'rx-theme-assistant' );
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
			'label_password',
			array(
				'label'   => esc_html__( 'Password Label', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Password', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'label_remember',
			array(
				'label'   => esc_html__( 'Remember Me Label', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Remember Me', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'label_log_in',
			array(
				'label'   => esc_html__( 'Log In Button Label', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Log In', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'login_redirect',
			array(
				'type'       => 'select',
				'label'      => esc_html__( 'Redirect After Login', 'rx-theme-assistant' ),
				'default'    => 'home',
				'options'    => array(
					'home'   => esc_html__( 'Home page', 'rx-theme-assistant' ),
					'left'   => esc_html__( 'Stay on the current page', 'rx-theme-assistant' ),
					'custom' => esc_html__( 'Custom URL', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_control(
			'login_redirect_url',
			array(
				'label'     => esc_html__( 'Redirect URL', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array(
					'login_redirect' => 'custom',
				),
			)
		);

		$this->add_control(
			'label_logged_in',
			array(
				'label'   => esc_html__( 'Logged in message', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'You already logged in', 'rx-theme-assistant' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'login_fields_style',
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
					'{{WRAPPER}} .rx-login input.input' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'input_color',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-login input.input' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'input_typography',
				'selector' => '{{WRAPPER}} .rx-login input.input',
			)
		);

		$this->add_responsive_control(
			'input_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-login input.input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .rx-login input.input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'input_border',
				'label'          => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} .rx-login input.input',
			)
		);

		$this->add_responsive_control(
			'input_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-login input.input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'input_box_shadow',
				'selector' => '{{WRAPPER}} .rx-login input.input',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'login_labels_style',
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
					'{{WRAPPER}} .rx-login label' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'labels_color',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-login label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'labels_typography',
				'selector' => '{{WRAPPER}} .rx-login label',
			)
		);

		$this->add_responsive_control(
			'labels_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-login label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .rx-login label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'labels_border',
				'label'          => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} .rx-login label',
			)
		);

		$this->add_responsive_control(
			'labels_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-login label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'labels_box_shadow',
				'selector' => '{{WRAPPER}} .rx-login label',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'login_submit_style',
			array(
				'label'      => esc_html__( 'Submit', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_form_submit_style' );

		$this->start_controls_tab(
			'login_form_submit_normal',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'login_submit_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} input[type="submit"]' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'login_submit_color',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} input[type="submit"]' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'login_form_submit_hover',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'login_submit_bg_color_hover',
			array(
				'label'  => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} input[type="submit"]:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'login_submit_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} input[type="submit"]:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'login_submit_hover_border_color',
			array(
				'label' => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'login_submit_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} input[type="submit"]:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'login_submit_typography',
				'selector' => '{{WRAPPER}} input[type="submit"]',
			)
		);

		$this->add_responsive_control(
			'login_submit_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'login_submit_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} input[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'login_submit_border',
				'label'          => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} input[type="submit"]',
			)
		);

		$this->add_responsive_control(
			'login_submit_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'login_submit_box_shadow',
				'selector' => '{{WRAPPER}} input[type="submit"]',
			)
		);

		$this->add_responsive_control(
			'login_submit_alignment',
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
					'{{WRAPPER}} .login-submit' => 'text-align: {{VALUE}};',
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
					'{{WRAPPER}} .rx-login-message' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'errors_color',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rx-login-message' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .rx-login-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .rx-login-message' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'errors_border',
				'label'          => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} .rx-login-message',
			)
		);

		$this->add_responsive_control(
			'errors_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-login-message' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'errors_box_shadow',
				'selector' => '{{WRAPPER}} .rx-login-message',
			)
		);

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		$settings = $this->get_settings();

		if ( is_user_logged_in() && ! rx_theme_assistant_integration()->in_elementor() ) {

			$this->__open_wrap();
			echo $settings['label_logged_in'];
			$this->__close_wrap();

			return;
		}

		$this->__open_wrap();

		$redirect_url = site_url( $_SERVER['REQUEST_URI'] );

		switch ( $settings['login_redirect'] ) {

			case 'home':
				$redirect_url = esc_url( home_url( '/' ) );
				break;

			case 'custom':
				$redirect_url = $settings['login_redirect_url'];
				break;
		}

		add_filter( 'login_form_bottom', array( $this, 'add_login_fields' ) );

		$login_form = wp_login_form( array(
			'echo'           => false,
			'redirect'       => $redirect_url,
			'label_username' => $settings['label_username'],
			'label_password' => $settings['label_password'],
			'label_remember' => $settings['label_remember'],
			'label_log_in'   => $settings['label_log_in'],
		) );

		remove_filter( 'login_form_bottom', array( $this, 'add_login_fields' ) );

		$login_form = preg_replace( '/action=[\'\"].*?[\'\"]/', '', $login_form );

		echo '<div class="rx-login">';
		echo apply_filters( 'rxta/login_form/html', $login_form, $settings );
		include $this->__get_global_template( 'messages' );
		echo '</div>';

		$this->__close_wrap();
	}

	/**
	 * Add form fields
	 *
	 * @param string $content
	 */
	public function add_login_fields( $content ) {
		$content .= '<input type="hidden" name="rx_login" value="1">';
		return $content;
	}

}
