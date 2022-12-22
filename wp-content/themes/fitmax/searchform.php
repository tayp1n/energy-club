<?php
/**
 * The template for displaying search form.
 *
 * @package Rvdx Theme
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<span class="screen-reader-text"><?php echo _x( 'Пошук для:', 'label', 'fitmax' ) ?></span>
	<input type="search" class="search-form__field" placeholder="<?php echo esc_attr_x( 'Пошук', 'placeholder', 'fitmax' ) ?>" value="<?php echo get_search_query() ?>" name="s">
	<button type="submit" class="search-form__submit btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
</form>
