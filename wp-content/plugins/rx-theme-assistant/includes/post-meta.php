<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Rovadex
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Rx_Theme_Assistant_Post_Meta' ) ) {

	/**
	 * Define Rx_Theme_Assistant_Post_Meta class
	 */
	class Rx_Theme_Assistant_Post_Meta {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * The post meta arguments.
		 *
		 * @since 1.0.0
		 * @var   array
		 */
		private $post_meta_args = array();

		/**
		 * Constructor for the class
		 */
		public function init() {
			$this->rx_theme_assistant_meta_init();
		}

		/**
		 * [rx_theme_assistant_meta_init description]
		 * @return [type] [description]
		 */
		public function rx_theme_assistant_meta_init() {

			$this->post_meta_args = array(
				'id'            => 'rx-theme-assistant-page-settings',
				'title'         => esc_html__( 'Page Settings', 'rx-theme-assistant' ),
				'page'          => apply_filters( 'rx-theme-assistant/page-post-meta', array( 'page' ) ),
				'context'       => 'normal',
				'priority'      => 'high',
				'callback_args' => false,
				'builder_cb'    => array( $this, 'rx_theme_assistant_get_interface_builder' ),
				'fields'        => []
			);

			if ( class_exists( 'Header_Footer_Elementor' ) ) {
				$this->post_meta_args['fields']['rx_theme_assistant_page_header'] = array(
					'type'        => 'select',
					'title'       => esc_html__( 'Page Header', 'rx-theme-assistant' ),
					'description' => esc_html__( 'Choose header for this page.', 'rx-theme-assistant' ),
					'value'       => 'default',
					'options'     => $this->rx_theme_assistant_get_templates( 'type_header' ),
				);
				$this->post_meta_args['fields']['rx_theme_assistant_page_footer'] = array(
					'type'        => 'select',
					'title'       => esc_html__( 'Page Footer', 'rx-theme-assistant' ),
					'description' => esc_html__( 'Choose footer for this page.', 'rx-theme-assistant' ),
					'value'       => 'default',
					'options'     => $this->rx_theme_assistant_get_templates( 'type_footer' ),
				);
			}

			new Cherry_X_Post_Meta( apply_filters( 'rx-theme-assistant/post-meta-args', $this->post_meta_args ) );
		}

		/**
		 * Retur headers and footer templates.
		 *
		 * @return array
		 */
		private function rx_theme_assistant_get_templates( $type = 'type_header' ) {
			$posts = get_posts( array(
				'numberposts' => -1,
				'post_type'   => 'elementor-hf',
				'orderby'     => 'title',
				'post_status' => 'publish',
				'meta_key'    => 'ehf_template_type',
				'meta_value'  => $type,
			) );

			$templates = array(
				'default' => 'Default',
			);

			foreach ( $posts as $value ) {
				$templates[ $value->ID ] = $value->post_title;
			}

			return $templates;
		}

		/**
		 * Retur CX_Interface_Builder instance.
		 *
		 * @return object
		 */
		public function rx_theme_assistant_get_interface_builder() {

			$builder_data = rx_theme_assistant()->framework->get_included_module_data( 'cherry-x-interface-builder.php' );

			return new CX_Interface_Builder(
				array(
					'path' => $builder_data['path'],
					'url'  => $builder_data['url'],
				)
			);
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
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

}

function rx_theme_assistant_post_meta() {
	return Rx_Theme_Assistant_Post_Meta::get_instance();
}
