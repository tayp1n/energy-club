<?php
/**
 * Class: Rx_Theme_Assistant_Dynamic_Content
 * Name: Page & Post Content
 * Slug: rx-theme-assistant-dynamic-content
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rx_Theme_Assistant_Dynamic_Content extends Rx_Theme_Assistant_Base {

	public function get_name() {
		return 'rx-theme-assistant-dynamic-content';
	}

	public function get_title() {
		return esc_html__( 'Page & Post Content', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-editor-paragraph';
	}

	public function get_categories() {
		return array( 'rx-dynamic-posts' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'tag',
			array(
				'label'   => esc_html__( 'Content HTML Tag', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'div'  => esc_html__( 'div', 'rx-theme-assistant' ),
					'span' => esc_html__( 'span', 'rx-theme-assistant' ),
					'p'    => esc_html__( 'p', 'rx-theme-assistant' ),
				),
				'default' => 'p',
			)
		);

		$this->add_control(
			'content_type',
			array(
				'label'   => esc_html__( 'Post Content Type', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'post_content'  => esc_html__( 'Content', 'rx-theme-assistant' ),
					'post_excerpt' => esc_html__( 'Excerpt', 'rx-theme-assistant' ),
				),
				'default' => 'post_content',
			)
		);

		$this->add_control(
			'cut_content',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Cut Content', 'rx-theme-assistant' ),
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'length',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Content Length', 'rx-theme-assistant' ),
				'default'   => 50,
				'min'       => 1,
				'max'       => 1500,
				'step'      => 1,
				'condition' => array(
					'cut_content'    => 'true',
				),
			)
		);

		$this->add_control(
			'ending',
			array(
				'label'   => esc_html__( 'Text Ending', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array( 'active' => true ),
				'default' =>'...',
				'condition' => array(
					'cut_content'    => 'true',
				),
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Post Content', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'elementor' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-post-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$html_format = apply_filters( 'rxta-dynamic-title-html', '<%1$s %2$s>%3$s</%1$s>' );
		$html = sprintf( $html_format, $settings['tag'], '%1$s','%2$s' );
		$length = ( ! $settings['cut_content'] ) ? -1 : $settings['length'] ;

		$this->__context = 'render';
		$this->__open_wrap( 'elementor-post-content rxta-dynamic-title' );

		if ( rx_theme_assistant_tools()->is_edit_mode() ) {
			$demo_text = rx_theme_assistant_post_tools()->cut_text(
				'This widget displays the content of posts, pages, products. On a lot of content - Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
				$length,
				'word',
				$settings['ending'],
				false
			);
			printf( $html, '', $demo_text );
		} else {
			rx_theme_assistant_post_tools()->get_post_content( array(
				'html'         => $html,
				'content_type' => $settings['content_type'],
				'length'       => $length,
				'ending'       => $settings['ending'],
				'echo'         => true,
			) );
		}

		$this->__close_wrap();
	}
}
