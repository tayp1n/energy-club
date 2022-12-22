<?php
/**
 * Class: Rx_Theme_Assistant_Dynamic_Button
 * Name: Page & Post Button
 * Slug: rx-theme-assistant-dynamic-button
 */

namespace Elementor;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rx_Theme_Assistant_Dynamic_Button extends Rx_Theme_Assistant_Base {

	public function get_name() {
		return 'rx-theme-assistant-dynamic-button';
	}

	public function get_title() {
		return esc_html__( 'Page & Post Button', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return array( 'rx-dynamic-posts' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'rx-theme-assistant' ),
			]
		);

		$this->add_control(
			'button_type',
			[
				'label' => esc_html__( 'Type', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__( 'Default', 'rx-theme-assistant' ),
					'info'    => esc_html__( 'Info', 'rx-theme-assistant' ),
					'success' => esc_html__( 'Success', 'rx-theme-assistant' ),
					'warning' => esc_html__( 'Warning', 'rx-theme-assistant' ),
					'danger'  => esc_html__( 'Danger', 'rx-theme-assistant' ),
				],
				'prefix_class' => 'elementor-button-',
			]
		);

		$this->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', 'rx-theme-assistant' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Read More', 'rx-theme-assistant' ),
				'placeholder' => esc_html__( 'Read More', 'rx-theme-assistant' ),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => esc_html__( 'Size', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => [
					'xs' => esc_html__( 'Extra Small', 'rx-theme-assistant' ),
					'sm' => esc_html__( 'Small', 'rx-theme-assistant' ),
					'md' => esc_html__( 'Medium', 'rx-theme-assistant' ),
					'lg' => esc_html__( 'Large', 'rx-theme-assistant' ),
					'xl' => esc_html__( 'Extra Large', 'rx-theme-assistant' ),
				],
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'rx-theme-assistant' ),
				'type' => Controls_Manager::ICONS,
				'default' => [],
				'label_block' => true,
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => esc_html__( 'Icon Position', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Before', 'rx-theme-assistant' ),
					'right' => esc_html__( 'After', 'rx-theme-assistant' ),
				],
				'condition' => [
					'icon!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 50,
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
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
					'{{WRAPPER}} .elementor-button-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'View', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Button', 'rx-theme-assistant' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button .elementor-button-icon i, {{WRAPPER}} .elementor-button .elementor-button-icon i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => esc_html__( 'Icon Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover .elementor-button-icon i, {{WRAPPER}} .elementor-button:hover .elementor-button-icon i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .elementor-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings      = $this->get_settings_for_display();
		$button_format ='<a href="%1$s" %2$s %3$s>' . $this->render_text() . '</a>';
		$buttin_class  = 'elementor-button elementor-size-' . $settings['size'] . ' elementor-animation-' . $settings['hover_animation'];

		$this->__context = 'render';
		$this->__open_wrap( 'elementor-widget-button rxta-dynamic-button' );

		rx_theme_assistant_post_tools()->get_post_button( array(
			'text'    => $settings['text'],
			'html'    => $button_format,
			'class'   => $buttin_class,
			'echo'    => true,
		) );

		$this->__close_wrap();
	}

	/**
	 * Render button widget text.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function render_text() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 'elementor-button-content-wrapper',
			],
			'icon-align' => [
				'class' => [
					'elementor-button-icon',
					'elementor-align-icon-' . $settings['icon_align'],
				],
			],
			'text' => [
				'class' => 'elementor-button-text',
			],
		] );

		$this->add_inline_editing_attributes( 'text', 'none' );

		$output = '<span ' . $this->get_render_attribute_string( 'content-wrapper' ) . '>';

		if ( ! empty( $settings['icon'] ) ) :
			$output .= '<span ' . $this->get_render_attribute_string( 'icon-align' ) . '>';
			$output .= $this->get_frontend_icon( $settings );
			$output .= '</span>';
		endif;

		$output .= '<span ' . $this->get_render_attribute_string( 'text' ) . '>%4$s</span>';
		$output .= '</span>';

		return $output;
	}

	/**
	 * Render button widget icon.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function get_frontend_icon( $settings ) {
		$output = '';

		if( empty( $settings[ 'icon' ] ) &&  empty( $settings[ 'icon' ]['value'] ) ){
			return $output;
		}

		$type = $settings[ 'icon' ][ 'library' ];

		switch ( $type ) {
			case 'svg':
				$output = Svg_Handler::get_inline_svg( $settings[ 'icon' ][ 'value' ][ 'id' ] );
			break;

			default:
				$format = apply_filters( 'rxta-dynamic-button-icon-html', '<i class="%s" aria-hidden="true"></i>' );
				$output = sprintf( $format, $settings[ 'icon' ][ 'value' ] );
			break;
		}

		return $output;
	}
}
