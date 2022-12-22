<?php

use WPGDPRC\WordPress\Plugin;

/**
 * @var string $label
 */

?>

<li class="wpgdprc-form__field wpgdprc-form__field--checkbox">
    <input class="wpgdprc-form__input wpgdprc-form__input--checkbox" type="checkbox" name="<?php echo Plugin::PREFIX; ?>_consent" id="wpgdprc-form__consent" value="1" required />
    <label class="wpgdprc-form__label" for="wpgdprc-form__consent"><?php echo $label; ?></label>
</li>
