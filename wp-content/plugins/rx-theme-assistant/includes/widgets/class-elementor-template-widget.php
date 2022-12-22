<?php
/*
Widget Name: Rx Theme Assistant Elementor Template
Description: This widget is used to display a Elementor Template in your sidebar.
Settings:
 Title - Widget's text title
 Select template - Select elementor template
*/

/**
 * Rx Theme Assistant Elementor Template widget.
 *
 * @package Rx Theme Assistant
 */

use Elementor\Plugin;

if ( ! class_exists( 'Rx_Theme_Assistant_Elementor_Template_Widget' ) ) {

	/**
	 * Class Rx_Theme_Assistant_Elementor_Template_Widget.
	 */
	class Rx_Theme_Assistant_Elementor_Template_Widget extends WP_Widget {

		/**
		 * CSS class
		 *
		 * @var string
		 */
		public $widget_cssclass;

		/**
		 * Widget description
		 *
		 * @var string
		 */
		public $widget_description;

		/**
		 * Widget ID
		 *
		 * @var string
		 */
		public $widget_id;

		/**
		 * Widget name
		 *
		 * @var string
		 */
		public $widget_name;
		/**
		 * Settings
		 *
		 * @var array
		 */
		public $widget_settings = array();

		/**
		 * [$builder description]
		 * @var null
		 */
		public $interface_builder = null;

		/**
		 * Constructor
		 *
		 * @since  1.0.0
		 */
		public function __construct() {
			$this->widget_name        = esc_html__( 'RX: Elementor Template', 'rx-theme-assistant' );
			$this->widget_description = esc_html__( 'Display your Elementor Template.', 'rx-theme-assistant' );
			$this->widget_id          = 'rx-theme-assistant-elementor-template-widget';
			$this->widget_cssclass    = 'elementor-template-widget';
			$this->widget_settings           = array(
				'title' => array(
					'type'  => 'text',
					'value' => '',
					'label' => esc_html__( 'Title', 'rx-theme-assistant' ),
				),
				'template_id' => array(
					'type'             => 'select',
					'size'             => 1,
					'value'            => '',
					'options_callback' => array( $this, 'get_template_list' ),
					'options'          => false,
					'label'            => esc_html__( 'Select template', 'rx-theme-assistant' ),
					'multiple'         => false,
					'placeholder'      => esc_html__( 'Select template', 'rx-theme-assistant' ),
				),
			);

			$widget_ops = array(
				'classname'   => $this->widget_cssclass,
				'description' => $this->widget_description,
			);

			$this->init_interface_builder();
			parent::__construct( $this->widget_id, $this->widget_name, $widget_ops );
		}

		/**
		 * Show widget form
		 *
		 * @since  1.0.0
		 * @see    WP_Widget->form
		 * @param  array $instance current widget instance.
		 * @return void
		 */
		public function form( $instance ) {
			if ( empty( $this->widget_settings ) ) {
				return;
			}

			foreach ( $this->widget_settings as $key => $setting ) {
				$setting['id']    = $this->get_field_id( $key );
				$setting['name']  = $this->get_field_name( $key );
				$setting['value'] = isset( $instance[ $key ] ) ? $instance[ $key ] : $this->widget_settings[$key]['value'];

				$this->interface_builder->register_control( $setting );
			}

			$this->interface_builder->render();
		}


		/**
		 * [init_interface_builder description]
		 *
		 * @return [type] [description]
		 */
		public function init_interface_builder() {
			$builder_data = rx_theme_assistant()->framework->get_included_module_data( 'cherry-x-interface-builder.php' );

			$this->interface_builder = new CX_Interface_Builder(
				array(
					'path' => $builder_data['path'],
					'url'  => $builder_data['url'],
				)
			);
		}

		/**
		 * Update function.
		 *
		 * @since  1.0.0
		 * @see    WP_Widget->update
		 * @param  array $new_instance new widget instance, passed from widget form.
		 * @param  array $old_instance old instance, saved in database.
		 * @return array
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			foreach ( $this->widget_settings as $key => $setting ) {
				if ( isset( $new_instance[ $key ] ) ) {

					$instance[ $key ] = ! empty( $setting['sanitize_callback'] ) && is_callable( $setting['sanitize_callback'] )
					? call_user_func( $setting['sanitize_callback'],$new_instance[ $key ] )
					: $new_instance[ $key ] ;

				} elseif ( isset( $old_instance[ $key ] ) && is_array( $old_instance[ $key ] ) ) {
					$instance[ $key ] = array();
				} elseif ( isset( $old_instance[ $key ] ) ) {
					$instance[ $key ] = '';
				}
			}

			return $instance;
		}

		/**
		 * Get elementor template list.
		 *
		 * @return array
		 */
		public function get_template_list() {
			$result_list = array(
				'' => esc_html__( '-- Select template --', 'rx-theme-assistant' ),
			);

			$templates = Plugin::$instance->templates_manager->get_source( 'local' )->get_items();

			if ( $templates ) {
				foreach ( $templates as $template ) {
					$result_list[ $template['template_id'] ] = $template['title'];
				}
			}

			return $result_list;
		}

		/**
		 * Widget function.
		 *
		 * @see WP_Widget
		 *
		 * @since  1.0.0
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			if ( ! $instance['template_id'] ) {
				return;
			}

			$title = apply_filters( 'widget_title', $instance['title'] );

			echo $args['before_widget'];

			if( $title )
				echo $args['before_title'] . $title . $args['after_title'];

			$content = Plugin::$instance->frontend->get_builder_content_for_display( $instance['template_id'] );

			echo $content;

			echo $args['after_widget'];
		}
	}

	add_action( 'widgets_init', 'rx_theme_assistant_register_elementor_template_widget' );

	/**
	 * Register elementor template widget.
	 */
	function rx_theme_assistant_register_elementor_template_widget() {
		register_widget( 'Rx_Theme_Assistant_Elementor_Template_Widget' );
	}
}
