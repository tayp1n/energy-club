<?php
/**
 * Navigation template
 */
?>
<?php
	$args[ 'prev_text' ] = sprintf( '
		<span class="screen-reader-text">%1$s</span>
		<i class="fa fa-angle-left" aria-hidden="true"></i> %1$s',
		esc_html__( 'Older Posts', 'rx-theme-assistant' ) );
	$args[ 'next_text' ] = sprintf( '
		<span class="screen-reader-text">%1$s</span>
		%1$s <i class="fa fa-angle-right" aria-hidden="true"></i>',
		esc_html__( 'Newer Posts', 'rx-theme-assistant' ) );

	the_posts_navigation( $args );
?>
