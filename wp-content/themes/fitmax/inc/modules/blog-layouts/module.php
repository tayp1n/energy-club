<?php
/**
 * Blog layouts module
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Rvdx_Theme_Blog_Layouts_Module' ) ) {

	/**
	 * Define Rvdx_Theme_Blog_Layouts_Module class
	 */
	class Rvdx_Theme_Blog_Layouts_Module extends Rvdx_Theme_Module_Base {
		/**
		 * properties.
		 */
		private $layout_type;
		private $sidebar_enabled = true;
		private $fullwidth_enabled = true;

		/**
		 * Sidebar list.
		 */
		private $sidebar_list = array( 'default', 'masonry' );

		/**
		 * Fullwidth list.
		 */
		private $fullwidth_list = array( 'grid' );

		/**
		 * Module ID
		 *
		 * @return string
		 */
		public function module_id() {

			return 'blog-layouts';

		}

		/**
		 * Module filters
		 *
		 * @return void
		 */
		public function filters() {

			add_action( 'wp_head', array( $this, 'module_init_properties' ) );
			add_filter( 'rvdx-theme/customizer/options', array( $this, 'customizer_options' ) );
			add_filter( 'rvdx-theme/customizer/blog-sidebar-enabled', array( $this, 'customizer_blog_sidebar_enabled' ) );
			add_filter( 'rvdx-theme/posts/template-part-slug', array( $this, 'apply_layout_template' ) );
			add_filter( 'rvdx-theme/posts/list-class', array( $this, 'add_list_class' ) );
			add_filter( 'rvdx-theme/site-content/container-enabled', array( $this, 'disable_site_content_container' ) );

		}

		/**
		 * Init module properties
		 *
		 * @return void
		 */
		public function module_init_properties() {

			$this->layout_type = rvdx_theme()->customizer->get_value( 'blog_layout_type' );

			if ( $this->is_blog_archive() ) {
				$this->sidebar_enabled = in_array( $this->layout_type, $this->sidebar_list );
			}

			if ( $this->is_blog_archive() ) {
				$this->fullwidth_enabled = ! in_array( $this->layout_type, $this->fullwidth_list );
			}

			if ( ! $this->sidebar_enabled ) {
				rvdx_theme()->sidebar_position = 'none';
			}
		}

		/**
		 * Apply new blog layout
		 *
		 * @return array
		 */
		public function apply_layout_template( $layout ) {

			$blog_post_template = 'template-parts/layout/list';

			if ( 'default' === $this->layout_type ) {
				$blog_post_template = 'template-parts/layout/list';
			}

			if ( 'grid' === $this->layout_type ) {
				$blog_post_template = 'template-parts/layout/grid';
			}

			if ( 'masonry' === $this->layout_type ) {
				$blog_post_template = 'template-parts/layout/masonry';
			}

			if ( 'vertical-justify' === $this->layout_type ) {
				$blog_post_template = 'template-parts/layout/vertical-justify';
			}

			if ( 'creative' === $this->layout_type ) {
				$blog_post_template = 'template-parts/layout/creative';
			}

			if ( 'timeline' === $this->layout_type ) {
				$blog_post_template = 'template-parts/layout/timeline';
			}

			return 'inc/modules/blog-layouts/' . $blog_post_template;

		}

		/**
		 * Add list class
		 *
		 * @param  string   list class
		 *
		 * @return [type]   modified list class
		 */
		public function add_list_class( $list_class ) {

			$list_class .= ' posts-list--' . sanitize_html_class( ! is_search() ? $this->layout_type : 'default' );

			return $list_class;
		}

		/**
		 * Add blog related customizer options
		 *
		 * @param  array $options Options list
		 * @return array
		 */
		public function customizer_options( $options ) {

			$new_options = array(
				'blog_layout_type' => array(
					'title'    => esc_html__( 'Layout', 'fitmax' ),
					'priority' => 1,
					'section'  => 'blog',
					'default'  => 'default',
					'field'    => 'select',
					'choices'  => array(
						'default'          => esc_html__( 'Listing', 'fitmax' ),
						'grid'             => esc_html__( 'Grid', 'fitmax' ),
						'masonry'          => esc_html__( 'Masonry', 'fitmax' ),
						'vertical-justify' => esc_html__( 'Vertical Justify', 'fitmax' ),
						'creative'         => esc_html__( 'Creative', 'fitmax' ),
						'timeline'         => esc_html__( 'Timeline', 'fitmax' ),
					),
					'type' => 'control',
				),
			);

			$options['options'] = array_merge( $new_options, $options['options'] );

			return $options;

		}

		/**
		 * Check blog archive pages
		 *
		 * @return bool
		 */
		public function is_blog_archive() {

			if ( is_home() || ( is_archive() && ! is_tax() && ! is_post_type_archive() ) ) {
				return true;
			}

			return false;

		}

		/**
		 * Disable site content container
		 *
		 * @return boolean
		 */
		public function disable_site_content_container() {
			return $this->fullwidth_enabled;
		}

		/**
		 * Customizer blog sidebar enabled
		 *
		 * @return boolean
		 */
		public function customizer_blog_sidebar_enabled() {
			return $this->sidebar_enabled;
		}

		/**
		 * Blog layouts styles
		 *
		 * @return void
		 */
		public function enqueue_styles() {

			wp_enqueue_style(
				'blog-layouts-module',
				get_theme_file_uri( 'inc/modules/blog-layouts/assets/css/blog-layouts-module.css' ),
				false,
				rvdx_theme()->version()
			);

			if ( is_rtl() ) {
				wp_enqueue_style(
					'blog-layouts-module-rtl',
					get_theme_file_uri( 'inc/modules/blog-layouts/assets/css/rtl.css' ),
					false,
					rvdx_theme()->version()
				);
			}

		}

	}

}
