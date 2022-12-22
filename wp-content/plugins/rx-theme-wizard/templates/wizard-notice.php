<?php
/**
 * Wizard notice template.
 */

$theme = rx_theme_wizard_settings()->get( array( 'texts', 'theme-name' ) );
?>
<div class="rx-theme-wizard-notice notice">
	<div class="rx-theme-wizard-notice__content"><?php
		printf( esc_html__( 'This wizard will help you to install plugins and import demo data for your %s theme. To start the install click the button below!', 'rx-theme-wizard' ), '<b>' . $theme . '</b>' );
	?></div>
	<div class="rx-theme-wizard-notice__actions">
		<a class="rx-theme-wizard-btn" href="<?php echo rx_theme_wizard()->get_page_link(); ?>"><?php
			esc_html_e( 'Start Install', 'rx-theme-wizard' );
		?></a>
		<a class="notice-dismiss" href="<?php echo add_query_arg( array( 'rx_theme_wizard_dismiss' => true, '_nonce' => rx_theme_wizard()->nonce() ) ); ?>"><?php
			esc_html_e( 'Dismiss', 'rx-theme-wizard' );
		?></a>
	</div>
</div>
