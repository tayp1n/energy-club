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

echo '<div class="post-meta">';
rx_theme_assistant_post_tools()->get_post_author( array(
	'visible' => $this->get_attr( 'show_author' ),
	'class'   => 'posted-by__author',
	'prefix'  =>'<i class="fa fa-user" aria-hidden="true"></i>',
	'html'    => '<span class="posted-by post-meta__item">%1$s <a href="%2$s" %3$s %4$s rel="author">%5$s%6$s</a></span>',
	'echo'    => true,
) );

rvdx_theme_posted_in( array(
	'delimiter' => ', ',
) );

rx_theme_assistant_post_tools()->get_post_comment_count( array(
	'visible' => $this->get_attr( 'show_comments' ),
	'class'   => 'post__comments-link',
	'prefix'  => '<i class="fa fa-comment" aria-hidden="true"></i> ' . esc_html__( 'Comments', 'fitmax' ) . ' ',
	'html'    => '<span class="post__comments post-meta__item">%1$s<a href="%2$s" %3$s %4$s>%5$s%6$s</a></span>',
	'echo'    => true,
) );

rvdx_theme_post_tags( array(
	'prefix' => esc_html__( 'Tags:', 'fitmax' )
) );


echo '</div>';

