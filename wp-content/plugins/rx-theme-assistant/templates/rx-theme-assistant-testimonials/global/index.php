<?php
/**
 * Testimonials template
 */

$classes_list[] = 'rx-theme-assistant-testimonials';
$equal_cols     = $this->get_settings( 'equal_height_cols' );

if ( 'true' === $equal_cols ) {
	$classes_list[] = 'rx-theme-assistant-equal-cols';
}

$preset_type = $this->get_settings( 'preset' ) ? $this->get_settings( 'preset' ) : 'default' ;
$classes_list[] = 'rxta-testimonials-preset-' . $preset_type;

$classes = implode( ' ', $classes_list );
?>

<div class="<?php echo $classes; ?>">
	<?php $this->__get_global_looped_template( esc_attr( $preset_type ) . '/testimonials', 'item_list' ); ?>
</div>
