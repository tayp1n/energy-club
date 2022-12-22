<?php

/**
 * @var string $name
 * @var string $label
 */

if( empty($id) ) $id = sanitize_key($name);
$checked = !empty($checked) ? 'checked="checked"' : '';

?>

<p class="wpgdprc-checkbox <?php if( !empty($class) ) echo $class; ?>">
	<input type="checkbox" name="<?php echo $name; ?>" id="<?php echo $id; ?>" value="1" <?php echo $checked; ?> />
	<label for="<?php echo $id; ?>">
        <?php echo $label; ?>
	</label>
</p>
