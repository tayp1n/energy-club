<?php
$this->add_render_attribute( 'cart-link', 'href', esc_url( wc_get_cart_url() ) );
$this->add_render_attribute( 'cart-link', 'class', 'rx-cart__heading-link' );
$this->add_render_attribute( 'cart-link', 'title', esc_attr__( 'View your shopping cart', 'rx-theme-assistant' ) );

?>
<a <?php echo $this->get_render_attribute_string( 'cart-link' ); ?>><?php

	echo $this->__get_icon( 'cart_icon', '<span class="rx-cart__icon">%s</span>' );
	$this->__html( 'cart_label', '<span class="rx-cart__label">%s</span>' );

	if ( 'yes' === $settings['show_count'] ) {
		?>
		<span class="rx-cart__count"><?php
			ob_start();
			include $this->__get_global_template( 'cart-count' );
			printf( $settings['count_format'], ob_get_clean() );
		?></span>
		<?php
	}

	if ( 'yes' === $settings['show_total'] ) {
		?>
		<span class="rx-cart__total"><?php
			ob_start();
			include $this->__get_global_template( 'cart-totals' );
			printf( $settings['total_format'], ob_get_clean() );
		?></span>
		<?php
	}

?></a>
