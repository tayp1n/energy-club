<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'CX_Breadcrumbs_Extendt' ) ) {

	/**
	 * Define Rx_Theme_Assistant_Elementor_Widget_Extension class
	 */
	class CX_Breadcrumbs_Extendt extends CX_Breadcrumbs {
		/**
		 * Get page title.
		 *
		 * @since 1.0.0
		 */
		public function get_title() {
			if ( false == $this->args['show_title'] || ! $this->page_title ) {
				return;
			}

			switch ( true ) {
				case function_exists( 'is_woocommerce' ) && is_woocommerce():
					remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
					remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
					add_filter( 'woocommerce_show_page_title', '__return_false' );

					$page_title = woocommerce_page_title( false );
				break;

				case is_archive():
					$page_title = get_the_archive_title();
				break;

				case is_404():
					$page_title = $this->get_strings( 'error_404' );
				break;

				default:
					$page_title = $this->page_title;
				break;
			}

			$title = apply_filters(
				'cx_breadcrumbs/page_title',
				sprintf( $this->args['page_title_format'], $page_title ),
				$this->args
			);

			return $title;
		}
	}
}
