<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rvdx Theme
 */

$has_post_thumbnail = has_post_thumbnail();
$has_post_thumbnail_class = $has_post_thumbnail ? 'has-post-thumbnail' : '';

?>

<div class="single-header-5 invert <?php echo esc_attr( $has_post_thumbnail_class ); ?>">
	<?php rvdx_theme_post_thumbnail( 'rvdx-theme-thumb-xl', array( 'link' => false ) ); ?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title h2-style">', '</h1>' ); ?>
					<div class="entry-header-bottom">
						<div class="entry-meta"><?php
							if ( rvdx_theme()->customizer->get_value( 'single_post_author' ) ) : ?>
								<span class="post-author">
									<span class="post-author__avatar"><?php
										rvdx_theme_get_post_author_avatar( array(
											'size' => 50
										) );
									?></span>
									<?php rvdx_theme_posted_by();
								?></span>
							<?php endif; ?>
							<?php
								rvdx_theme_posted_on();
								rvdx_theme_posted_in();
						?></div><!-- .entry-meta -->
					</div>
				</header><!-- .entry-header -->
			</div>
		</div>
	</div>
</div>

