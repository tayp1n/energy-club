<?php
/**
 * Logout Link template
 */
if ( ! $settings['show_logout_link'] ) {
	return;
}

if ( ! is_user_logged_in() && ! rx_theme_assistant_integration()->in_elementor() ) {
	return;
}

$prefix       = $this->__get_html( 'logout_prefix', '<div class="rx-auth-links__prefix">%s</div>' );
$current_user = wp_get_current_user();

?>
<div class="rx-auth-links__section rx-auth-links__logout">
	<?php printf( $prefix, $current_user->display_name ); ?>
	<a class="rx-auth-links__item" href="<?php echo $this->__logout_url(); ?>"><?php
		echo $this->__get_icon( 'logout_link_icon', '%s', 'rx-auth-links__item-icon' );
		$this->__html( 'logout_link_text', '<span class="rx-auth-links__item-text">%s</span>' );
	?></a>
</div>
