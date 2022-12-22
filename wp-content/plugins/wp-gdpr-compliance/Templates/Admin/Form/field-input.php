<?php

/**
 * @var string $type
 * @var string $name
 * @var string $value
 * @var string $class
 * @var string $attr
 */

if ( empty( $id ) ) {
	$id = sanitize_key( $name );
}
if ( empty( $type ) ) {
	$type = 'text';
}
?>

<input type="<?php echo $type; ?>" id="<?php echo $id; ?>" class="<?php echo $class; ?>" name="<?php echo $name; ?>"
       value="<?php echo $type === 'text' ? esc_html( $value ) : $value; ?>" <?php echo $attr; ?> />

<?php if ( $type === 'color' ) : ?>
    <input type="text" id="<?php echo $id . '-text'; ?>" class="<?php echo $class . '_text'; ?>"
           name="<?php echo $name . '_text'; ?>" value="<?php echo $value; ?>" <?php echo $attr; ?> />
<?php endif; ?>
