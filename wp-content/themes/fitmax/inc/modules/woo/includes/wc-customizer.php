<?php
/**
 * WooCommerce customizer options
 *
 * @package Rvdx Theme
 */

if ( ! function_exists( 'rvdx_theme_set_wc_dynamic_css_options' ) ) {

	/**
	 * Add dynamic WooCommerce styles
	 *
	 * @param $options
	 *
	 * @return mixed
	 */
	function rvdx_theme_set_wc_dynamic_css_options( $options ) {

		array_push( $options['css_files'], get_theme_file_path( 'inc/modules/woo/assets/css/dynamic/woo-module-dynamic.css' ) );

		return $options;

	}

}
add_filter( 'rvdx-theme/dynamic_css/options', 'rvdx_theme_set_wc_dynamic_css_options' );
