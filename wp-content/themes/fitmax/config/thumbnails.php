<?php
/**
 * Thumbnails configuration.
 *
 * @package Rvdx Theme
 */

add_action( 'after_setup_theme', 'rvdx_theme_register_image_sizes', 5 );
function rvdx_theme_register_image_sizes() {
	set_post_thumbnail_size( 370, 265, true );

	add_image_size( 'rvdx-theme-thumb-m-2', 570, 450, true );
	add_image_size( 'rvdx-theme-thumb-l', 1170, 650, true );
	add_image_size( 'rvdx-theme-thumb-masonry', 650, 350, false );
	add_image_size( 'rvdx-theme-thumb-prod', 170, 350, false );
	add_image_size( 'rvdx-theme-thumb-single-prod', 600, 600, false );
}
