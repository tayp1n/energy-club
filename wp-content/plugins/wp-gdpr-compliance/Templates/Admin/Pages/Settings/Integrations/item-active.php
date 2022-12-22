<?php

use WPGDPRC\WordPress\Plugin;

/**
 * @var bool $enabled
 */

$class = !empty($enabled) ? '' : 'is-hidden';

?>
<span class="wpgdprc-label wpgdprc-label--success <?php echo $class; ?>">
	<?php _ex('Active', 'admin', 'wp-gdpr-compliance'); ?>
</span>
