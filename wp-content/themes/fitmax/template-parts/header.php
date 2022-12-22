<?php
/**
 * Template part for default Header layout.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Rvdx Theme
 */
?>

<?php get_template_part( 'template-parts/top-panel' ); ?>

<div <?php rvdx_theme_header_class(); ?>>
	<?php do_action( 'rvdx-theme/header/before' ); ?>
	<div class="space-between-content">
		<div <?php echo rvdx_theme_site_branding_class(); ?>>
			<?php rvdx_theme_header_logo(); ?>
		</div>
		<?php rvdx_theme_main_menu(); ?>
	</div>
	<?php do_action( 'rvdx-theme/header/after' ); ?>
</div>
