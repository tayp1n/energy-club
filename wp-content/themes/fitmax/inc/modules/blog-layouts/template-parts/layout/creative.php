<?php
/**
 * Template part for displaying creative posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rvdx Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'posts-list__item creative-item' ); ?>>

	<?php rvdx_theme_post_thumbnail( 'rvdx-theme-thumb-l' ); ?>

	<div class="creative-item__content">

		<header class="entry-header">
			<h2 class="entry-title"><?php
				rvdx_theme_sticky_label();
				the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>' );
			?></h2>
		</header><!-- .entry-header -->

		<?php rvdx_theme_post_excerpt(); ?>

		<footer class="entry-footer">
			<div class="entry-meta"><?php
				rvdx_theme_posted_by();
				rvdx_theme_posted_on();
				rvdx_theme_posted_in();
				?><div><?php
					rvdx_theme_post_link();
				?></div>
			</div>
			<?php rvdx_theme_edit_link(); ?>
		</footer><!-- .entry-footer -->

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
