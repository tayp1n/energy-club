<?php

use WPGDPRC\WordPress\Plugin;

/**
 * @var bool $required
 */

?>
<?php if( empty($required) ) : ?>
    <span class="wpgdprc-label"><?php _ex('Not required', 'admin', 'wp-gdpr-compliance'); ?></span>
<?php else : ?>
    <span class="wpgdprc-label wpgdprc-label--success"><?php _ex('Required', 'admin', 'wp-gdpr-compliance'); ?></span>
<?php endif; ?>
