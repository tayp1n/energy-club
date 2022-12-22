<?php
/**
 * Cherry addons tools class
 */

use Elementor\Plugin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Rx_Theme_Assistant_Tools' ) ) {

	/**
	 * Define Rx_Theme_Assistant_Tools class
	 */
	class Rx_Theme_Assistant_Tools {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Returns image size array in slug => name format
		 *
		 * @return  array
		 */
		public function get_image_sizes() {

			global $_wp_additional_image_sizes;

			$sizes  = get_intermediate_image_sizes();
			$result = array();

			foreach ( $sizes as $size ) {
				if ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
					$result[ $size ] = ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) );
				} else {
					$result[ $size ] = sprintf(
						'%1$s (%2$sx%3$s)',
						ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) ),
						$_wp_additional_image_sizes[ $size ]['width'],
						$_wp_additional_image_sizes[ $size ]['height']
					);
				}
			}

			return array_merge( array( 'full' => esc_html__( 'Full', 'rx-theme-assistant' ), ), $result );
		}

		/**
		 * Return post terms.
		 *
		 * @since  1.0.0
		 * @param [type] $tax - category, post_tag, post_format.
		 * @param [type] $return_key - slug, term_id.
		 * @return array
		 */
		public function get_terms_array( $tax = array( 'category' ), $return_key = 'slug' ) {
			$terms = array();
			$tax = is_array( $tax ) ? $tax : array( $tax ) ;
			foreach ( $tax as $key => $value ) {
				if ( ! taxonomy_exists( $value ) ) {
					unset( $tax[ $key ] );
				}
			}
			$all_terms = (array) get_terms( $tax, array(
				'hide_empty'   => 0,
				'hierarchical' => 0,
			) );

			if ( empty( $all_terms ) || is_wp_error( $all_terms ) ) {
				return '';
			}
			foreach ( $all_terms as $term ) {
				$terms[ $term->$return_key ] = $term->name;
			}

			return $terms;
		}

		/**
		 * Get post by type.
		 *
		 * @return array
		 */
		public function get_post_by_type( $post_type = 'post', $return_key = 'slug', $placeholder = '' ) {
			$args = array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'numberposts' => -1,
				'orderby' => 'name',
				'order'   => 'DESC',
			);
			$posts = get_posts( $args );
			$output_posts = array();

			foreach ( $posts as $post ) {
				$key = ( 'slug' === $return_key ) ? $post->post_name : $post->ID ;
				$output_posts[ $key ] = $post->post_title;
			}

			if( $placeholder ){
				array_unshift( $output_posts, $placeholder );
			}
			return $output_posts;

		}

		/**
		 * Get post types options list
		 *
		 * @return array
		 */
		public function get_post_types() {

			$post_types = get_post_types( array( 'public' => true ), 'objects' );

			$deprecated = apply_filters(
				'rx-theme-assistant/post-types-list/deprecated',
				array( 'attachment', 'elementor_library', 'elementor-hf' )
			);

			$result = array();

			if ( empty( $post_types ) ) {
				return $result;
			}

			foreach ( $post_types as $slug => $post_type ) {

				if ( in_array( $slug, $deprecated ) ) {
					continue;
				}

				$result[ $slug ] = $post_type->label;

			}

			return $result;

		}

		/**
		 * Get post taxonomies for options.
		 *
		 * @return array
		 */
		public function get_taxonomies_for_options( $terms_type = array() ) {
			$args = array(
				'public'  => true,
			);

			$taxonomies = get_taxonomies( $args, 'objects', 'and' );

			if( ! empty( $terms_type ) ){
				foreach ( $taxonomies as $slug => $term ) {
					if ( ! in_array( $slug, $terms_type ) ) {
						unset( $taxonomies[ $slug ] );
					}
				}
			}

			return wp_list_pluck( $taxonomies, 'label', 'name' );
		}

		/**
		 * Returns columns classes string
		 * @param  [type] $columns [description]
		 * @return [type]          [description]
		 */
		public function col_classes( $columns = array() ) {

			$columns = wp_parse_args( $columns, array(
				'desk' => 1,
				'tab'  => 1,
				'mob'  => 1,
			) );

			$classes = array();

			foreach ( $columns as $device => $cols ) {
				if ( ! empty( $cols ) ) {
					$classes[] = sprintf( 'col-%1$s-%2$s', $device, $cols );
				}
			}

			return implode( ' ' , $classes );
		}

		/**
		 * Returns disable columns gap nad rows gap classes string
		 *
		 * @param  string $use_cols_gap [description]
		 * @param  string $use_rows_gap [description]
		 * @return [type]               [description]
		 */
		public function gap_classes( $use_cols_gap = 'yes', $use_rows_gap = 'yes' ) {

			$result = array();

			foreach ( array( 'cols' => $use_cols_gap, 'rows' => $use_rows_gap ) as $element => $value ) {
				if ( 'yes' !== $value ) {
					$result[] = sprintf( 'disable-%s-gap', $element );
				}
			}

			return implode( ' ', $result );

		}

		/**
		 * Returns array with numbers in $index => $name format for numeric selects
		 *
		 * @param  integer $to Max numbers
		 * @return array
		 */
		public function get_select_range( $to = 10 ) {
			$range = range( 1, $to );

			return array_combine( $range, $range );
		}

		/**
		 * Return availbale arrows list
		 * @return [type] [description]
		 */
		public function get_available_prev_arrows_list() {

			return apply_filters(
				'rx_theme_assistant/carousel/available_arrows/prev',
				array(
					'fa fa-angle-left'          => __( 'Angle', 'rx-theme-assistant' ),
					'fa fa-chevron-left'        => __( 'Chevron', 'rx-theme-assistant' ),
					'fa fa-angle-double-left'   => __( 'Angle Double', 'rx-theme-assistant' ),
					'fa fa-arrow-left'          => __( 'Arrow', 'rx-theme-assistant' ),
					'fa fa-caret-left'          => __( 'Caret', 'rx-theme-assistant' ),
					'fa fa-long-arrow-left'     => __( 'Long Arrow', 'rx-theme-assistant' ),
					'fa fa-arrow-circle-left'   => __( 'Arrow Circle', 'rx-theme-assistant' ),
					'fa fa-chevron-circle-left' => __( 'Chevron Circle', 'rx-theme-assistant' ),
					'fa fa-caret-square-o-left' => __( 'Caret Square', 'rx-theme-assistant' ),
				)
			);

		}

		/**
		 * Return availbale arrows list
		 * @return [type] [description]
		 */
		public function get_available_next_arrows_list() {

			return apply_filters(
				'rx_theme_assistant/carousel/available_arrows/next',
				array(
					'fa fa-angle-right'          => __( 'Angle', 'rx-theme-assistant' ),
					'fa fa-chevron-right'        => __( 'Chevron', 'rx-theme-assistant' ),
					'fa fa-angle-double-right'   => __( 'Angle Double', 'rx-theme-assistant' ),
					'fa fa-arrow-right'          => __( 'Arrow', 'rx-theme-assistant' ),
					'fa fa-caret-right'          => __( 'Caret', 'rx-theme-assistant' ),
					'fa fa-long-arrow-right'     => __( 'Long Arrow', 'rx-theme-assistant' ),
					'fa fa-arrow-circle-right'   => __( 'Arrow Circle', 'rx-theme-assistant' ),
					'fa fa-chevron-circle-right' => __( 'Chevron Circle', 'rx-theme-assistant' ),
					'fa fa-caret-square-o-right' => __( 'Caret Square', 'rx-theme-assistant' ),
				)
			);

		}

		/**
		 * Returns carousel arrow
		 *
		 * @param  array $classes Arrow additional classes list.
		 * @return string
		 */
		public function get_carousel_arrow( $classes ) {

			$format = apply_filters( 'rx-theme-assistant/carousel/arrows_format', '<i class="%s rx-theme-assistant-arrow"></i>', $classes );

			return sprintf( $format, implode( ' ', $classes ) );
		}

		/**
		 * Check if we currently in Elementor editor mode
		 *
		 * @return void
		 */
		public function is_edit_mode() {

			$result = false;

			if ( Plugin::instance()->editor->is_edit_mode() ) {
				$result = true;
			}
			return $result;
		}

		/**
		 * [elementor description]
		 * @return [type] [description]
		 */
		public function elementor() {
			return Plugin::$instance;
		}

		/**
		 * Check if we currently in Elementor mode
		 *
		 * @return void
		 */
		public function in_elementor() {

			$result = false;

			if ( wp_doing_ajax() ) {
				$result = $this->is_elementor_ajax;
			} elseif ( $this->elementor()->editor->is_edit_mode()
				|| $this->elementor()->preview->is_preview_mode() ) {
				$result = true;
			}

			return $result;
		}

		/**
		 * Check blop pages
		 *
		 * @return void
		 */
		function is_blog(){
			global $post;

			$post_type = get_post_type( $post );

			return ( $post_type === 'post' ) && ( is_archive() || is_single() || is_author() || is_tag() || is_category() || is_home() ) || is_search();
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance( $shortcodes = array() ) {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self( $shortcodes );
			}
			return self::$instance;
		}
	}

}

/**
 * Returns instance of Rx_Theme_Assistant_Tools
 *
 * @return object
 */
function rx_theme_assistant_tools() {
	return Rx_Theme_Assistant_Tools::get_instance();
}
