<?php

use WPGDPRC\Utils\Template;
use WPGDPRC\WordPress\Plugin;

/**
 * @var string $content
 */

?>

<div class="wpgdprc wpgdprc-consent-modal" id="wpgdprc-consent-modal" aria-hidden="true">
    <div class="wpgdprc-consent-modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="wpgdprc-consent-modal__inner" role="dialog" aria-modal="true">
            <div class="wpgdprc-consent-modal__header">
                <p class="wpgdprc-consent-modal__title"><?php _e('Privacy settings', 'wp-gdpr-compliance'); ?></p>
                <button class="wpgdprc-consent-modal__close" aria-label="<?php _e('Close popup', 'wp-gdpr-compliance'); ?>" data-micromodal-close>
                    <?php Template::renderSvg( 'icon-fal-times.svg' ); ?>
                </button>
            </div>
            <?php echo $content; ?>
        </div>
    </div>
</div>
