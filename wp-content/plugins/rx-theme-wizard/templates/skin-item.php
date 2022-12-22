<?php
/**
 * Skin item template
 */

$skin = rx_theme_wizard_interface()->get_skin_data( 'slug' );

?>
<div class="rx-theme-wizard-skin-item">
	<div class="rx-theme-wizard-skin-item-content">
		<?php if ( rx_theme_wizard_interface()->get_skin_data( 'thumb' ) ) : ?>
		<div class="rx-theme-wizard-skin-item__thumb">
			<img src="<?php echo rx_theme_wizard_interface()->get_skin_data( 'thumb' ); ?>" alt="">
		</div>
		<?php endif; ?>
		<div class="rx-theme-wizard-skin-item__summary">
			<h4 class="rx-theme-wizard-skin-item__title"><?php echo rx_theme_wizard_interface()->get_skin_data( 'name' ); ?></h4>
			<div class="rx-theme-wizard-skin-item__actions">
				<?php echo rx_theme_wizard_interface()->get_install_skin_button( $skin ); ?>
				<a href="<?php echo rx_theme_wizard_interface()->get_skin_data( 'demo' ) ?>" data-loader="true" class="btn btn-default"><span class="text"><?php
					esc_html_e( 'View Demo', 'rx-theme-wizard' );
				?></span><span class="rx-theme-wizard-loader"><span class="rx-theme-wizard-loader__spinner"></span></span></a>
			</div>
		</div>
	</div>
</div>
