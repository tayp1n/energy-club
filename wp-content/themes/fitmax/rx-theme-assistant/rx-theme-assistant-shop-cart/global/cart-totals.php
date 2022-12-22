<?php
$elementor    = Elementor\Plugin::instance();
$is_edit_mode = $elementor->editor->is_edit_mode();

if ( $is_edit_mode && ! wp_doing_ajax() ) {
	$totals = '';
} else {
	$totals = WC()->cart->get_cart_subtotal();
}

?>
<span class="rvdx-cart__total-val"><?php
	printf( '%s', $totals );
?></span>
