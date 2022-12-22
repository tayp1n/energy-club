<?php
$settings = $this->get_settings();
?>
<div class="rx-search"><?php
	if ( 'true' === $settings['show_search_in_popup'] ) {
		include $this->__get_global_template( 'popup' );
	} else {
		include $this->__get_global_template( 'form' );
	}
?></div>
