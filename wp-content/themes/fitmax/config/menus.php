<?php
/**
 * Menus configuration.
 *
 * @package Rvdx Theme
 */

add_action( 'after_setup_theme', 'rvdx_theme_register_menus', 5 );
function rvdx_theme_register_menus() {

	register_nav_menus( array(
		'main'   => esc_html__( 'Main', 'fitmax' ),
		'footer' => esc_html__( 'Footer', 'fitmax' ),
		'social' => esc_html__( 'Social', 'fitmax' ),
	) );
}
