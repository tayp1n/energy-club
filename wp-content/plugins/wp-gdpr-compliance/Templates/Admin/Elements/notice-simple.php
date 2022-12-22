<?php

/**
 * @var string $type
 * @var string $message
 * @var bool $dismissible
 */

if( empty($message) ) return;
if( !empty($dismissible) ) $type .= ' is-dismissible';

?>
<div class="notice notice-<?php echo $type; ?>">
	<p class="wp-notice"><?php echo $message; ?></p>
</div>
