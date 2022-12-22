<?php
/**
 * Class: Rx_Theme_Assistant_Dynamic_Posts
 * Name: Dynamic Posts
 * Slug: rx-theme-assistant-dynamic-posts
 */

namespace Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rx_Theme_Assistant_Dynamic_Posts extends Rx_Theme_Assistant_Base {

	public static $loop = false;

	public function get_name() {
		return 'rx-theme-assistant-dynamic-posts';
	}

	public function get_title() {
		return esc_html__( 'Dynamic Posts', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-info-box';
	}

	public function get_categories() {
		return array( 'rx-dynamic-posts' );
	}

	public function get_script_depends() {
		return array( 'jquery-slick' );
	}

	protected function register_controls() {
		$custom_query_link = sprintf(
			'<a href="https://crocoblock.com/wp-query-generator/" target="_blank">%s</a>',
			esc_html__( 'Generate custom query', 'rx-theme-assistant' )
		);
		$elemento_template = esc_html__( 'If you want to change or add a new template, go to the tab "Elementor Templates -> Saved Templates" in admin panel', 'rx-theme-assistant' );

		$css_scheme = apply_filters(
			'rx-theme-assistant/rxta-dynamic-posts/css-scheme',
			array(
				'wrap'          => '.rxta-dynamic-posts .rxta-dynamic-posts__items',
				'carousel-wrap' => '.rxta-dynamic-posts .rx-theme-assistant-carousel .slick-list',
				'column'        => '.rxta-dynamic-posts .rxta-dynamic-posts__item',
				'inner-box'     => '.rxta-dynamic-posts .rxta-dynamic-posts__inner',
			)
		);
		$post_type_options = rx_theme_assistant_tools()->get_post_types();

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content type', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'post_type',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Post type', 'rx-theme-assistant' ),
				'default'   => 'post',
				'options'   => $post_type_options,
				'condition' => array(
					'use_custom_query!'    => 'true',
				),
			)
		);

		$this->add_control(
			'posts_query',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'      => esc_html__( 'Query post by', 'rx-theme-assistant' ),
				'default'    => 'latest',
				'options'    => array(
					'latest'      => esc_html__( 'All', 'rx-theme-assistant' ),
					'slug'        => esc_html__( 'Select posts', 'rx-theme-assistant' ),
					'by_taxonomy' => esc_html__( 'By taxonomy', 'rx-theme-assistant' ),
				),
				'condition' => array(
					'use_custom_query!'    => 'true',
				),
			)
		);

		foreach ( $post_type_options as $key => $value ) {

			$taxonomies = get_taxonomies( [ 'object_type' => [ $key ] ], 'objects' );
			unset( $taxonomies['post_format'] );

			if( is_array( $taxonomies ) && ! empty( $taxonomies ) ){
				$taxonomies_option = array();

				foreach ( $taxonomies as $taxonomi ) {
					if( empty( $taxonomies_option ) ){
						$default_options = $taxonomi->name;
					}
					$taxonomies_option[ $taxonomi->name ] = $taxonomi->label;
				}

				$this->add_control(
					$key . '_taxonomy',
					array(
						'type'      => Controls_Manager::SELECT,
						'label'     => esc_html__( 'Select taxonomy from', 'rx-theme-assistant' ),
						'default'   => $default_options,
						'options'   => $taxonomies_option,
						'condition' => array(
							'use_custom_query!' => 'true',
							'post_type'         => $key,
							'posts_query'       => 'by_taxonomy',
						),
					)
				);

				foreach ( $taxonomies_option as $taxonomi_slug => $taxonomi_name ) {
					$this->add_control(
						$taxonomi_slug,
						array(
							'type'      => Controls_Manager::SELECT2,
							'label'      => $taxonomi_name,
							'default'    => '',
							'multiple'   => true,
							'options'    => rx_theme_assistant_tools()->get_terms_array( array( $taxonomi_slug ) ),
							'condition' => array(
								'use_custom_query!' => 'true',
								'posts_query'       => 'by_taxonomy',
								$key . '_taxonomy'  => $taxonomi_slug,
								'post_type'         => $key,
							),
						)
					);
				}

			} else {
				$this->add_control(
					$key . '_notice',
					array(
						'type' => Controls_Manager::RAW_HTML,
						'raw' => sprintf( '<b style="color:#ff7777;">%s</b>', esc_html__( 'Attention! Do not have a taxonomy.', 'rx-theme-assistant' ) ),
						'condition' => array(
							'use_custom_query!' => 'true',
							'post_type'         => $key,
							'posts_query'       => 'by_taxonomy',
						),
					)
				);
			}
		}

		foreach ( $post_type_options as $key => $value) {
			$this->add_control(
				$key . '_slug',
				array(
					'type'      => Controls_Manager::SELECT2,
					'label'     => esc_html__( 'Select ', 'rx-theme-assistant' ) . $value,
					'default'   => '',
					'multiple'  => true,
					'options'   => rx_theme_assistant_tools()->get_post_by_type( $key ),
					'condition' => array(
						'use_custom_query!' => 'true',
						'posts_query'       => 'slug',
						'post_type'         => $key,
					),
				)
			);
		}

		$this->add_control(
			'posts_number',
			array(
				'label'     => esc_html__( 'Post number', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'min'       => -1,
				'max'       => 30,
				'step'      => 1,
				'condition' => array(
					'use_custom_query!' => 'true',
					'posts_query!'      => 'slug',
				),
			)
		);

		$this->add_control(
			'ignore_sticky_posts',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Ignore Sticky Posts', 'rx-theme-assistant' ),
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => '',
				'condition' => array(
					'use_custom_query!' => 'true',
					'posts_query!'      => 'slug',
				),
			)
		);

		$this->add_control(
			'use_custom_query_hr',
			array(
				'type' => Controls_Manager::DIVIDER,
				'condition' => array(
					'use_custom_query!' => 'true'
				),
			)
		);

		$this->add_control(
			'use_custom_query_heading',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Custom query', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'use_custom_query',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Use custom query', 'rx-theme-assistant' ),
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => '',
			]
		);

		$this->add_control(
			'type_custom_query',
			[
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Select', 'rx-theme-assistant' ),
				'default'   => 'custom_query',
				'options'   => [
					'custom_query'    => esc_html__( 'Custom query', 'rx-theme-assistant' ),
					'custom_function' => esc_html__( 'Custom function', 'rx-theme-assistant' ),
				],
				'condition' => [
					'use_custom_query' => 'true',
				],
			]
		);

		$this->add_control(
			'custom_function',
			[
				'type'      => Controls_Manager::TEXT,
				'label'       => esc_html__( 'Custom function name', 'rx-theme-assistant' ),
				'default'     => '',
				'description' => sprintf('%s <br>%s', esc_html__( 'The function should return an array of request', 'rx-theme-assistant' ), $custom_query_link),
				'condition'   => array(
					'use_custom_query'  => 'true',
					'type_custom_query' => 'custom_function',
				),
			]
		);
		$this->add_control(
			'custom_query',
			[
				'type'      => Controls_Manager::TEXTAREA,
				'label'       => esc_html__( 'Set custom query', 'rx-theme-assistant' ),
				'default'     => '',
				'description' => $custom_query_link,
				'condition'   => array(
					'use_custom_query'  => 'true',
					'type_custom_query' => 'custom_query',
				),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout',
			array(
				'label' => esc_html__( 'Layout settings', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'items_template',
			array(
				'label'       => esc_html__( 'Items template', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'description' => $elemento_template,
				'options'     => $this->get_template_list(),
			)
		);

		$this->add_control(
			'layout_type',
			array(
				'label'   => esc_html__( 'Layout type', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => array(
					'grid'            => esc_html__( 'Grid', 'rx-theme-assistant' ),
					'list'            => esc_html__( 'List', 'rx-theme-assistant' ),
					'carousel'        => esc_html__( 'Carousel', 'rx-theme-assistant' ),
					//'masonry'         => esc_html__( 'Masonry', 'rx-theme-assistant' ),
					//'justify'         => esc_html__( 'Justify', 'rx-theme-assistant' ),
					//'horizontal-list' => esc_html__( 'Horizontal List', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'   => esc_html__( 'Columns', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '3',
				'options' => rx_theme_assistant_tools()->get_select_range( 6 ),
				'condition' => array(
					'layout_type' => array( /*'masonry',*/ 'grid' ),
				),
			)
		);

		$this->add_control(
			'navigation',
			array(
				'label'   => esc_html__( 'Navigation', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'disabled',
				'options' => [
					'disabled' => esc_html__( 'Disabled', 'rx-theme-assistant' ),
					'navigation' => esc_html__( 'Navigation', 'rx-theme-assistant' ),
					'pagination' => esc_html__( 'Pagination', 'rx-theme-assistant' ),
					//'infinite_scroll' => esc_html__( 'Infinite Scroll', 'rx-theme-assistant' ),
				],
				'condition' => array(
					'use_custom_query!' => 'true',
					'post_type!'         => array( 'page' ),
					'layout_type' => array( 'grid', 'list' ),
				),
			)
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'carousel_settings',
			array(
				'label' => esc_html__( 'Carousel settings', 'rx-theme-assistant' ),
				'condition' => array(
					'layout_type' => 'carousel',
				),
			)
		);

		$this->add_control(
			'carousel_layout_settings',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Layout settings', 'rx-theme-assistant' ),
			)
		);

		$this->add_responsive_control(
			'slides_to_show',
			array(
				'label'   => esc_html__( 'Slides to show', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '2',
				'options' => rx_theme_assistant_tools()->get_select_range( 10 ),
			)
		);

		$this->add_control(
			'slides_to_scroll',
			array(
				'label'     => esc_html__( 'Slides to scroll', 'rx-theme-assistant'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => rx_theme_assistant_tools()->get_select_range( 10 ),
				'condition' => array(
					'slides_to_show!' => '1',
				),
			)
		);

		$this->add_control(
			'carousel_navigation_settings',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Navigation settings', 'rx-theme-assistant' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'arrows',
			array(
				'label'        => esc_html__( 'Show arrows navigation', 'rx-theme-assistant' ),
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
				'label'   => esc_html__( 'Prev arrow icon', 'rx-theme-assistant' ),
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
				'label'   => esc_html__( 'Next arrow icon', 'rx-theme-assistant' ),
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
				'label'        => esc_html__( 'Show dots navigation', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => '',
			)
		);

		$this->add_control(
			'carousel_additional_settings',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Additional settings', 'rx-theme-assistant' ),
				'separator' => 'before',
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
			'pause_on_hover',
			array(
				'label'        => esc_html__( 'Pause on hover', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'false',
				'condition' => array(
					'autoplay' => 'true',
				),
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'     => esc_html__( 'Autoplay duration', 'rx-theme-assistant' ),
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
				'label'        => esc_html__( 'Infinite loop', 'rx-theme-assistant' ),
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
					'slides_to_show' => '1',
				),
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'   => esc_html__( 'Animation speed', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_column_style',
			array(
				'label'      => esc_html__( 'Column', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'column_padding',
			array(
				'label'       => esc_html__( 'Column padding', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px' ),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['column']        => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['carousel-wrap'] => 'margin-right: -{{RIGHT}}{{UNIT}}; margin-left: -{{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['wrap']          => 'margin-right: -{{RIGHT}}{{UNIT}}; margin-left: -{{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			array(
				'label'      => esc_html__( 'Post item', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'equal_height_cols',
			array(
				'label'        => esc_html__( 'Equal Columns Height', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
				'condition' => array(
					'layout_type' => array( 'grid', 'carousel' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_overlay',
				'selector' => '{{WRAPPER}} ' . $css_scheme['inner-box'],
			]
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
				'label'      => __( 'Border radius', 'rx-theme-assistant' ),
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
			'section_arrows_style',
			array(
				'label'      => esc_html__( 'Carousel arrows', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition' => array(
					'layout_type' => 'carousel',
				),
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
				'label'          => esc_html__( 'Arrows style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-arrow',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
				),
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
				'label'          => esc_html__( 'Arrows style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-arrow:hover',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prev_arrow_position',
			array(
				'label'     => esc_html__( 'Prev arrow position', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prev_vert_position',
			array(
				'label'   => esc_html__( 'Vertical postition by', 'rx-theme-assistant' ),
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
				'label'      => esc_html__( 'Top indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-arrow.prev-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'prev_bottom_position',
			array(
				'label'      => esc_html__( 'Bottom indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-arrow.prev-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				),
			)
		);

		$this->add_control(
			'prev_hor_position',
			array(
				'label'   => esc_html__( 'Horizontal postition by', 'rx-theme-assistant' ),
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
				'label'      => esc_html__( 'Left indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-arrow.prev-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'prev_right_position',
			array(
				'label'      => esc_html__( 'Right indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-arrow.prev-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			)
		);

		$this->add_control(
			'next_arrow_position',
			array(
				'label'     => esc_html__( 'Next arrow position', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'next_vert_position',
			array(
				'label'   => esc_html__( 'Vertical postition by', 'rx-theme-assistant' ),
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
				'label'      => esc_html__( 'Top indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-arrow.next-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'next_bottom_position',
			array(
				'label'      => esc_html__( 'Bottom indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-arrow.next-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				),
			)
		);

		$this->add_control(
			'next_hor_position',
			array(
				'label'   => esc_html__( 'Horizontal postition by', 'rx-theme-assistant' ),
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
				'label'      => esc_html__( 'Left indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-arrow.next-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'next_right_position',
			array(
				'label'      => esc_html__( 'Right indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-arrow.next-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dots_style',
			array(
				'label'      => esc_html__( 'Carousel dots', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition' => array(
					'layout_type' => 'carousel',
				),
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
				'label'          => esc_html__( 'Dots style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-slick-dots li span',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_3,
						),
					),
				),
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
				'label'          => esc_html__( 'Dots style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-slick-dots li span:hover',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
				),
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
				'label'          => esc_html__( 'Dots style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-slick-dots li.slick-active span',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						),
					),
				),
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
					'{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-slick-dots li' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'dots_margin',
			array(
				'label'      => esc_html__( 'Dots box margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-slick-dots' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .rxta-dynamic-posts__layout-carousel .rx-theme-assistant-slick-dots' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'navigation_style',
			array(
				'label'      => esc_html__( 'Navigation', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition' => array(
					'navigation!' => 'disabled',
				),
			)
		);

		$this->add_control(
			'navigation_link_heading',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Navigation Links', 'rx-theme-assistant' ),
				'separator' => 'after',
			)
		);

		$this->add_control(
			'navigation_link_color',
			[
				'label' => esc_html__( 'Link Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .navigation .nav-previous a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .navigation .nav-next a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .navigation a.next.page-numbers' => 'color: {{VALUE}};',
					'{{WRAPPER}} .navigation a.prev.page-numbers' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'navigation_hover_link_color',
			[
				'label' => esc_html__( 'Hover Link Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .navigation .nav-previous a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .navigation .nav-next a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .navigation a.next.page-numbers:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .navigation a.prev.page-numbers:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'navigation_link_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .navigation .nav-previous a,
				{{WRAPPER}} .navigation .nav-next a,
				{{WRAPPER}} .navigation a.next.page-numbers,
				{{WRAPPER}} .navigation a.prev.page-numbers',
			]
		);

		$this->add_control(
			'navigation_page_numbers_heading',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Pages Numbers Buttons', 'rx-theme-assistant' ),
				'separator' => 'after',
				'condition' => array(
					'navigation' => 'pagination',
				),
			)
		);

		$this->add_control(
			'navigation_alignment',
			[
				'label' => __( 'Navigation Alignment', 'plugin-domain' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'plugin-domain' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'plugin-domain' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'plugin-domain' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .navigation .nav-links' => 'display: flex; align-self: {{VALUE}};',
					'{{WRAPPER}} .navigation .nav-links' => 'display: flex; justify-content: {{VALUE}};',
				],
				'condition' => array(
					'navigation' => 'pagination',
				),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'navigation_buttons_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .navigation a.page-numbers:not(.prev):not(.next):not(.dots)',
				'condition' => array(
					'navigation' => 'pagination',
				),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'navigation_buttons_border',
				'selector' => '{{WRAPPER}} .navigation .nav-links a.page-numbers:not(.prev):not(.next):not(.dots), {{WRAPPER}} .navigation span.page-numbers.current:not(.prev):not(.next):not(.dots)',
			]
		);

		$this->add_responsive_control(
			'navigation_buttons_radius',
			[
				'label' => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .navigation a.page-numbers:not(.prev):not(.next):not(.dots)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .navigation span.page-numbers.current:not(.prev):not(.next):not(.dots)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation_buttons_border_border!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'navigation_buttons',
			array(
				'condition' => array(
					'navigation' => 'pagination',
				),
			)
		);

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'rx-theme-assistant' ) ] );

		$this->add_control(
			'navigation_button_color',
			[
				'label' => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .navigation a.page-numbers:not(.prev):not(.next):not(.dots)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'navigation_button_bg',
			[
				'label' => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .navigation a.page-numbers:not(.prev):not(.next):not(.dots)' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'navigation_button_border_color',
			[
				'label' => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .navigation a.page-numbers:not(.prev):not(.next):not(.dots)' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover', [ 'label' => esc_html__( 'Hover', 'rx-theme-assistant' ) ] );

		$this->add_control(
			'navigation_button_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .navigation a.page-numbers:not(.prev):not(.next):not(.dots):hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'navigation_button_hover_bg',
			[
				'label' => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .navigation a.page-numbers:not(.prev):not(.next):not(.dots):hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'navigation_button_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .navigation a.page-numbers:not(.prev):not(.next):not(.dots):hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'active', [ 'label' => esc_html__( 'active', 'rx-theme-assistant' ) ] );

		$this->add_control(
			'navigation_button_active_color',
			[
				'label' => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .navigation a.page-numbers:not(.prev):not(.next):not(.dots):active' => 'color: {{VALUE}};',
					'{{WRAPPER}} .navigation span.page-numbers.current:not(.prev):not(.next):not(.dots)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'navigation_button_active_bg',
			[
				'label' => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .navigation a.page-numbers:not(.prev):not(.next):not(.dots):active' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .navigation span.page-numbers.current:not(.prev):not(.next):not(.dots)' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'navigation_button_border_active_color',
			[
				'label' => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .navigation a.page-numbers:not(.prev):not(.next):not(.dots):active' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .navigation span.page-numbers.current:not(.prev):not(.next):not(.dots)' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Get elementor template list.
	 *
	 * @return array
	 */
	public function get_template_list() {
		$result_list = array();
		$templates = Plugin::$instance->templates_manager->get_source( 'local' )->get_items();

		if ( $templates ) {
			foreach ( $templates as $template ) {
				$result_list[ $template['template_id'] ] = $template['title'];
			}
		}

		return $result_list;
	}

	/**
	 * Get default query args
	 *
	 * @return array
	 */
	public function get_default_query_args() {
		$post_type = $this->get_settings_for_display( 'post_type' );
		$paged = isset( $GLOBALS['wp_query']->query['paged'] ) ? $GLOBALS['wp_query']->query['paged'] : get_query_var( 'paged' ) ;
		$posts_number = $this->get_settings_for_display( 'posts_number' );
		$query_args = array(
			'post_status'         => 'publish',
			'post_type'           => $post_type ? $post_type : 'post' ,
			'ignore_sticky_posts' => $this->get_settings_for_display( 'ignore_sticky_posts' ),
			'posts_per_page'      => $posts_number ? intval( $posts_number ) : -1 ,
			'paged'               => $paged ? absint( $paged ) : 1 ,
		);

		switch ( $this->get_settings_for_display( 'posts_query' ) ) {
			case 'slug':

				$query_args['post_name__in'] = $this->get_settings_for_display( $post_type . '_slug' );

			break;

			case 'by_taxonomy':

				$query_args = array_merge( $query_args, $this->get_taxonomy_query_args() );

			break;

			case 'latest' && rx_theme_assistant_tools()->is_blog() && ! rx_theme_assistant_tools()->is_edit_mode() :
				global $wp_query;
				$query_args['posts_per_page'] = get_option('posts_per_page');
				$query_args = wp_parse_args( $query_args, $wp_query->query_vars );
			break;

		}

		return $query_args;

	}

	/**
	 * Get taxonomy query arguments
	 *
	 * @return [type] [description]
	 */
	public function get_taxonomy_query_args() {
		$args = array();
		$post_type    = $this->get_settings_for_display( 'post_type' );
		$terms_key  = $this->get_settings_for_display( $post_type . '_taxonomy' );
		$terms  = $this->get_settings_for_display( $terms_key );

		if ( ! empty( $terms ) && is_array( $terms ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => $terms_key,
					'field'    => 'slug',
					'terms'    => $terms,
					'operator' => 'IN',
				),
			);
		}

		return $args;
	}

	/**
	 * Get custom query args
	 *
	 * @return array
	 */
	public function get_custom_query_args() {
		$query_source = $this->get_settings_for_display( 'type_custom_query' );

		if( 'custom_function' === $query_source ){
			$custom_function = $this->get_settings_for_display( $query_source );
			$query_args = call_user_func( $custom_function );
		}else{
			$query_args = $this->get_settings_for_display( $query_source );
			$query_args = json_decode( $query_args, true );
		}

		if ( ! $query_args ) {
			$query_args = array();
		}

		return $query_args;
	}

	/**
	 * Query posts by attributes
	 *
	 * @return object
	 */
	public function query() {
		if ( 'true' === $this->get_settings_for_display( 'use_custom_query' ) ) {
			$query_args = $this->get_custom_query_args();
		} else {
			$query_args = $this->get_default_query_args();
		}

		$query = new \WP_Query( $query_args );

		return $query;
	}

	/**
	 * [no_templates_message description]
	 * @return [type] [description]
	 */
	public function no_templates_message() {
		$message = '<span>' . esc_html__( 'Template is not defined. ', 'rx-theme-assistant' ) . '</span>';

		$link = add_query_arg(
			array(
				'post_type'     => 'elementor_library',
				'action'        => 'elementor_new_post',
				'_wpnonce'      => wp_create_nonce( 'elementor_action_new_post' ),
				'template_type' => 'section',
			),
			esc_url( admin_url( '/edit.php' ) )
		);

		$new_link = '<span>' . esc_html__( 'Select an existing template or create a ', 'rx-theme-assistant' ) . '</span><a class="rx-theme-assistant-tabs-new-template-link elementor-clickable" target="_blank" href="' . $link . '">' . esc_html__( 'new one', 'rx-theme-assistant' ) . '</a>' ;

		return sprintf(
			'<div class="rx-theme-assistant-tabs-no-template-message">%1$s%2$s</div>',
			$message,
			rx_theme_assistant_tools()->in_elementor() ? $new_link : ''
		);
	}

	public function get_carousel_options() {

		$settings = $this->get_settings();
		$options  = array(
			'slidesToShow'   => array(
				'desktop' => absint( $settings['slides_to_show'] ),
				'tablet'  => absint( $settings['slides_to_show_tablet'] ),
				'mobile'  => absint( $settings['slides_to_show_mobile'] ),
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
		);

		if ( 1 === absint( $settings['slides_to_show'] ) ) {
			$options['fade'] = ( 'fade' === $settings['effect'] );
		}

		return $options;
	}

	public function get_post_navigation( $query, $settings ) {
		if( $settings['navigation'] && 'disabled' !== $settings['navigation']){
			$big = 999999999;

			$args = array(
				'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'  => '?paged=%#%',
				'current' => max( 1, $query->query['paged'] ),
				'total' => $query->max_num_pages,
			);

			$GLOBALS['wp_query']->max_num_pages = $query->max_num_pages;

			if( rx_theme_assistant_tools()->is_edit_mode() ){
				$GLOBALS['wp_query']->is_single = false;
			}

			switch ( $settings['navigation'] ) {
				case 'navigation':
					include $this->__get_global_template( 'navigation' );
					break;
				case 'pagination':
					include $this->__get_global_template( 'pagination' );
					break;
			}
		}
	}

	protected function render() {
		$this->__context = 'render';

		$query = $this->query();

		if ( ! $query->have_posts() ) {
			include $this->__get_global_template( 'not-found' );
			return;
		}

		$items_template = $this->get_settings_for_display( 'items_template' );
		if ( ! $items_template ) {
			include $this->__get_global_template( 'not-choose-template' );
			return;
		}

		$this->__open_wrap();

		self::$loop = true;

		include $this->__get_global_template( 'index' );

		self::$loop = false;

		$this->__close_wrap();
	}
}
