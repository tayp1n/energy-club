<?php

use WPGDPRC\Utils\Elements;

/**
 * @var string $title
 */

if( empty( $class ) ) $class = '';
if( empty( $heading ) ) $heading = 3;
if( empty( $title_class ) ) $title_class = '';

?>

<div class="wpgdprc-tile <?php echo esc_attr($class); ?>">
    <div class="wpgdprc-tile__content">
        <?php Elements::heading($title, $heading, [ 'class' => 'wpgdprc-tile__title ' . $title_class ]); ?>
        <?php if( !empty($text) ) : ?>
            <p class="wpgdprc-tile__text"><?php echo $text; ?></p>
        <?php endif; ?>
        <?php if( !empty($extra) ) echo $extra; ?>
    </div>
    <div class="wpgdprc-tile__footer">
        <?php if( !empty($footer) ) echo $footer; ?>
    </div>
</div>