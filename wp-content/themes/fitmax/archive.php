<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rvdx Theme
 */

get_header();

	do_action( 'rvdx-theme/site/site-content-before', 'archive' ); ?>

	<div <?php rvdx_theme_content_class() ?>>

		<div class="row">

			<?php do_action( 'rvdx-theme/site/primary-before', 'archive' ); ?>

			<div id="primary" <?php rvdx_theme_primary_content_class(); ?>>

				<?php do_action( 'rvdx-theme/site/main-before', 'archive' ); ?>

				<main id="main" class="site-main"><?php
					if ( have_posts() ) :

						rvdx_theme()->do_location( 'archive', 'template-parts/posts-loop' );

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
				?></main><!-- #main -->

				<?php do_action( 'rvdx-theme/site/main-after', 'archive' ); ?>

			</div><!-- #primary -->

			<?php do_action( 'rvdx-theme/site/primary-after', 'archive' ); ?>

			<?php get_sidebar(); // Loads the sidebar.php template.  ?>
		</div>
	</div>

	<?php do_action( 'rvdx-theme/site/site-content-after', 'archive' );

get_footer();
