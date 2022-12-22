<?php
/**
 * Template part for top panel in header.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Rvdx Theme
 */

// Don't show top panel if all elements are disabled.
if ( ! rvdx_theme_is_top_panel_visible() ) {
	return;
} ?>

<div class="top-panel">
	<div class="container">
		<div class="space-between-content">
			<div class="top-panel-content__left">
				<?php do_action( 'rvdx-theme/top-panel/elements-left' ); ?>
				<?php rvdx_theme_site_description(); ?>
			</div>
			<div class="top-panel-content__right">
				<?php rvdx_theme_social_list( 'header' ); ?>
				<?php do_action( 'rvdx-theme/top-panel/elements-right' ); ?>
			</div>
		</div>
	</div>
</div>
