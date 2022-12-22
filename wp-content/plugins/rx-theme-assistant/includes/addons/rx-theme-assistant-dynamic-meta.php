<?php
/**
 * Class: Rx_Theme_Assistant_Dynamic_Meta
 * Name: Page & Post Meta
 * Slug: rx-theme-assistant-dynamic-meta
 */

namespace Elementor;

use Elementor\Core\Files\Assets\Svg\Svg_Handler;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rx_Theme_Assistant_Dynamic_Meta extends Rx_Theme_Assistant_Base {

	public function get_name() {
		return 'rx-theme-assistant-dynamic-meta';
	}

	public function get_title() {
		return esc_html__( 'Page & Post Meta', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-meta-data';
	}

	public function get_categories() {
		return array( 'rx-dynamic-posts' );
	}

	protected function register_controls() {

		$meta_type_options = array(
			'author'        => esc_html__( 'Author', 'rx-theme-assistant' ),
			'date'          => esc_html__( 'Public Date', 'rx-theme-assistant' ),
			'comment_count' => esc_html__( 'Comment Count', 'rx-theme-assistant' ),
			'category'      => esc_html__( 'Category', 'rx-theme-assistant' ),
			'tags'          => esc_html__( 'Tags', 'rx-theme-assistant' ),
			'custom_meta'   => esc_html__( 'Custom Meta', 'rx-theme-assistant' ),
		);

		if ( class_exists( 'ACF' ) ) {
			$meta_type_options['acf_custom_meta'] = esc_html__( 'ACF Custom Meta', 'rx-theme-assistant' );
		}

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'meta_type',
			array(
				'label'   => esc_html__( 'Type meta', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $meta_type_options,
				'default' => 'author',
			)
		);

		$this->add_control(
			'field_type_hr',
			array(
				'type' => Controls_Manager::DIVIDER,
				'condition' => [
					'meta_type!' => array( 'author', 'comment_count' ),
				],
			)
		);

		$this->add_control(
			'date_format',
			[
				'label' => esc_html__( 'Date format', 'rx-theme-assistant' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'F j, Y',
				'condition' => [
					'meta_type' => 'date',
				],
				'description' => sprintf( '<a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank">%s</a>', esc_html__( 'Documentation on date and time formatting', 'rx-theme-assistant' ) ),
			]
		);

		$this->add_control(
			'devide',
			[
				'label' => esc_html__( 'Devide', 'rx-theme-assistant' ),
				'type' => Controls_Manager::TEXT,
				'default' => ', ',
				'condition' => [
					'meta_type' => [ 'category', 'tags' ],
				],
			]
		);

		$this->add_control(
			'custom_meta_key',
			[
				'label' => esc_html__( 'Key', 'rx-theme-assistant' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => esc_html__( 'Meta key from postmeta table in database', 'rx-theme-assistant' ),
				'condition' => [
					'meta_type' => ['custom_meta', 'acf_custom_meta'],
				],
			]
		);

		$this->add_control(
			'field_type',
			array(
				'label'   => esc_html__( 'Field type', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'text'        => esc_html__( 'Text', 'rx-theme-assistant' ),
					'date'        => esc_html__( 'Date', 'rx-theme-assistant' ),
					'image'       => esc_html__( 'Image', 'rx-theme-assistant' ),
					'embeds_link' => esc_html__( 'Embeds link', 'rx-theme-assistant' ),
				),
				'default' => 'text',
				'condition' => [
					'meta_type' => ['custom_meta' ],
				],
			)
		);

		if ( class_exists( 'ACF' ) ) {
			$this->add_control(
				'acf_meta_format',
				[
					'type'        => Controls_Manager::TEXTAREA,
					'label'       => esc_html__( 'Meta HTML format', 'rx-theme-assistant' ),
					'description' => esc_html__( 'In this field, you can use HTML tags and the %s symbol which displays the value of the field. If you use a group of fields, we can use the symbols %1$s, %2$s, %3$s and more to display several values', 'rx-theme-assistant' ),
					'rows'        => '3',
					'default'     => '%s',
					'condition' => [
						'meta_type' => [ 'acf_custom_meta' ],
					],
				]
			);
		}

		$this->add_responsive_control(
			'object_link_width',
			array(
				'label'      => esc_html__( 'Width', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 1000,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array(
					'size' => 80,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .rxta-dynamic-custom-meta' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'meta_type' => 'custom_meta',
					'field_type' => array( 'embeds_link', 'image' ),
				),
			)
		);

		$this->add_responsive_control(
			'object_link_height',
			array(
				'label'      => esc_html__( 'Height ( px )', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 200,
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 1000,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .rxta-dynamic-custom-meta' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'meta_type' => 'custom_meta',
					'field_type' => array( 'embeds_link', 'image' ),
				),
			)
		);

		$this->add_control(
			'devide_hr',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'icon_type',
			[
				'label' => esc_html__( 'Icon type', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__( 'none', 'rx-theme-assistant' ),
					'icon' => esc_html__( 'Icon', 'rx-theme-assistant' ),
					'image' => esc_html__( 'Image', 'rx-theme-assistant' ),
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'rx-theme-assistant' ),
				'type' => Controls_Manager::ICONS,
				'default' => [],
				'label_block' => true,
				'condition' => [
					'icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose image', 'elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->add_control(
			'content_format',
			[
				'label' => esc_html__( 'Content format', 'rx-theme-assistant' ),
				'type' => Controls_Manager::TEXT,
				'default' => '{{ICON}} {{VALUE}}',
				'description' => esc_html__( 'Data format works with macros {{ICON}} - Displays the icon {{VALUE}} - Displays the meta field value<br>HTML tags are also allowed.', 'rx-theme-assistant' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Meta Data Style', 'rx-theme-assistant' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align',
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .rxta-dynamic-meta' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .rxta-dynamic-meta' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'label_settings',
			[
				'label' => esc_html__( 'Label Settings', 'plugin-name' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => esc_html__( 'Text Typography', 'rx-theme-assistant' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rxta-dynamic-meta',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}}' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'link_typography',
				'label' => esc_html__( 'Link Typography', 'rx-theme-assistant' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rxta-dynamic-meta a',
			]
		);

		$this->start_controls_tabs( 'text_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			]
		);

		$this->add_control(
			'link_color',
			[
				'label' => esc_html__( 'Link Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .rxta-dynamic-meta a' => 'color: {{VALUE}};',
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
			'link_hover_color',
			[
				'label' => esc_html__( 'Link Hover Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .rxta-dynamic-meta a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'label_margin',
			array(
				'label'      => esc_html__( 'Label Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rxta-dynamic-meta a'=> 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);
		$this->add_responsive_control(
			'label_padding',
			array(
				'label'      => esc_html__( 'Label Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rxta-dynamic-meta a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'label_border',
				'label'       => esc_html__( 'Label Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .rxta-dynamic-meta a',
			)
		);

		$this->add_responsive_control(
			'label__radius',
			array(
				'label'      => esc_html__( 'Border radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rxta-dynamic-meta a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_settings',
			[
				'label' => esc_html__( 'Icon Settings', 'plugin-name' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'icon_type' => [ 'image', 'icon' ],
				],
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' => esc_html__( 'Image Icon Width', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rxta-dynamic-meta img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->add_responsive_control(
			'icon_width',
			[
				'label' => esc_html__( 'Icon Width', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rxta-dynamic-meta svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
					'{{WRAPPER}} .rxta-dynamic-meta i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .rxta-dynamic-meta i' => 'color: {{VALUE}};',
				],
				'condition' => [
					'icon_type' => 'icon',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$data     = array(
			'icon' => $this->get_frontend_icon( $settings ),
			'value' => ''
		);
		$terms_before = apply_filters( 'rxta-dynamic-meta-terms-before', '<span class="post-terms">' );
		$terms_after = apply_filters( 'rxta-dynamic-meta-terms-after', '</span>' );

		switch ( $settings['meta_type'] ) {
			case 'author':
				$data[ 'value' ] = rx_theme_assistant_post_tools()->get_post_author( array(
					'html' => apply_filters( 'rxta-dynamic-meta-post-author', '%1$s<a href="%2$s" %3$s %4$s rel="author">%5$s%6$s</a>' ),
				) );

				break;

			case 'date':
				$data[ 'value' ] = rx_theme_assistant_post_tools()->get_post_date( array(
					'html'        => apply_filters( 'rxta-dynamic-meta-post-date', '%1$s<a href="%2$s" %3$s %4$s ><time datetime="%5$s" title="%5$s">%6$s%7$s</time></a>' ),
					'date_format' => $settings['date_format'],
				) );

				break;

			case 'comment_count':
				if ( rx_theme_assistant_tools()->is_edit_mode() ) {
					$data[ 'value' ] = '<a href="#">0</a>';
				} else {
					$data[ 'value' ] = rx_theme_assistant_post_tools()->get_post_comment_count( array(
						'html' => apply_filters( 'rxta-dynamic-meta-comment-count', '%1$s<a href="%2$s" %3$s %4$s>%5$s%6$s</a>' ),
					) );
				}

				break;

			case 'category':
				if ( rx_theme_assistant_tools()->is_edit_mode() ) {
					$data[ 'value' ] = sprintf( '%1$s%3$s%2$s', $terms_before, $terms_after, implode( $settings['devide'], array( '<a href="#">category 1</a>','<a href="#">category 2</a>','<a href="#">category 3</a>' ) ) );
				} else {
					$data[ 'value' ] = rx_theme_assistant_post_tools()->get_terms( array(
						'type'		=> 'category',
						'delimiter'	=> $settings['devide'],
						'before'	=> $terms_before,
						'after'		=> $terms_after,
					) );
				}

				break;

			case 'tags':
				if ( rx_theme_assistant_tools()->is_edit_mode() ) {
					$data[ 'value' ] = sprintf( '%1$s%3$s%2$s', $terms_before, $terms_after, implode( $settings['devide'], array( '<a href="#">tags 1</a>','<a href="#">tags 2</a>','<a href="#">tags 3</a>' ) ) );
				} else {
					$data[ 'value' ] = rx_theme_assistant_post_tools()->get_terms( array(
						'type'		=> 'post_tag',
						'delimiter'	=> $settings['devide'],
						'before'	=> $terms_before,
						'after'		=> $terms_after,
					) );
				}

				break;

			case 'custom_meta' || 'acf_custom_meta':
				if( ! $settings[ 'custom_meta_key' ] ){
					break;
				}

				$data[ 'value' ] = $this->get_field_type( $settings );
			break;
		}

		if( ! $data['value'] ) {
			$this->add_render_attribute( '_wrapper', 'class', [ 'rxta-dynamic-meta-empty' ] );
		}

		$this->__context = 'render';
		$this->__open_wrap( 'rxta-dynamic-meta entry-meta' );

		echo $this->render_format( $settings['content_format'], $data ) ;

		$this->__close_wrap();
	}

	public function get_field_type( $args ) {
		$meta_class = '';

		if( rx_theme_assistant_tools()->is_edit_mode() ){
			$post_meta_value = esc_html__( 'Custom Meta', 'rx-theme-assistant' );
			$field_format = apply_filters(
				'rx-theme-assistant/dynamic-posts/custom-field-text',
				'<div class="%1$s rxta-dynamic-custom-meta rxta-dynamic-custom-meta__field-default">%2$s</div>'
			);
			return sprintf( $field_format, $meta_class, $post_meta_value );
		}

		switch ( $args[ 'field_type' ] ) {
			case 'text':
				$field_format = apply_filters(
					'rx-theme-assistant/dynamic-posts/custom-field-text',
					'<div class="%1$s rxta-dynamic-custom-meta rxta-dynamic-custom-meta__field-text">%2$s</div>'
				);
				break;

			case 'date':
				$field_format = apply_filters(
					'rx-theme-assistant/dynamic-posts/custom-field-date',
					'<time class="%1$s rxta-dynamic-custom-meta rxta-dynamic-custom-meta__field-date" datetime="%2$s">%2$s</time>'
				);
				break;

			case 'image':
				$field_format = apply_filters(
					'rx-theme-assistant/dynamic-posts/custom-field-image',
					'<img class="%1$s rxta-dynamic-custom-meta rxta-dynamic-custom-meta__field-image" src="%2$s" alt="rx-field-image">'
				);

				break;

			case 'embeds_link':
				$field_format = apply_filters(
					'rx-theme-assistant/dynamic-posts/custom-field-embeds-link',
					'<div class="%1$s rxta-dynamic-custom-meta rxta-dynamic-custom-meta__field-embeds-link">%2$s</div>'
				);

				$post_meta_value = wp_oembed_get( $post_meta_value );

				break;

			default:
				$field_format = apply_filters(
					'rx-theme-assistant/dynamic-posts/custom-field-default',
					'<div class="%1$s rxta-dynamic-custom-meta rxta-dynamic-custom-meta__field-default">%2$s</div>'
				);
			break;
		}

		if ( class_exists( 'ACF' ) && 'acf_custom_meta' == $args[ 'meta_type' ] ) {
			$field_object = get_field_object( $args[ 'custom_meta_key' ] );
			$meta_class .= 'rxta-dynamic-custom-acf-field ' . $field_object['class'];
			$post_meta_value = $this->get_acf_field_value( $field_object, $args );
		}else{
			$post_meta_value = get_post_meta( get_the_ID(), $args[ 'custom_meta_key' ], false );
			$post_meta_value = ! empty( $post_meta_value ) ? $post_meta_value[0] : '' ;
		}

		if( empty( $post_meta_value ) ){
			return '';
		}

		return sprintf( $field_format, $meta_class, $post_meta_value );
	}

	public function get_acf_field_value( $field, $args ) {
		$output = '';
		$format = $args['acf_meta_format'];

		if( ! $field || ! $field['value'] ){
			return '';
		}

		switch ( $field['type'] ) {
			case 'repeater' :
				if ( is_array( $field['value'] ) ) {
					foreach ( $field['value'] as $key => $value ) {
						$output .= @vsprintf( $format, $value );
					}
				}
			break;

			case 'group':
				if ( is_array( $field['value'] ) ) {
					$output = @vsprintf( $format, $field['value'] );
				}
			break;

			case 'post_object':
				$output = $this->parse_post_object( $field['value'], $format );
			break;

			default:
				$output = sprintf( $format, $field['value'] );
			break;
		}

		if( ! $output && '' !== $output ){
			$output = esc_html__( 'Sorry, but the value for the "Meta HTML format" field was entered incorrectly.', 'rx-theme-assistant' );
		}

		return $output;
	}

	public function parse_post_object( $post_object, $format ) {
		$output = $format;
		$post_meta = get_post_meta( $post_object->ID );

		preg_match_all( "/%%[A-Za-z0-9-]+%%/im", $format, $matches );

		if( empty( $matches[0] ) || empty( $post_meta ) ){
			return '';
		}

		foreach ( $matches[0] as $shortcode ) {
			switch ( $shortcode ) {
				case '%%thumbnail%%':
					$meta_value = get_the_post_thumbnail( $post_object->ID, 'full' );
					break;
				case '%%title%%':
					$meta_value = get_the_title( $post_object->ID );
					break;
				default:
					$meta_key = str_replace( '%', '', $shortcode );
					$meta_value = isset( $post_meta[ $meta_key ] ) ? $post_meta[ $meta_key ][0] : false ;
					break;
			}
			$meta_value = $meta_value ? $meta_value : '' ;
			$output = str_replace( $shortcode, $meta_value, $format );
		}

		return $output;
	}

	public function get_frontend_icon( $settings ) {
		if( empty( $settings[ 'icon' ] ) &&  empty( $settings[ 'icon' ]['value'] ) && empty( $settings[ 'image' ]['url'] )){
			return;
		}

		$output = '';
		$type = 'icon' === $settings[ 'icon_type' ] ? $settings[ 'icon' ]['library'] : 'image' ;

		switch ( $type ) {
			case 'image':
				$format = apply_filters( 'rxta-dynamic-meta-image', '<img class="rxta-dynamic-meta-icon" src="%1$s" alt="icon">' );
				$output = sprintf( $format, $settings[ 'image' ]['url'] );
			break;

			case 'svg':
				$output = Svg_Handler::get_inline_svg( $settings[ 'icon' ]['value']['id'] );
			break;

			default:
				$format = apply_filters( 'rxta-dynamic-meta-icon', '<i class="%1$s rxta-dynamic-meta-icon" aria-hidden="true"></i>' );
				$output = sprintf( $format, $settings[ 'icon' ]['value'] );
			break;

		}

		return $output;
	}

	/**
	 * Render meta format.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	public function render_format( $format = '{{ICON}} {{VALUE}}', $data = array() ) {
		$macros = [
			'value' => '{{VALUE}}',
			'icon' => '{{ICON}}',
		];

		if( empty( $data['value'] ) ){
			return;
		}
		foreach ( $macros as $key => $value ) {
			$format = str_replace( $value, $data[ $key ], $format );
			$output = str_replace( $value, $data[ $key ], $format );
		}

		return $output;
	}
}
