<?php

use WPGDPRC\WordPress\Plugin;

/**
 * @var string $email
 * @var string $site_link
 * @var string $delete_link
 * @var string $request_link
 */

?>

<?php printf(__('You have requested to access your data on %1s.', 'wp-gdpr-compliance'), $site_link); ?>
<br /><br />
<?php printf(__('Please visit this %1s to view the data linked to the email address %2s.', 'wp-gdpr-compliance'), $delete_link, $email); ?>
<br /><br />
<?php _e('This page is available for 24 hours and can only be reached from the same device, IP address and browser session you requested from.', 'wp-gdpr-compliance'); ?>
<br /><br />
<?php printf(__('If your link is invalid you can fill in a new request after 24 hours: %1s.', 'wp-gdpr-compliance'), $request_link); ?>
