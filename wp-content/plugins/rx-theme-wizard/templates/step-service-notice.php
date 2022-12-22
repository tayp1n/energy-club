<?php
/**
 * Template for service notice step.
 */
$_GET['advanced-install'] = '1';

$skins = rx_theme_wizard_interface()->get_skins();
$default_skin = $skins['default'];

$additional_info = isset( $default_skin['additional_info'] ) ? $default_skin['additional_info'] : false;

$title = $additional_info['title'];
$description = $additional_info['description'];
$thumb = $default_skin['thumb'];

?>
<h2><?php echo $title; ?></h2>
<div class="rx-theme-wizard-row">
	<div class="rx-theme-wizard-col col-6">
		<img class="rx-theme-wizard-item__thumb" src="<?php echo $thumb; ?>" alt="">
	</div>
	<div class="rx-theme-wizard-col col-6">
		<div class="rx-theme-wizard-item__info">
			<h4><?php esc_html_e( 'About Theme', 'rx-theme-wizard' ); ?></h4>
			<div><?php echo $description; ?></div>
		</div>

		<div class="rx-theme-wizard-item__info">
			<h4><?php esc_html_e( 'Your hosting information:', 'rx-theme-wizard' ); ?></h4>
			<?php echo rx_theme_wizard_interface()->server_notice();

			$errors = wp_cache_get( 'errors', 'rx-theme-wizard' );

			if ( $errors ) {
				printf(
					'<div class="tm-warning-notice">%s</div>',
					esc_html__( 'Not all of your server parameters met requirements. You can continue the installation process, but it will take more time and can probably drive to bugs.', 'rx-theme-wizard' )
				);
			}?>
		</div>

		<div class="rx-theme-wizard-item__info">
			<div class="rx-theme-wizard-msg"><?php esc_html_e( 'Theme wizard will guide you through the process of recommended plugins installation and demo content importing. Before gettings started make sure your server complies with ', 'rx-theme-wizard' ); ?> <b><?php esc_html_e( 'WordPress minimal requirements.', 'rx-theme-wizard' ); ?></b></div>

			<div class="rx-theme-wizard-item__actions">
				<?php
					rx_theme_wizard_interface()->the_skin( 'default', $default_skin );

					$skin = rx_theme_wizard_interface()->get_skin_data( 'slug' );
					echo rx_theme_wizard_interface()->get_install_skin_button( $skin );
				?>
				<a href="<?php echo rx_theme_wizard_interface()->get_skin_data( 'demo' ) ?>" data-loader="true" class="btn btn-default"><span class="text"><?php
					esc_html_e( 'View Demo', 'rx-theme-wizard' );
				?></span><span class="rx-theme-wizard-loader"><span class="rx-theme-wizard-loader__spinner"></span></span></a>
			</div>
		</div>
	</div>
</div>

<?php Rx_Theme_Wizard_Skin_Installer()->get_theme_skins(); ?>

<?php
if ( $additional_info ) {

	$info_blocks = $additional_info['info_blocks'];
	$social_links = $additional_info['social_links'];

	?><div class="rx-theme-wizard-info-blocks rx-theme-wizard-row">
	<div class="rx-theme-wizard-col col-12">
	<h2><?php esc_html_e( 'Template Information', 'rx-theme-wizard' ); ?></h2>
	</div>
		<?php
		foreach ( $info_blocks as $key => $data ) {
			$block_thumb = $data['thumb'];
			$block_title = $data['title'];
			$block_description = $data['description'];
			$block_link_text = $data['link_text'];
			$block_link = $data['link'];
			?>
			<div class="rx-theme-wizard-info-blocks__item">
				<div class="rx-theme-wizard-info-blocks__item-inner">
					<img src="<?php echo $block_thumb; ?>" alt="">
					<h4><?php echo $block_title; ?></h4>
					<p><?php echo $block_description; ?></p>
					<a class="more-link" target="_blank" href="<?php echo $block_link; ?>"><span><?php echo $block_link_text; ?></span></a>
				</div>
			</div><?php
		}
	?></div><?php
}
