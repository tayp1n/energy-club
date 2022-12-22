<?php
/**
 * Services main template
 */
$classes_list[] = 'rx-theme-assistant-services';

$show_on_hover = $this->get_settings_for_display( 'show_on_hover' );
$header_position = $this->get_settings_for_display( 'header_position' );

$classes_list[] = 'rx-theme-assistant-services--header-position-' . $header_position;

if ( filter_var( $show_on_hover, FILTER_VALIDATE_BOOLEAN ) ) {
	$classes_list[] = 'rx-theme-assistant-services--cover-hover';
}

$classes = implode( ' ', $classes_list );

?>
<div class="<?php echo $classes; ?>">
	<div class="rx-theme-assistant-services__inner">
		<div class="rx-theme-assistant-services__header">
			<div class="rx-theme-assistant-services__cover"><?php
			echo $this->__generate_media( true );
			echo $this->__generate_title( true );
			echo $this->__generate_description( true );
			echo $this->__generate_action_button( true ); ?></div>
		</div>
		<div class="rx-theme-assistant-services__content"><?php
			echo $this->__generate_media();
			echo $this->__generate_title();
			echo $this->__generate_description();
			echo $this->__generate_action_button(); ?></div>
	</div>
</div>
