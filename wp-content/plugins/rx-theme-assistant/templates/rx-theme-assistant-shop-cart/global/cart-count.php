<?php

use Elementor\Plugin;

$elementor    = Plugin::instance();
$is_edit_mode = $elementor->editor->is_edit_mode();

if ( $is_edit_mode && ! wp_doing_ajax() ) {
	$count = '';
} else {
	$count = WC()->cart->get_cart_contents_count();
}

?>
<span class="rx-cart__count-val"><?php
	echo $count;
?></span>
