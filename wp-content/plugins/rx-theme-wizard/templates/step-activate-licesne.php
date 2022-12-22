<?php
/**
 * Template for service notice step.
 */
?>
<h2><?php esc_html_e( 'Installation Wizard', 'rx-theme-wizard' ); ?></h2>
<div class="rx-theme-wizard-msg"><?php esc_html_e( 'Theme wizard will guide you through the process of recommended plugins installation and demo content importing. Before gettings started please activate your license key.', 'rx-theme-wizard' ); ?></div>
<div class="rx-theme-wizard-license-form">
	<input type="text" class="rx-theme-wizard-input" placeholder="<?php _e( 'Please enter your license key', 'rx-theme-wizard' ); ?>">
	<a href="#" data-loader="true" class="btn btn-primary rx-theme-wizard-activate-license">
		<span class="text"><?php esc_html_e( 'Activate License', 'rx-theme-wizard' ); ?></span>
		<span class="rx-theme-wizard-loader"><span class="rx-theme-wizard-loader__spinner"></span></span>
	</a>
	<div class="rx-theme-wizard-license-errors"></div>
</div>
