<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rvdx Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php rvdx_theme_post_thumbnail(); ?>

	<div class="page-content">
		<?php
			the_content();
			wp_link_pages( array(
				'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'fitmax' ),
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .page-content -->

	
</article><!-- #post-<?php the_ID(); ?> -->
