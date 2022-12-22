<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Rvdx Theme
 */

get_header();

do_action( 'rvdx-theme/site/site-content-before', 'search' ); ?>

<div <?php rvdx_theme_content_class() ?>>
	<div class="row">

		<?php do_action( 'rvdx-theme/site/primary-before', 'search' ); ?>

		<div id="primary" class="search-cover">

			<?php do_action( 'rvdx-theme/site/main-before', 'search' ); ?>

			<main id="main" class="site-main"><?php
			if ( have_posts() ) : ?>

				<?php

				rvdx_theme()->do_location( 'archive', 'template-parts/search-loop' );

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?></main><!-- #main -->

			<?php do_action( 'rvdx-theme/site/main-after', 'search' ); ?>

		</div><!-- #primary -->

		<?php do_action( 'rvdx-theme/site/primary-after', 'search' ); ?>

	</div>
	</div><?php
	get_footer();
