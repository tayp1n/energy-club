<?php
/**
 * Class: Rx_Theme_Assistant_Dynamic_Post_Image
 * Name: Page & Post Image
 * Slug: rx-theme-assistant-dynamic-post-image
 */

namespace Elementor;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rx_Theme_Assistant_Dynamic_Post_Image extends Rx_Theme_Assistant_Base {

	public function get_name() {
		return 'rx-theme-assistant-dynamic-post-image';
	}

	public function get_title() {
		return esc_html__( 'Page & Post Image', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-image';
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
			'show_placeholder',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Show Placeholder', 'rx-theme-assistant' ),
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'label_on',
			]
		);

		$this->add_control(
			'image_placeholder',
			[
				'label' => esc_html__( 'Choose Placeholder', 'rx-theme-assistant' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition'   => [
					'show_placeholder' => 'true',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
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
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_to',
			[
				'label' => esc_html__( 'Link', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'None', 'rx-theme-assistant' ),
					'file' => esc_html__( 'Media File', 'rx-theme-assistant' ),
					'post' => esc_html__( 'Post Link', 'rx-theme-assistant' ),
				],
			]
		);

		$this->add_control(
			'open_lightbox',
			[
				'label' => esc_html__( 'Lightbox', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'rx-theme-assistant' ),
					'yes' => esc_html__( 'Yes', 'rx-theme-assistant' ),
					'no' => esc_html__( 'No', 'rx-theme-assistant' ),
				],
				'condition' => [
					'link_to' => 'file',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Style Settings', 'rx-theme-assistant' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_style',
			[
				'label' => __( 'Image style', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rxta-dynamic-image-wrapper' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'max_width',
			[
				'label' => esc_html__( 'Max Width', 'rx-theme-assistant' ) . ' (%)',
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
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rxta-dynamic-image-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px', 'vw' ],
				'range' => [
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
					'{{WRAPPER}} .elementor-image img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_fill',
			[
				'label' => esc_html__( 'Image Fill', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'fill'       => esc_html__( 'fill', 'rx-theme-assistant' ),
					'none'       => esc_html__( 'None', 'rx-theme-assistant' ),
					'contain'    => esc_html__( 'contain', 'rx-theme-assistant' ),
					'cover'      => esc_html__( 'cover', 'rx-theme-assistant' ),
					'scale-down' => esc_html__( 'scale-down', 'rx-theme-assistant' ),
				],
				'default' => 'fill',
				'selectors' => [
					'{{WRAPPER}} .elementor-image img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_title',
			[
				'label' => __( 'Image border style', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .elementor-image img',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .elementor-image img',
			]
		);

		$this->add_control(
			'image_effects_title',
			[
				'label' => __( 'Image hover animation', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_overlay',
				'selector' => '{{WRAPPER}} .elementor-image .elementor-background-overlay',
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .elementor-image .rxta-dynamic-image-wrapper img',
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' => esc_html__( 'Opacity', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image .rxta-dynamic-image-wrapper img' => 'opacity: {{SIZE}};',
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
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image .rxta-dynamic-image-wrapper' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_overlay_hover',
				'selector' => '{{WRAPPER}} .elementor-image .rxta-dynamic-image-wrapper:hover .elementor-background-overlay',
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .elementor-image .rxta-dynamic-image-wrapper:hover img',
			]
		);

		$this->add_control(
			'image_opacity_hover',
			[
				'label' => esc_html__( 'Opacity', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image .rxta-dynamic-image-wrapper:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'icon_title',
			[
				'label' => __( 'Zoom icon style', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'rx-theme-assistant' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-search-plus',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'size',
			[
				'label' => esc_html__( 'Icon size', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SLIDER,
				//'default' => 25,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .elementor-image .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$output = '';
		$animation_class = ! empty( $settings['hover_animation'] ) ? 'elementor-animation-' . $settings['hover_animation'] : '' ;
		$placeholder_visible = ( $settings['show_placeholder'] && ! empty( $settings['image_placeholder']['id'] ) );
		$placeholder_src = '';
		$icon = $this->get_frontend_icon( $settings );

		if ( $settings['show_placeholder'] && ! empty( $settings['image_placeholder']['id'] ) ) {
			$placeholder_url = wp_get_attachment_image_src( $settings['image_placeholder']['id'], $settings['image_size'] );
			$placeholder_src = ! empty( $placeholder_url[0] ) ? $placeholder_url[0] : '' ;
		}
		$img_html = $icon;
		$img_html .= apply_filters( 'rxta-dynamic-image-html', '<div class="elementor-background-overlay"></div><img src="%3$s" %6$s %2$s alt="%4$s" %5$s>' );


		switch ( $settings['link_to'] ) {
			case 'file':
				$get_attachment_id = get_post_thumbnail_id();
				$href = $get_attachment_id ? wp_get_attachment_image_src( $get_attachment_id, 'full' ) : wp_get_attachment_image_src( $settings['image_placeholder']['id'], 'full' );
				$data = 'data-elementor-open-lightbox="' . $settings['open_lightbox'] . '"';

				$img_html = '<a href="' . $href[0] . '" ' . $data . '>' . $img_html . '</a>';
				break;

			case 'post':
				$img_html = '<a href="%1$s">' . $img_html . '</a>';
				break;
		}

		$image = rx_theme_assistant_post_tools()->get_post_image( array(
			'size'            => $settings['image_size'],
			'html'            => $img_html,
			'placeholder'     => $placeholder_visible,
			'placeholder_src' => $placeholder_src,
			'html_tag_suze'   => true,
		) );

		if ( $image ){
			$output = $image;
		} elseif ( ! $image && Plugin::$instance->editor->is_edit_mode() ) {
			$output = sprintf( '<img src="%s" class="%s">', Utils::get_placeholder_image_src(), $animation_class );
		}

		$this->__context = 'render';

		$this->__open_wrap( 'rxta-dynamic-image' );

		printf( apply_filters( 'rxta-dynamic-image-wrapper-html', '<figure class="elementor-image"><div class="rxta-dynamic-image-wrapper %2$s">%1$s</div></figure>' ), $output, $animation_class ) ;

		$this->__close_wrap();
	}

	/**
	 * Render button widget icon.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function get_frontend_icon( $settings ) {
		$output = '';

		if( empty( $settings[ 'icon' ] ) && empty( $settings[ 'icon' ]['value'] ) && 'none' !== $settings['link_to'] ){
			return $output;
		}

		$type = $settings[ 'icon' ][ 'library' ];

		switch ( $type ) {
			case 'svg':
				$format = apply_filters( 'rxta-dynamic-image-svg-icon-html', '<span class="elementor-svg-icon elementor-icon" >%s</span>' );
				$output = sprintf( $format, Svg_Handler::get_inline_svg( $settings[ 'icon' ][ 'value' ][ 'id' ] ) );
			break;

			default:
				$format = apply_filters( 'rxta-dynamic-image-icon-html', '<i class="%s elementor-icon" aria-hidden="true"></i>' );
				$output = sprintf( $format, $settings[ 'icon' ][ 'value' ] );
			break;
		}

		return $output;
	}
}
