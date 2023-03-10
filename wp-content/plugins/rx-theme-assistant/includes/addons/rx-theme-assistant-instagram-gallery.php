<?php
/**
 * Class: Rx_Theme_Assistant_Instagram_Gallery
 * Name: Instagram
 * Slug: rx-theme-assistant-instagram-gallery
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
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rx_Theme_Assistant_Instagram_Gallery extends Rx_Theme_Assistant_Base {

	/**
	 * Instagram API-server URL.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $api_url = 'https://www.instagram.com/';

	/**
	 * Alternative Instagram API-server URL.
	 *
	 * @var string
	 */
	private $alt_api_url = 'https://apinsta.herokuapp.com/';

	/**
	 * Official Instagram API-server URL.
	 *
	 * @var string
	 */
	private $official_api_url = 'https://api.instagram.com/v1/';

	/**
	 * Access token.
	 *
	 * @var string
	 */
	private $access_token = null;

	/**
	 * Request config
	 *
	 * @var array
	 */
	public $config = array();

	public function get_name() {
		return 'rx-theme-assistant-instagram-gallery';
	}

	public function get_title() {
		return esc_html__( 'Instagram', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-photo-library';
	}

	public function get_categories() {
		return array( 'rx-theme-assistant' );
	}

	public function get_script_depends() {
		return [ 'rx-theme-assistant-salvattore', 'jquery-slick' ];
	}

	protected function register_controls() {

		$css_scheme = apply_filters(
			'rx-theme-assistant/instagram-gallery/css-scheme',
			array(
				'instance'       => '.rx-theme-assistant-instagram-gallery__instance',
				'image_instance' => '.rx-theme-assistant-instagram-gallery__image',
				'inner'          => '.rx-theme-assistant-instagram-gallery__inner',
				'content'        => '.rx-theme-assistant-instagram-gallery__content',
				'caption'        => '.rx-theme-assistant-instagram-gallery__caption',
				'meta'           => '.rx-theme-assistant-instagram-gallery__meta',
				'meta_item'      => '.rx-theme-assistant-instagram-gallery__meta-item',
				'meta_icon'      => '.rx-theme-assistant-instagram-gallery__meta-icon',
				'meta_label'     => '.rx-theme-assistant-instagram-gallery__meta-label',
			)
		);

		$this->start_controls_section(
			'section_instagram_settings',
			array(
				'label' => esc_html__( 'Instagram Settings', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'endpoint',
			array(
				'label'   => esc_html__( 'What to display', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hashtag',
				'options' => array(
					'hashtag'  => esc_html__( 'Tagged Photos', 'rx-theme-assistant' ),
					'self'     => esc_html__( 'My Photos', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_control(
			'insta_access_token',
			array(
				'label' => esc_html__( 'Access Token', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::TEXT,
				'condition' => array(
					'endpoint' => 'self',
				),
			)
		);

		$this->add_control(
			'set_access_token',
			array(
				'type' => Controls_Manager::RAW_HTML,
				'raw'  => sprintf( esc_html__( 'Read more about how to get Instagram Access Token %1$s or %2$s', 'rx-theme-assistant' ),
					'<a target="_blank" href="https://elfsight.com/blog/2016/05/how-to-get-instagram-access-token/">' . esc_html__( 'here', 'rx-theme-assistant' ) . '</a>',
					'<a target="_blank" href="https://docs.oceanwp.org/article/487-how-to-get-instagram-access-token">' . esc_html__( 'here', 'rx-theme-assistant' ) . '</a>'
				),
				'condition' => array(
					'endpoint' => 'self',
				),
			)
		);

		$this->add_control(
			'hashtag',
			array(
				'label' => esc_html__( 'Hashtag (enter without `#` symbol)', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::TEXT,
				'condition' => array(
					'endpoint' => 'hashtag',
				),
				'dynamic' => array(
					'active' => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
					),
				),
			)
		);

		$this->add_control(
			'cache_timeout',
			array(
				'label'   => esc_html__( 'Cache Timeout', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hour',
				'options' => array(
					'none'   => esc_html__( 'None', 'rx-theme-assistant' ),
					'minute' => esc_html__( 'Minute', 'rx-theme-assistant' ),
					'hour'   => esc_html__( 'Hour', 'rx-theme-assistant' ),
					'day'    => esc_html__( 'Day', 'rx-theme-assistant' ),
					'week'   => esc_html__( 'Week', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_control(
			'photo_size',
			array(
				'label'   => esc_html__( 'Photo Size', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'high',
				'options' => array(
					'thumbnail' => esc_html__( 'Thumbnail (150x150)', 'rx-theme-assistant' ),
					'low'       => esc_html__( 'Low (320x320)', 'rx-theme-assistant' ),
					'standard'  => esc_html__( 'Standard (640x640)', 'rx-theme-assistant' ),
					'high'      => esc_html__( 'High (original)', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_control(
			'posts_counter',
			array(
				'label'   => esc_html__( 'Number of instagram posts', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'max'     => 18,
				'step'    => 1,
			)
		);

		$this->add_control(
			'post_link',
			array(
				'label'        => esc_html__( 'Enable linking photos', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'post_caption',
			array(
				'label'        => esc_html__( 'Enable caption', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'post_caption_length',
			array(
				'label'   => esc_html__( 'Caption length', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 50,
				'min'     => 1,
				'max'     => 300,
				'step'    => 1,
				'condition' => array(
					'post_caption' => 'yes',
				),
			)
		);

		$this->add_control(
			'post_comments_count',
			array(
				'label'        => esc_html__( 'Enable Comments Count', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'post_likes_count',
			array(
				'label'        => esc_html__( 'Enable Likes Count', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings',
			array(
				'label' => esc_html__( 'Layout Settings', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'layout_type',
			array(
				'label'   => esc_html__( 'Layout type', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'masonry',
				'options' => array(
					'masonry'  => esc_html__( 'Masonry', 'rx-theme-assistant' ),
					'grid'     => esc_html__( 'Grid', 'rx-theme-assistant' ),
					'list'     => esc_html__( 'List', 'rx-theme-assistant' ),
					'carousel' => esc_html__( 'Carousel', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'   => esc_html__( 'Columns', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 3,
				'options' => rx_theme_assistant_tools()->get_select_range( 6 ),
				'condition' => array(
					'layout_type' => array( 'masonry', 'grid', 'carousel' ),
				),
			)
		);

		$this->add_control(
			'arrows',
			array(
				'label'        => esc_html__( 'Show Arrows Navigation', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
				'condition' => array(
					'layout_type'=> 'carousel',
				),
			)
		);

		$this->add_control(
			'prev_arrow',
			array(
				'label'   => esc_html__( 'Prev Arrow Icon', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fa fa-angle-left',
				'options' => rx_theme_assistant_tools()->get_available_prev_arrows_list(),
				'condition' => array(
					'arrows' => 'true',
					'layout_type'=> 'carousel',
				),
			)
		);

		$this->add_control(
			'next_arrow',
			array(
				'label'   => esc_html__( 'Next Arrow Icon', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fa fa-angle-right',
				'options' => rx_theme_assistant_tools()->get_available_next_arrows_list(),
				'condition' => array(
					'arrows' => 'true',
					'layout_type'=> 'carousel',
				),
			)
		);

		$this->add_control(
			'dots',
			array(
				'label'        => esc_html__( 'Show Dots Navigation', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => '',
				'condition' => array(
					'layout_type'=> 'carousel',
				),
			)
		);

		$this->add_control(
			'pause_on_hover',
			array(
				'label'        => esc_html__( 'Pause on Hover', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => '',
				'condition' => array(
					'layout_type'=> 'carousel',
				),
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
				'condition' => array(
					'layout_type'=> 'carousel',
				),
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'     => esc_html__( 'Autoplay Speed', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => array(
					'layout_type'=> 'carousel',
					'autoplay' => 'true',
				),
			)
		);

		$this->add_control(
			'infinite',
			array(
				'label'        => esc_html__( 'Infinite Loop', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'true',
				'default'      => 'true',
				'condition' => array(
					'layout_type'=> 'carousel',
				),
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
					'layout_type'=> 'carousel',
				),
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'   => esc_html__( 'Animation Speed', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
				'condition' => array(
					'layout_type'=> 'carousel',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * General Style Section
		 */
		$this->start_controls_section(
			'section_general_style',
			array(
				'label'      => esc_html__( 'General', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'item_height',
			array(
				'label' => esc_html__( 'Item Height', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 100,
						'max' => 1000,
					),
				),
				'default' => [
					'size' => 300,
				],
				'condition' => array(
					'layout_type' => 'grid',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['image_instance'] => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'item_margin',
			array(
				'label' => esc_html__( 'Items Margin', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default' => [
					'size' => 10,
				],
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['inner']    => 'margin: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'margin: -{{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'item_padding',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['inner'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'item_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['inner'],
			)
		);

		$this->add_responsive_control(
			'item_border_radius',
			array(
				'label'      => __( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['inner'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'item_shadow',
				'exclude' => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['inner'],
			)
		);

		$this->end_controls_section();

		/**
		 * Caption Style Section
		 */
		$this->start_controls_section(
			'section_caption_style',
			array(
				'label'      => esc_html__( 'Caption', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'caption_color',
			array(
				'label'  => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['caption'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'caption_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['caption'],
			)
		);

		$this->add_responsive_control(
			'caption_padding',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['caption'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'caption_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['caption'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'caption_width',
			array(
				'label' => esc_html__( 'Caption Width', 'rx-theme-assistant' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 50,
						'max' => 1000,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => [
					'size'  => 100,
					'units' => '%'
				],
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['caption'] => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'caption_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
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
					'{{WRAPPER}} ' . $css_scheme['caption'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'caption_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['caption'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Meta Style Section
		 */
		$this->start_controls_section(
			'section_meta_style',
			array(
				'label'      => esc_html__( 'Meta', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_advanced_icon_control(
			'comments_icon',
			[
				'label'   => esc_html__( 'Comments Icon', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::ICONS,
				'skin'    => 'inline',
				'file'    => '',
				'fa5_default' => [
					'value'   => 'fas fa-comment',
					'library' => 'solid',
				],
			]
		);

		$this->add_advanced_icon_control(
			'likes_icon',
			[
				'label'   => esc_html__( 'Likes Icon', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::ICONS,
				'skin'    => 'inline',
				'file'    => '',
				'fa5_default' => [
					'value'   => 'fas fa-heart',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'meta_icon_color',
			array(
				'label'  => esc_html__( 'Icon Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['meta_icon'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'meta_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', 'rem',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['meta_icon'] . ' i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'meta_label_color',
			array(
				'label'  => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['meta_label'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'meta_label_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['meta_label'],
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'meta_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['meta'],
			)
		);

		$this->add_responsive_control(
			'meta_padding',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['meta'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'meta_margin',
			array(
				'label'      => __( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['meta'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'meta_item_margin',
			array(
				'label'      => __( 'Item Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['meta_item'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'meta_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['meta'],
			)
		);

		$this->add_responsive_control(
			'meta_radius',
			array(
				'label'      => __( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['meta'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'meta_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['meta'],
			)
		);

		$this->add_responsive_control(
			'meta_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
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
					'{{WRAPPER}} ' . $css_scheme['meta'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Overlay Style Section
		 */
		$this->start_controls_section(
			'section_overlay_style',
			array(
				'label'      => esc_html__( 'Overlay', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'show_on_hover',
			array(
				'label'        => esc_html__( 'Show on hover', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'overlay_background',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_2,
						),
					),
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['content'] . ':before',
			)
		);

		$this->add_responsive_control(
			'overlay_paddings',
			array(
				'label'      => __( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'label'      => esc_html__( 'Content Order and Alignment', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'caption_order',
			array(
				'label'   => esc_html__( 'Caption Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'max'     => 4,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['caption'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'meta_order',
			array(
				'label'   => esc_html__( 'Meta Order', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 4,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['meta'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'cover_alignment',
			array(
				'label'   => esc_html__( 'Cover Content Vertical Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => array(
					'flex-start'    => esc_html__( 'Top', 'rx-theme-assistant' ),
					'center'        => esc_html__( 'Center', 'rx-theme-assistant' ),
					'flex-end'      => esc_html__( 'Bottom', 'rx-theme-assistant' ),
					'space-between' => esc_html__( 'Space between', 'rx-theme-assistant' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['content'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_arrows_style',
			array(
				'label'      => esc_html__( 'Carousel Arrows', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
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
				'label'          => esc_html__( 'Arrows Style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} .rx-theme-assistant-instagram-gallery__instance .rx-theme-assistant-arrow',
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
				'label'          => esc_html__( 'Arrows Style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} .rx-theme-assistant-instagram-gallery__instance .rx-theme-assistant-arrow:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prev_arrow_position',
			array(
				'label'     => esc_html__( 'Prev Arrow Position', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prev_vert_position',
			array(
				'label'   => esc_html__( 'Vertical Position by', 'rx-theme-assistant' ),
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
				'label'      => esc_html__( 'Top Indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rx-theme-assistant-instagram-gallery__instance .rx-theme-assistant-arrow.prev-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'prev_bottom_position',
			array(
				'label'      => esc_html__( 'Bottom Indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rx-theme-assistant-instagram-gallery__instance .rx-theme-assistant-arrow.prev-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				),
			)
		);

		$this->add_control(
			'prev_hor_position',
			array(
				'label'   => esc_html__( 'Horizontal Position by', 'rx-theme-assistant' ),
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
				'label'      => esc_html__( 'Left Indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rx-theme-assistant-instagram-gallery__instance .rx-theme-assistant-arrow.prev-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'prev_right_position',
			array(
				'label'      => esc_html__( 'Right Indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rx-theme-assistant-instagram-gallery__instance .rx-theme-assistant-arrow.prev-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			)
		);

		$this->add_control(
			'next_arrow_position',
			array(
				'label'     => esc_html__( 'Next Arrow Position', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'next_vert_position',
			array(
				'label'   => esc_html__( 'Vertical Position by', 'rx-theme-assistant' ),
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
				'label'      => esc_html__( 'Top Indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rx-theme-assistant-instagram-gallery__instance .rx-theme-assistant-arrow.next-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'next_bottom_position',
			array(
				'label'      => esc_html__( 'Bottom Indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rx-theme-assistant-instagram-gallery__instance .rx-theme-assistant-arrow.next-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				),
			)
		);

		$this->add_control(
			'next_hor_position',
			array(
				'label'   => esc_html__( 'Horizontal Position by', 'rx-theme-assistant' ),
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
				'label'      => esc_html__( 'Left Indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rx-theme-assistant-instagram-gallery__instance .rx-theme-assistant-arrow.next-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'next_right_position',
			array(
				'label'      => esc_html__( 'Right Indent', 'rx-theme-assistant' ),
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
					'{{WRAPPER}} .rx-theme-assistant-instagram-gallery__instance .rx-theme-assistant-arrow.next-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dots_style',
			array(
				'label'      => esc_html__( 'Carousel Dots', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
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
				'label'          => esc_html__( 'Dots Style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} .rx-theme-assistant-carousel .rx-theme-assistant-slick-dots li span',
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
				'label'          => esc_html__( 'Dots Style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} .rx-theme-assistant-carousel .rx-theme-assistant-slick-dots li span:hover',
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
				'label'          => esc_html__( 'Dots Style', 'rx-theme-assistant' ),
				'selector'       => '{{WRAPPER}} .rx-theme-assistant-carousel .rx-theme-assistant-slick-dots li.slick-active span',
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
					'{{WRAPPER}} .rx-theme-assistant-carousel .rx-theme-assistant-slick-dots li' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'dots_margin',
			array(
				'label'      => esc_html__( 'Dots Box Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .rx-theme-assistant-carousel .rx-theme-assistant-slick-dots' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .rx-theme-assistant-carousel .rx-theme-assistant-slick-dots' => 'justify-content: {{VALUE}};',
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
	 * Render gallery html.
	 *
	 * @return string
	 */
	public function render_gallery() {
		$settings = $this->get_settings_for_display();

		if ( 'hashtag' === $settings['endpoint'] && empty( $settings['hashtag'] ) ) {
			return print esc_html__( 'Please, enter #hashtag.', 'rx-theme-assistant' );
		}

		if ( 'self' === $settings['endpoint'] && ! $this->get_access_token() ) {
			return print esc_html__( 'Please, enter Access Token.', 'rx-theme-assistant' );
		}

		$html = '';
		$col_class = '';

		// Endpoint.
		$endpoint = $this->sanitize_endpoint();

		switch ( $settings['cache_timeout'] ) {
			case 'none':
				$cache_timeout = 1;
				break;

			case 'minute':
				$cache_timeout = MINUTE_IN_SECONDS;
				break;

			case 'hour':
				$cache_timeout = HOUR_IN_SECONDS;
				break;

			case 'day':
				$cache_timeout = DAY_IN_SECONDS;
				break;

			case 'week':
				$cache_timeout = WEEK_IN_SECONDS;
				break;

			default:
				$cache_timeout = HOUR_IN_SECONDS;
				break;
		}

		$this->config = array(
			'endpoint'            => $endpoint,
			'target'              => ( 'hashtag' === $endpoint ) ? sanitize_text_field( $settings[ $endpoint ] ) : 'users',
			'posts_counter'       => $settings['posts_counter'],
			'post_link'           => filter_var( $settings['post_link'], FILTER_VALIDATE_BOOLEAN ),
			'photo_size'          => $settings['photo_size'],
			'post_caption'        => filter_var( $settings['post_caption'], FILTER_VALIDATE_BOOLEAN ),
			'post_caption_length' => ! empty( $settings['post_caption_length'] ) ? $settings['post_caption_length'] : 50,
			'post_comments_count' => filter_var( $settings['post_comments_count'], FILTER_VALIDATE_BOOLEAN ),
			'post_likes_count'    => filter_var( $settings['post_likes_count'], FILTER_VALIDATE_BOOLEAN ),
			'cache_timeout'       => $cache_timeout,
		);

		$posts = $this->get_posts( $this->config );

		if ( ! empty( $posts ) ) {

			foreach ( $posts as $post_data ) {
				$item_html   = '';
				$link        = ( 'hashtag' === $endpoint ) ? sprintf( $this->get_post_url(), $post_data['link'] ) : $post_data['link'];
				$the_image   = $this->the_image( $post_data );
				$the_caption = $this->the_caption( $post_data );
				$the_meta    = $this->the_meta( $post_data );

				$item_html = sprintf(
					'<div class="rx-theme-assistant-instagram-gallery__media">%1$s</div><div class="rx-theme-assistant-instagram-gallery__content">%2$s%3$s</div>',
					$the_image,
					$the_caption,
					$the_meta
				);

				if ( $this->config['post_link'] ) {
					$link_format = '<a class="rx-theme-assistant-instagram-gallery__link" href="%s" target="_blank" rel="nofollow">%s</a>';
					$link_format = apply_filters( 'rx-theme-assistant/instagram-gallery/link-format', $link_format );

					$item_html = sprintf( $link_format, esc_url( $link ), $item_html );
				}

				if ( 'grid' === $settings['layout_type'] ) {
					$col_class = rx_theme_assistant_tools()->col_classes( array(
						'desk' => $settings['columns'],
						'tab'  => $settings['columns_tablet'],
						'mob'  => $settings['columns_mobile'],
					) );
				}

				$html .= sprintf( '<div class="rx-theme-assistant-instagram-gallery__item %s"><div class="rx-theme-assistant-instagram-gallery__inner">%s</div></div>', $col_class, $item_html );
			}

		} else {
			$html .= sprintf(
				'<div class="rx-theme-assistant-instagram-gallery__item">%s</div>',
				esc_html__( 'Posts not found', 'rx-theme-assistant' )
			);
		}

		return $html;
	}

	/**
	 * Display a HTML link with image.
	 *
	 * @since  1.0.0
	 * @param  array $item Item photo data.
	 * @return string
	 */
	public function the_image( $item ) {

		$size = $this->get_settings_for_display( 'photo_size' );

		$thumbnail_resources = $item['thumbnail_resources'];

		if ( array_key_exists( $size, $thumbnail_resources ) ) {
			$width = $thumbnail_resources[ $size ]['config_width'];
			$height = $thumbnail_resources[ $size ]['config_height'];
			$post_photo_url = $thumbnail_resources[ $size ]['src'];
		} else {
			$width = isset( $item['dimensions']['width'] ) ? $item['dimensions']['width'] : '';
			$height = isset( $item['dimensions']['height'] ) ? $item['dimensions']['height'] : '';
			$post_photo_url = isset( $item['image'] ) ? $item['image'] : '';
		}

		if ( empty( $post_photo_url ) ) {
			return '';
		}

		$photo_format = "<img class='rx-theme-assistant-instagram-gallery__image' src='%s' width='{$width}' height='{$height}' alt=''>";

		$photo_format = apply_filters( 'rx-theme-assistant/instagram-gallery/photo-format', $photo_format );

		$image = sprintf( $photo_format, esc_url( $post_photo_url ) );

		return $image;
	}

	/**
	 * Display a caption.
	 *
	 * @since  1.0.0
	 * @param  array $item Item photo data.
	 * @return string
	 */
	public function the_caption( $item ) {

		if ( ! $this->config['post_caption'] || empty( $item['caption'] ) ) {
			return;
		}

		$format = apply_filters(
			'rx-theme-assistant/instagram-gallery/the-caption-format', '<div class="rx-theme-assistant-instagram-gallery__caption">%s</div>'
		);

		return sprintf( $format, $item['caption'] );
	}

	/**
	 * Display a meta.
	 *
	 * @since  1.0.0
	 * @param  array $item Item photo data.
	 * @return string
	 */
	public function the_meta( $item ) {

		if ( ! $this->config['post_comments_count'] && ! $this->config['post_likes_count'] ) {
			return;
		}

		$meta_html = '';

		if ( $this->config['post_comments_count'] ) {
			$comments_icon = $this->__get_icon( 'comments_icon', '<span class="rx-theme-assistant-instagram-gallery__comments-icon rx-theme-assistant-instagram-gallery__meta-icon">%s</span>' );
			$meta_html .= sprintf(
				'<div class="rx-theme-assistant-instagram-gallery__meta-item rx-theme-assistant-instagram-gallery__comments-count">%s<span class="rx-theme-assistant-instagram-gallery__comments-label rx-theme-assistant-instagram-gallery__meta-label">%s</span></div>',
				$comments_icon,
				$item['comments']
			);
		}

		if ( $this->config['post_likes_count'] ) {
			$likes_count_icon = $this->__get_icon( 'likes_icon', '<span class="rx-theme-assistant-instagram-gallery__likes-icon rx-theme-assistant-instagram-gallery__meta-icon">%s</span>' );
			$meta_html .= sprintf(
				'<div class="rx-theme-assistant-instagram-gallery__meta-item rx-theme-assistant-instagram-gallery__likes-count">%s<span class="rx-theme-assistant-instagram-gallery__likes-label rx-theme-assistant-instagram-gallery__meta-label">%s</span></div>',
				$likes_count_icon,
				$item['likes']
			);
		}

		$format = apply_filters( 'rx-theme-assistant/instagram-gallery/the-meta-format', '<div class="rx-theme-assistant-instagram-gallery__meta">%s</div>' );

		return sprintf( $format, $meta_html );
	}

	/**
	 * Retrieve a photos.
	 *
	 * @since  1.0.0
	 * @param  array $config Set of configuration.
	 * @return array
	 */
	public function get_posts( $config ) {

		$transient_key = md5( $this->get_transient_key() );

		$data = get_transient( $transient_key );

		if ( ! empty( $data ) && 1 !== $config['cache_timeout'] && array_key_exists( 'thumbnail_resources', $data[0] ) ) {
			return $data;
		}

		$response = $this->remote_get( $config );

		if ( is_wp_error( $response ) ) {
			return array();
		}

		$data = ( 'hashtag' === $config['endpoint'] ) ? $this->get_response_data( $response ) : $this->get_response_data_from_official_api( $response );

		if ( empty( $data ) ) {
			return array();
		}

		set_transient( $transient_key, $data, $config['cache_timeout'] );

		return $data;
	}

	/**
	 * Retrieve the raw response from the HTTP request using the GET method.
	 *
	 * @since  1.0.0
	 * @return array|WP_Error
	 */
	public function remote_get( $config ) {

		$url = $this->get_grab_url( $config );

		$response = wp_remote_get( $url, array(
			'timeout'   => 60,
			'sslverify' => false
		) );

		$response_code = wp_remote_retrieve_response_code( $response );

		if ( '' === $response_code ) {
			return new \WP_Error;
		}

		$result = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( ! is_array( $result ) ) {
			return new \WP_Error;
		}

		return $result;
	}

	/**
	 * Get prepared response data.
	 *
	 * @param $response
	 *
	 * @return array
	 */
	public function get_response_data( $response ) {

		$key = 'hashtag' == $this->config['endpoint'] ? 'hashtag' : 'user';

		if ( 'hashtag' === $key ) {
			$response = isset( $response['graphql'] ) ? $response['graphql'] : $response;
		}

		$response_items = ( 'hashtag' === $key ) ? $response[ $key ]['edge_hashtag_to_media']['edges'] : $response['graphql'][ $key ]['edge_owner_to_timeline_media']['edges'];

		if ( empty( $response_items ) ) {
			return array();
		}

		$data  = array();
		$nodes = array_slice(
			$response_items,
			0,
			$this->config['posts_counter'],
			true
		);

		foreach ( $nodes as $post ) {

			$_post               = array();
			$_post['link']       = $post['node']['shortcode'];
			$_post['image']      = $post['node']['thumbnail_src'];
			$_post['caption']    = isset( $post['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ? wp_html_excerpt( $post['node']['edge_media_to_caption']['edges'][0]['node']['text'], $this->config['post_caption_length'], '&hellip;' ) : '';
			$_post['comments']   = $post['node']['edge_media_to_comment']['count'];
			$_post['likes']      = $post['node']['edge_liked_by']['count'];
			$_post['dimensions'] = $post['node']['dimensions'];
			$_post['thumbnail_resources'] = $this->_generate_thumbnail_resources( $post );

			array_push( $data, $_post );
		}

		return $data;
	}

	/**
	 * Get prepared response data from official api.
	 *
	 * @param $response
	 *
	 * @return array
	 */
	public function get_response_data_from_official_api( $response ) {

		$response_items = $response['data'];

		if ( empty( $response_items ) ) {
			return array();
		}

		$data  = array();
		$nodes = array_slice(
			$response_items,
			0,
			$this->config['posts_counter'],
			true
		);

		foreach ( $nodes as $post ) {
			$_post             = array();
			$_post['link']     = $post['link'];
			$_post['caption']  = ! empty( $post['caption']['text'] ) ? wp_html_excerpt( $post['caption']['text'], $this->config['post_caption_length'], '&hellip;' ) : '';
			$_post['comments'] = $post['comments']['count'];
			$_post['likes']    = $post['likes']['count'];
			$_post['thumbnail_resources'] = $this->_generate_thumbnail_resources_from_official_api( $post );

			array_push( $data, $_post );
		}

		return $data;
	}

	/**
	 * Generate thumbnail resources.
	 *
	 * @param $post_data
	 *
	 * @return array
	 */
	public function _generate_thumbnail_resources( $post_data ) {
		$post_data = $post_data['node'];

		$thumbnail_resources = array(
			'thumbnail' => false,
			'low'       => false,
			'standard'  => false,
			'high'      => false,
		);

		if ( is_array( $post_data['thumbnail_resources'] ) && ! empty( $post_data['thumbnail_resources'] ) ) {
			foreach ( $post_data['thumbnail_resources'] as $key => $resources_data ) {

				if ( 150 === $resources_data['config_width'] ) {
					$thumbnail_resources['thumbnail'] = $resources_data;

					continue;
				}

				if ( 320 === $resources_data['config_width'] ) {
					$thumbnail_resources['low'] = $resources_data;

					continue;
				}

				if ( 640 === $resources_data['config_width'] ) {
					$thumbnail_resources['standard'] = $resources_data;

					continue;
				}
			}
		}

		if ( ! empty( $post_data['display_url'] ) ) {
			$thumbnail_resources['high'] = array(
				'src'           => $post_data['display_url'],
				'config_width'  => $post_data['dimensions']['width'],
				'config_height' => $post_data['dimensions']['height'],
			) ;
		}

		return $thumbnail_resources;
	}

	/**
	 * Generate thumbnail resources from official api.
	 *
	 * @param $post_data
	 *
	 * @return array
	 */
	public function _generate_thumbnail_resources_from_official_api( $post_data ) {
		$thumbnail_resources = array(
			'thumbnail' => false,
			'low'       => false,
			'standard'  => false,
			'high'      => false,
		);

		if ( is_array( $post_data['images'] ) && ! empty( $post_data['images'] ) ) {

			$thumbnails_data = $post_data['images'];

			$thumbnail_resources['thumbnail'] = array(
				'src'           => $thumbnails_data['thumbnail']['url'],
				'config_width'  => $thumbnails_data['thumbnail']['width'],
				'config_height' => $thumbnails_data['thumbnail']['height'],
			);

			$thumbnail_resources['low'] = array(
				'src'           => $thumbnails_data['low_resolution']['url'],
				'config_width'  => $thumbnails_data['low_resolution']['width'],
				'config_height' => $thumbnails_data['low_resolution']['height'],
			);

			$thumbnail_resources['standard'] = array(
				'src'           => $thumbnails_data['standard_resolution']['url'],
				'config_width'  => $thumbnails_data['standard_resolution']['width'],
				'config_height' => $thumbnails_data['standard_resolution']['height'],
			);

			$thumbnail_resources['high'] = $thumbnail_resources['standard'];
		}

		return $thumbnail_resources;
	}

	/**
	 * Retrieve a grab URL.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_grab_url( $config ) {

		if ( 'hashtag' == $config['endpoint'] ) {
			$url = sprintf( $this->get_tags_url(), $config['target'] );
			$url = add_query_arg( array( '__a' => 1 ), $url );

		} else {
			$url = $this->get_self_url();
			$url = add_query_arg( array( 'access_token' => $this->get_access_token() ), $url );
		}

		return $url;
	}

	/**
	 * Retrieve a URL for photos by hashtag.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_tags_url() {
		return apply_filters( 'rx-theme-assistant/instagram-gallery/get-tags-url', $this->api_url . 'explore/tags/%s/' );
	}

	/**
	 * Retrieve a URL for self photos.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_self_url() {
		return apply_filters( 'rx-theme-assistant/instagram-gallery/get-self-url', $this->official_api_url . 'users/self/media/recent/' );
	}

	/**
	 * Retrieve a URL for post.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_post_url() {
		return apply_filters( 'rx-theme-assistant/instagram-gallery/get-post-url', $this->api_url . 'p/%s/' );
	}

	/**
	 * sanitize endpoint.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function sanitize_endpoint() {
		return in_array( $this->get_settings( 'endpoint' ) , array( 'hashtag', 'self' ) ) ? $this->get_settings( 'endpoint' ) : 'hashtag';
	}

	/**
	 * Retrieve a photo sizes (in px) by option name.
	 *
	 * @since  1.0.0
	 * @param  string $photo_size Photo size.
	 * @return array
	 */
	public function _get_relation_photo_size( $photo_size ) {
		switch ( $photo_size ) {

			case 'high':
				$size = array();
				break;

			case 'standard':
				$size = array( 640, 640 );
				break;

			case 'low':
				$size = array( 320, 320 );
				break;

			default:
				$size = array( 150, 150 );
				break;
		}

		return apply_filters( 'rx-theme-assistant/instagram-gallery/relation-photo-size', $size, $photo_size );
	}

	/**
	 * Get transient key.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_transient_key() {
		return sprintf( 'rx-theme-assistant_elements_instagram_%s_%s_posts_count_%s_caption_%s',
			$this->config['endpoint'],
			$this->config['target'],
			$this->config['posts_counter'],
			$this->config['post_caption_length']
		);
	}

	/**
	 * Generate setting json
	 *
	 * @return string
	 */
	public function generate_setting_json() {
		$module_settings = $this->get_settings();

		$settings = array(
			'layoutType'    => $module_settings['layout_type'],
			'columns'       => $module_settings['columns'],
			'columnsTablet' => $module_settings['columns_tablet'],
			'columnsMobile' => $module_settings['columns_mobile'],
		);

		$settings = json_encode( $settings );

		return sprintf( 'data-settings=\'%1$s\'', $settings );
	}

	/**
	 * Apply carousel wrappers for shortcode content if carousel is enabled.
	 *
	 * @param  string $content  Module content.
	 * @param  array  $settings Module settings.
	 * @return string
	 */
	public function maybe_apply_carousel_wrappers( $content = null, $settings = array() ) {

		if ( 'carousel' !== $settings['layout_type'] ) {
			return $content;
		}

		$is_rtl = is_rtl();

		$options = array(
			'slidesToShow'   => array(
				'desktop' => absint( $settings['columns'] ),
				'tablet'  => absint( $settings['columns_tablet'] ),
				'mobile'  => absint( $settings['columns_mobile'] ),
			),
			'autoplaySpeed'  => absint( $settings['autoplay_speed'] ),
			'autoplay'       => filter_var( $settings['autoplay'], FILTER_VALIDATE_BOOLEAN ),
			'infinite'       => filter_var( $settings['infinite'], FILTER_VALIDATE_BOOLEAN ),
			'pauseOnHover'   => filter_var( $settings['pause_on_hover'], FILTER_VALIDATE_BOOLEAN ),
			'speed'          => absint( $settings['speed'] ),
			'arrows'         => filter_var( $settings['arrows'], FILTER_VALIDATE_BOOLEAN ),
			'dots'           => filter_var( $settings['dots'], FILTER_VALIDATE_BOOLEAN ),
			'slidesToScroll' => 1,
			'prevArrow'      => rx_theme_assistant_tools()->get_carousel_arrow(
				array( $settings['prev_arrow'], 'prev-arrow' )
			),
			'nextArrow'      => rx_theme_assistant_tools()->get_carousel_arrow(
				array( $settings['next_arrow'], 'next-arrow' )
			),
			'rtl' => $is_rtl,
		);

		if ( 1 === absint( $settings['columns'] ) ) {
			$options['fade'] = ( 'fade' === $settings['effect'] );
		}

		$dir = $is_rtl ? 'rtl' : 'ltr';

		return sprintf(
			'<div class="rx-theme-assistant-carousel elementor-slick-slider" data-slider_options="%1$s" dir="%3$s">%2$s</div>',
			htmlspecialchars( json_encode( $options ) ), $content, $dir
		);
	}

	/**
	 * Get access token.
	 *
	 * @return string
	 */
	public function get_access_token() {

		if ( ! $this->access_token ) {
			$this->access_token = $this->get_settings( 'insta_access_token' );
		}

		return $this->access_token;
	}

}
