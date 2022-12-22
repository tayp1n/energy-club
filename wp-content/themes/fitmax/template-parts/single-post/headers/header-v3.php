<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rvdx Theme
 */

$author_block_enabled = rvdx_theme()->customizer->get_value( 'single_author_block' );

?>

<div class="single-header-3">
	<header class="entry-header">
		<div class="entry-meta">
			<?php
			rvdx_theme_posted_in( array(
				'prefix'  => '',
				'delimiter' => '',
				'before'    => '<div class="cat-links btn-style">',
				'after'     => '</div>',
			) );
			if ( ! $author_block_enabled ) {
				rvdx_theme_posted_by();
				rvdx_theme_posted_on( array(
					'prefix'  => '',
				) );
			}
			?>
		</div><!-- .entry-meta -->
		<?php the_title( '<h1 class="entry-title h2-style">', '</h1>' ); ?>
	</header><!-- .entry-header -->
</div>
