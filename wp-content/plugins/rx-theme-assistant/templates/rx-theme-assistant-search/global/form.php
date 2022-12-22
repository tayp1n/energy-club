<?php
$settings = $this->get_settings();
?>
<form class="rx-search__form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="rx-search__label">
		<input class="rx-search__field" type="search" placeholder="<?php echo esc_attr( $settings['search_placeholder'] ); ?>" value="<?php echo get_search_query(); ?>" name="s">
	</label>
	<?php if ( 'true' === $settings['show_search_submit'] ) : ?>
	<button class="rx-search__submit" type="submit"><?php
		echo $this->__get_icon( 'search_submit_icon', '%s', 'rx-search__submit-icon' );
		$this->__html( 'search_submit_label', '<div class="rx-search__submit-label">%s</div>' );
	?></button>
	<?php endif; ?>
	<?php if ( isset( $settings['is_product_search'] ) && 'true' === $settings['is_product_search'] ) : ?>
		<input type="hidden" name="post_type" value="product">
	<?php endif; ?>
</form>
