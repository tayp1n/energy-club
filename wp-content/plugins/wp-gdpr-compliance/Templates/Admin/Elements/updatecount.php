<?php

use WPGDPRC\WordPress\Plugin;

/**
 * @var int $count
 */

if( empty($count) ) return;
if( empty($text) ) $text = _x('Update available', 'admin', 'wp-gdpr-compliance');

?>

<span title="<?php echo $text; ?>" class="update-plugins count-<?php echo $count; ?>">
    <span class="update-count">
        <?php echo $count; ?>
    </span>
</span>
