<?php

/**
 * @var string $id
 * @var string $text
 * @var bool $sr_only
 * @var string $info
 */

$classes = [ 'wpgdprc-form__label' ];
if( !empty( $sr_only ) ) $classes[] = 'screen-reader-text';
$class   = implode( ' ', $classes );

?>

<label for="<?php echo $id; ?>" class="<?php echo $class; ?>">
    <?php echo $text; ?>
    <?php if (!empty($info)): ?>
        <span title="<?php echo $info; ?>" class="wpgdprc-label__info">i</span>
    <?php endif; ?>
</label>
