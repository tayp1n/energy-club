<?php

use WPGDPRC\Utils\Template;

/**
 * @var string $type
 * @var string $icon
 * @var string $title
 * @var string $text
 * @var string $button (optional)
 */

if( empty($type) ) $type = 'notice';
if( $type == 'wizard' ) $type = 'notice wpgdprc-message--large-icon';

?>

<div class="wpgdprc-message wpgdprc-message--<?php echo $type; ?>">
    <div class="wpgdprc-message__container">
        <div class="wpgdprc-message__content">
            <h3 class="wpgdprc-message__title h3"><?php echo $title; ?></h3>
            <p class="wpgdprc-message__text"><?php echo $text; ?></p>
        </div>
        <div class="wpgdprc-message__icon">
            <?php echo $icon; ?>
        </div>
    </div>
    <div class="wpgdprc-message__action">
        <?php if (!empty($button)): ?>
            <button class="wpgdprc-message__button wpgdprc-message__button--close" title="<?php echo esc_attr($button); ?>">
                <span><?php echo $button; ?></span>
                <?php Template::renderIcon('times', 'fontawesome-pro-regular'); ?>
            </button>
        <?php endif; ?>
    </div>
</div>
