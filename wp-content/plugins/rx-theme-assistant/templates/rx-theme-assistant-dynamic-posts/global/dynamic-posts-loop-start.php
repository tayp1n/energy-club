<?php
/**
 * Features list start template
 */

if ( $settings['equal_height_cols'] ) {
	$items_wrapper_class .= ' rxta-dynamic-equal-cols';
}
?>
<div class="<?php echo esc_attr__( $items_wrapper_class ); ?>" <?php echo $options ?> >
