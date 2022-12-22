<?php
/**
 * WooCommerce single product hooks.
 *
 * @package Rvdx Theme
 */

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 1 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );

add_action( 'woocommerce_before_single_product_summary', 'rvdx_theme_single_product_row_open', 1 );
add_action( 'woocommerce_after_single_product_summary', 'rvdx_theme_single_product_row_close', 5 );

add_action( 'woocommerce_before_single_product_summary', 'rvdx_theme_single_product_images_column_open', 1 );
add_action( 'woocommerce_before_single_product_summary', 'rvdx_theme_single_product_images_column_close', 30 );

add_action( 'woocommerce_before_single_product_summary', 'rvdx_theme_single_product_content_column_open', 40 );
add_action( 'woocommerce_after_single_product_summary', 'rvdx_theme_single_product_content_column_close', 1 );
add_filter( 'woocommerce_product_thumbnails_columns', 'rvdx_theme_wc_product_thumbnails_columns' );

if ( ! function_exists( 'rvdx_theme_single_product_row_open' ) ) {

	/**
	 * Content single product row open
	 */
	function rvdx_theme_single_product_row_open() {
		echo '<div class="row">';
	}

}

if ( ! function_exists( 'rvdx_theme_single_product_row_close' ) ) {

	/**
	 * Content single product row open
	 */
	function rvdx_theme_single_product_row_close() {
		echo '</div>';
	}

}

if ( ! function_exists( 'rvdx_theme_single_product_images_column_open' ) ) {

	/**
	 * Content single product images column open
	 */
	function rvdx_theme_single_product_images_column_open() {
		echo '<div class="col-xs-12 col-sm-6 col-md-6">';
	}

}

if ( ! function_exists( 'rvdx_theme_single_product_images_column_close' ) ) {

	/**
	 * Content single product images column close
	 */
	function rvdx_theme_single_product_images_column_close() {
		echo '</div>';
	}

}

if ( ! function_exists( 'rvdx_theme_single_product_content_column_open' ) ) {

	/**
	 * Content single product content column open
	 */
	function rvdx_theme_single_product_content_column_open() {
		echo '<div class="col-xs-12 col-sm-6 col-md-6">';
	}

}

if ( ! function_exists( 'rvdx_theme_single_product_content_column_close' ) ) {

	/**
	 * Content single product content column close
	 */
	function rvdx_theme_single_product_content_column_close() {
		echo '</div>';
	}

}

if ( ! function_exists( 'rvdx_theme_wc_product_thumbnails_columns' ) ) {

	/**
	 * Return product thumbnails count
	 *
	 * @return int
	 */
	function rvdx_theme_wc_product_thumbnails_columns(){
		return 6;
	}

}
