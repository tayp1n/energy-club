<?php
/**
 * Register Link template
 */
if ( ! $settings['show_register_link'] ) {
	return;
}

if ( is_user_logged_in() && ! rx_theme_assistant_integration()->in_elementor() ) {
	return;
}

$url = $this->__get_url( $settings, 'register_link_url' );

?>
<div class="rx-auth-links__section rx-auth-links__register">
	<?php $this->__html( 'register_prefix', '<div class="rx-auth-links__prefix">%s</div>' ); ?>
	<a class="rx-auth-links__item" href="<?php echo $url; ?>"><?php
		echo $this->__get_icon( 'register_link_icon', '%s', 'rx-auth-links__item-icon' );
		$this->__html( 'register_link_text', '<span class="rx-auth-links__item-text">%s</span>' );
	?></a>
</div>
