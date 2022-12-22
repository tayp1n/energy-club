<?php
/**
 * Template part for displaying style-v6 posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rvdx Theme
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'posts-list__item masonry-item' ); ?>>
	<?php rvdx_theme_post_thumbnail( 'rvdx-theme-thumb-masonry' ); ?>
	<div class="masonry-item-wrap">
		<header class="entry-header">
			<div class="entry-meta">
				<?php
				rvdx_theme_posted_by();
				rvdx_theme_posted_in();
				rvdx_theme_posted_on();
				?>
			</div><!-- .entry-meta -->
			<h3 class="entry-title"><?php
				rvdx_theme_sticky_label();
				the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>' );
			?></h3>
		</header><!-- .entry-header -->
		<?php rvdx_theme_post_excerpt(); ?>

		<footer class="entry-footer">
			<div class="entry-meta">
				<?php
				rvdx_theme_post_comments( array(
					'class'  => 'comments-button'
				) );
				rvdx_theme_post_tags( array(
					'prefix' => esc_html__( 'Tags:', 'fitmax' )
				) );

				$post_more_btn_enabled = strlen( rvdx_theme()->customizer->get_value( 'blog_read_more_text' ) ) > 0 ? true : false;
				$post_comments_enabled = rvdx_theme()->customizer->get_value( 'blog_post_comments' );

				if( $post_more_btn_enabled || $post_comments_enabled ) {
					?><div class="space-between-content"><?php
					rvdx_theme_post_link();
					?></div><?php
				}
				?>
			</div>
			<?php rvdx_theme_edit_link(); ?>
		</footer><!-- .entry-footer -->
	</div><!-- .masonry-item-wrap-->
</article><!-- #post-<?php the_ID(); ?> -->
