<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Rvdx Theme
 */

?>

<?php

do_action( 'rvdx-theme/sidebar/before' );

if ( is_active_sidebar( 'sidebar' ) && 'none' !== rvdx_theme()->sidebar_position ) : ?>
	<aside id="secondary" <?php rvdx_theme_secondary_content_class( array( 'widget-area' ) ); ?>>
		<div class="widget-area-inner"><?php
			dynamic_sidebar( 'sidebar' );
		?></div>
	</aside><!-- #secondary -->
<?php endif;

do_action( 'rvdx-theme/sidebar/after' );
