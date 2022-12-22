<?php
$settings = $this->get_settings();

$this->add_render_attribute( 'rx-search-popup', 'class', 'rx-search__popup' );

if ( isset( $settings['full_screen_popup'] ) && 'true' === $settings['full_screen_popup'] ) {
	$this->add_render_attribute( 'rx-search-popup', 'class', 'rx-search__popup--full-screen' );
}

if ( isset( $settings['popup_show_effect'] ) ) {
	$this->add_render_attribute( 'rx-search-popup', 'class', sprintf( 'rx-search__popup--%s-effect', $settings['popup_show_effect'] ) );
}
?>
<div <?php $this->print_render_attribute_string( 'rx-search-popup' ); ?>>
	<div class="rx-search__popup-content"><?php
		include $this->__get_global_template( 'form' );
		include $this->__get_global_template( 'popup-close' );
	?></div>
</div>
<?php include $this->__get_global_template( 'popup-trigger' ); ?>