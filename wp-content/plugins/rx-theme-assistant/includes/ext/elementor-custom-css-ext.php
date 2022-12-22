<?php

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Core\DynamicTags\Dynamic_CSS;
use Elementor\Core\Files\CSS\Post;
use Elementor\Element_Base;
use Elementor\Element_Column;
use Elementor\Element_Section;
use Elementor\Widget_Base;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Rx_Theme_Assistant_Elementor_Custom_CSS_Ext {

	/**
	 * A reference to an instance of this class.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance = null;

	/**
	 * [init description]
	 * @return [type] [description]
	 */
	public function init() {

		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			return;
		}

		add_action( 'elementor/element/after_section_end', [ $this, 'register_controls' ], 10, 2 );

		add_action( 'elementor/element/parse_css', [ $this, 'add_post_css' ], 10, 2 );

		add_action( 'elementor/css-file/post/parse', [ $this, 'add_page_settings_css' ] );
	}

	/**
	 * @param $element    Controls_Stack
	 * @param $section_id string
	 */
	public function register_controls( Controls_Stack $element, $section_id ) {

		if ( 'section_custom_css_pro' !== $section_id ) {
			return;
		}

		$this->add_custom_css_controls( $element );
	}

	/**
	 * @param Controls_Stack $controls_stack
	 */
	public function add_custom_css_controls( $controls_stack ) {
		$old_section = Plugin::$instance->controls_manager->get_control_from_stack( $controls_stack->get_unique_name(), 'section_custom_css_pro' );
		Plugin::$instance->controls_manager->remove_control_from_stack( $controls_stack->get_unique_name(), [ 'section_custom_css_pro', 'custom_css' ] );

		$controls_stack->start_controls_section(
			'section_custom_css',
			[
				'label' => __( 'Custom CSS', 'rx-theme-assistant' ),
				'tab'   => $old_section['tab'],
			]
		);

		$controls_stack->add_control(
			'custom_css_title',
			[
				'raw' => __( 'Add your own custom CSS here', 'rx-theme-assistant' ),
				'type' => Controls_Manager::RAW_HTML,
			]
		);

		$controls_stack->add_control(
			'custom_css',
			[
				'type' => Controls_Manager::CODE,
				'label' => __( 'Custom CSS', 'rx-theme-assistant' ),
				'language' => 'css',
				'render_type' => 'ui',
				'show_label' => false,
				'separator' => 'none',
			]
		);

		$controls_stack->add_control(
			'custom_css_description',
			[
				'raw' => __( 'Use "selector" to target wrapper element. Examples:<br>selector {color: red;} // For main element<br>selector .child-element {margin: 10px;} // For child element<br>.my-class {text-align: center;} // Or use any custom selector', 'rx-theme-assistant' ),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
			]
		);

		$controls_stack->end_controls_section();
	}

	/**
	 * @param $post_css Post
	 * @param $element  Element_Base
	 */
	public function add_post_css( $post_css, $element ) {
		if ( $post_css instanceof Dynamic_CSS ) {
			return;
		}

		$element_settings = $element->get_settings();

		if ( empty( $element_settings['custom_css'] ) ) {
			return;
		}

		$css = trim( $element_settings['custom_css'] );

		if ( empty( $css ) ) {
			return;
		}
		$css = str_replace( 'selector', $post_css->get_element_unique_selector( $element ), $css );

		// Add a css comment
		$css = sprintf( '/* Start custom CSS for %s, class: %s */', $element->get_name(), $element->get_unique_selector() ) . $css . '/* End custom CSS */';

		$post_css->get_stylesheet()->add_raw_css( $css );
	}

	/**
	 * @param $post_css Post
	 */
	public function add_page_settings_css( $post_css ) {
		$document = Plugin::$instance->documents->get( $post_css->get_post_id() );
		$custom_css = $document->get_settings( 'custom_css' );

		$custom_css = trim( $custom_css );

		if ( empty( $custom_css ) ) {
			return;
		}

		$custom_css = str_replace( 'selector', $document->get_css_wrapper_selector(), $custom_css );

		// Add a css comment
		$custom_css = '/* Start custom CSS for page-settings */' . $custom_css . '/* End custom CSS */';

		$post_css->get_stylesheet()->add_raw_css( $custom_css );
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}

/**
 * Returns instance of Rx_Theme_Assistant_Elementor_Custom_CSS_Ext
 *
 * @return object
 */
function rx_theme_assistant_elementor_custom_css_ext() {
	return Rx_Theme_Assistant_Elementor_Custom_CSS_Ext::get_instance();
}
