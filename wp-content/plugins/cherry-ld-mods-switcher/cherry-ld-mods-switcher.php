<?php
/*
Plugin Name: Cherry Live Demo Mods Switcher
Description: Cherry Live Demo Mods Switcher
Plugin URI:
Author: Cherry Team
Author URI:
Version: 1.0
License: GPL2
Text Domain: cherry-ld-mods-switcher
Domain Path: lang
*/

class Cherry_LD_Switcher {

	private $general_options = array(
		'posts_per_page',
		'blogname',
		'blogdescription',
		'date_format',
		'time_format',
	);

	function __construct() {
		add_action( 'after_setup_theme', array( $this, 'init_switcher' ), 10, 0 );
	}

	/**
	 * Attach callback to apropriate hook if is switcher request
	 * @return void
	 */
	function init_switcher() {

		if ( ! isset( $_GET['ld'] ) ) {
			return;
		}

		foreach ( $_GET as $key => $value ) {

			if ( 'ld' === $key ) {
				continue;
			}

			if ( in_array( $key, $this->general_options ) ) {
				add_filter( 'option_' . esc_attr( $key ), array( $this, 'switch_opt_cb' ) );
			} else {
				add_filter( 'theme_mod_' . esc_attr( $key ), array( $this, 'switch_mod_cb' ) );
			}
		}

	}

	/**
	 * Universal switch callback for get theme mod hook
	 *
	 * @param  string $current Current mod value.
	 * @return string
	 */
	function switch_mod_cb( $current ) {
		return $this->switcher( $current, 'theme_mod_' );
	}

	/**
	 * Universal switch callback for get option hook
	 *
	 * @param  string $current Current mod value.
	 * @return string
	 */
	function switch_opt_cb( $current ) {
		return $this->switcher( $current, 'option_' );
	}

	/**
	 * Replace passed value with value from get parameter if exist.
	 *
	 * @param  string $current Current value.
	 * @param  string $context Theme mod or option.
	 * @return string
	 */
	function switcher( $current, $context ) {

		$key = str_replace( $context, '', current_filter() );

		if ( ! isset( $_GET[ $key ] ) ) {
			return $current;
		}

		return esc_attr( $_GET[ $key ] );

	}

}

new Cherry_LD_Switcher();
