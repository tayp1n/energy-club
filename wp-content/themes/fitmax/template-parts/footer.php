<?php
/**
 * The template for displaying the default footer layout.
 *
 * @package Rvdx Theme
 */
?>

<?php do_action( 'rvdx-theme/widget-area/render', 'footer-area' ); ?>

<div <?php rvdx_theme_footer_class(); ?>>
	<div class="space-between-content"><?php
		rvdx_theme_footer_copyright();
		rvdx_theme_social_list( 'footer' );
	?></div>
</div><!-- .container -->
