<?php
/**
 * Posts loop start template
 */

$classes = array(
	'rx-theme-assistant-posts',
	'col-row',
	rx_theme_assistant_tools()->gap_classes( $this->get_attr( 'columns_gap' ), $this->get_attr( 'rows_gap' ) ),
);

$equal = $this->get_attr( 'equal_height_cols' );

if ( $equal ) {
	$classes[] = 'rx-theme-assistant-equal-cols';
}

?>
<div class="<?php echo implode( ' ', $classes ); ?>">
