<?php

/**
 * @var string $name
 * @var string $value
 * @var string $class
 * @var string $attr
 */

if( empty($id) ) $id = sanitize_key($name);

$classes = [ 'wpgdprc-form__input', 'wpgdprc-form__input--textarea', !empty( $class ) ? $class : 'regular-text' ];
$class   = implode( ' ', $classes );

?>

<textarea id="<?php echo $id; ?>" class="<?php echo $class; ?>" name="<?php echo $name; ?>" <?php echo $attr; ?>><?php echo esc_html( $value ); ?></textarea>
