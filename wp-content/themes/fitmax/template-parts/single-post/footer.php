<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rvdx Theme
 */

?>

<footer class="entry-footer">
	<div class="entry-meta"><?php
		rvdx_theme_post_tags ( array(
			'prefix'    => esc_html__( 'Tags:', 'fitmax' ),
			'delimiter' => ', '
		) );
	?></div>
</footer><!-- .entry-footer -->
