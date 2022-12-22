<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rvdx Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('search-item col-sm-12'); ?>>
	<div class="search-post-item">
		<!-- <?php rvdx_theme_post_thumbnail( 'rvdx-theme-thumb-l' ); ?> -->
		<div class="search-post-info">
			<header class="entry-header">
				<div class="entry-meta"><?php
				rvdx_theme_posted_by();
				rvdx_theme_posted_in();
				rvdx_theme_posted_on();
				?></div><!-- .entry-meta -->
				<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>

				<div class="entry-content">
					<?php the_excerpt(); ?>
				</div><!-- .entry-content -->
			</header><!-- .entry-header -->
		</div>
		<div class="search-btn-cover">
			<?php rvdx_theme_post_link(); ?>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
