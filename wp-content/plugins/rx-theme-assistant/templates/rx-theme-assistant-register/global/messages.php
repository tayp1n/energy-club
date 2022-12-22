<?php
/**
 * Registration messages
 */

$message = wp_cache_get( 'rx-register-messages' );

if ( ! $message ) {
	return;
}

?>
<div class="rx-register-message"><?php
	echo $message;
?></div>