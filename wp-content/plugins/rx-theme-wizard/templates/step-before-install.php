<?php
/**
 * 1st wizard step template
 */
?>
<h2><?php rx_theme_wizard_interface()->before_import_title(); ?></h2>
<div class="rx-theme-wizard-msg"><?php esc_html_e( 'Each skin comes with predefined set of plugins and custom demo content. Depending upon the selected skin the wizard will install required plugins and some demo posts and pages. You may select the required and preferable one for the usage.', 'rx-theme-wizard' ); ?></div>
<div class="rx-theme-wizard-skins"><?php
	$skins = rx_theme_wizard_interface()->get_skins();

	if ( ! empty( $skins ) ) {

		foreach ( $skins as $skin => $skin_data ) {
			rx_theme_wizard_interface()->the_skin( $skin, $skin_data );
			rx_theme_wizard()->get_template( 'skin-item.php' );
		}

	}

?></div>
