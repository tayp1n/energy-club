<?php
/**
 * Loop item title
 */

rx_theme_assistant_post_tools()->get_post_date( array(
	'visible' => $this->get_attr( 'show_date' ),
	'class'   => 'post__date-link',
	'icon'    => '',
	'date_format'	=> 'd M',
	'html'    => '<div class="post__date post-meta__item"><span><time datetime="%5$s" title="%5$s">%7$s</time></span></div>',
	'echo'    => true,
) );

if ( 'yes' !== $this->get_attr( 'show_title' ) ) {
	$this->render_meta( 'title_related', 'rx-theme-assistant-title-fields', array( 'before', 'after' ) );
	return;
}

$title_length = -1;
$title_ending = $this->get_attr( 'title_trimmed_ending_text' );

if ( filter_var( $this->get_attr( 'title_trimmed' ), FILTER_VALIDATE_BOOLEAN ) ) {
	$title_length = $this->get_attr( 'title_length' );
}

$this->render_meta( 'title_related', 'rx-theme-assistant-title-fields', array( 'before' ) );

rx_theme_assistant_post_tools()->get_post_title( array(
	'class'  => 'entry-title',
	'html'   => '<h4 %1$s><a href="%2$s">%4$s</a></h4>',
	'length' => $title_length,
	'ending' => $title_ending,
	'echo'   => true,
) );

$this->render_meta( 'title_related', 'rx-theme-assistant-title-fields', array( 'after' ) );
