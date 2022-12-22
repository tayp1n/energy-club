<?php
/**
 * Loop item more button
 */

if ( 'yes' !== $this->get_attr( 'show_more' ) ) {
	return;
}

rx_theme_assistant_post_tools()->get_post_button( array(
	'class' => 'btn btn-primary elementor-button elementor-size-md rx-theme-assistant-more',
	'text'  => $this->get_attr( 'more_text' ),
	'icon'  => $this->html( $this->get_attr( 'more_icon' ), '<i class="rx-theme-assistant-more-icon %1$s"></i>', array(), false ),
	'html'  => '<div class="rx-theme-assistant-more-wrap"><a href="%1$s" %3$s><span class="btn__text">%4$s</span>%5$s</a></div>',
	'echo'  => true,
) );
