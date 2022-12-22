<?php

use WPGDPRC\WordPress\Plugin;

/**
 * @var string $site_link
 * @var string $admin_link
 */

?>

<?php printf(__('You have received a new anonymize request on %1s.', 'wp-gdpr-compliance'), $site_link); ?>
<br /><br />
<?php printf(__('You can manage this request in the admin panel: %1s', 'wp-gdpr-compliance'), $admin_link); ?>
