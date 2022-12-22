<?php
/**
 * Loop item contnet
 */

if ( 'yes' !== $this->get_attr( 'show_excerpt' ) ) {
	$this->render_meta( 'content_related', 'rx-theme-assistant-content-fields', array( 'before', 'after' ) );
	return;
}

$this->render_meta( 'content_related', 'rx-theme-assistant-content-fields', array( 'before' ) );

rx_theme_assistant_post_tools()->get_post_content( array(
	'length'       => intval( $this->get_attr( 'excerpt_length' ) ),
	'content_type' => 'post_excerpt',
	'html'         => '<div %1$s>%2$s</div>',
	'class'        => 'entry-excerpt',
	'echo'         => true,
) );

$this->render_meta( 'content_related', 'rx-theme-assistant-content-fields', array( 'after' ) );
