<?php
/**
 * The template for displaying related posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Rvdx Theme
 * @subpackage single-post
 */
?>
<div class="related-post <?php echo esc_attr( $grid_class ); ?>">
	<div class="related-post-item">
		<?php
		if ( $settings['image_visible'] ) :
			rvdx_theme_post_thumbnail( 'rvdx-theme-thumb-l' );
		endif; ?>
		<div class="related-post-info">
			<div class="entry-meta">
				<?php
				if ( $settings['date_visible'] ) :
					rvdx_theme_posted_on();
				endif;
				?>
			</div>
			<header class="entry-header">
				<?php
				if ( $settings['title_visible'] ) :
					printf(
						'<h3 class="entry-title"><a href="%s" rel="bookmark">%s</a></h3>',
						esc_url( get_permalink() ),
						get_the_title()
					);
				endif; ?>
			</header>
			<div class="entry-content">
				<?php

				if ( $settings['excerpt_visible'] ) :
					printf('<p>%s</p>', wp_trim_words( get_the_excerpt(), 15, '...' ) );
				endif; ?>

				<?php
				if ( $settings['author_visible'] ) :
					rvdx_theme_posted_by();
				endif;

				rvdx_theme_post_comments( array(
					'class'  => 'comments-button',
					'visible'  => $settings['comment_count_visible']
				) );
				?>
			</div>
		</div>
		<div class="related-btn-cover">
			<?php
			if ( $settings['button_visible'] ) :
				rvdx_theme_post_link();
			endif;
			?>
		</div>
	</div>
</div>
