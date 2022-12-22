<?php
/**
 * Start installation button
 */
?>
<a href="<?php echo rx_theme_wizard()->get_page_link( array( 'step' => 1, 'advanced-install' => 2 ) ); ?>" data-loader="true" class="btn btn-primary start-install">
	<span class="text"><?php esc_html_e( 'Start Theme Setup', 'rx-theme-wizard' ); ?></span>
	<span class="rx-theme-wizard-loader"><span class="rx-theme-wizard-loader__spinner"></span></span>
</a>
