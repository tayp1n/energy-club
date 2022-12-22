<?php
/**
 * WooCommerce page title template
 */

$title = woocommerce_page_title( false ) ? '<h1 class="woocommerce-products-header__title page-title">' . woocommerce_page_title( false ) . '</h1>' : '';

if ( !is_shop() && !is_product_taxonomy() ){
	return;
}

?>
<header class="page-header site-header__wrap">
	<div class="container woocommerce-products-header">
		<?php echo wp_kses_post( $title ); ?>
		<?php  get_template_part( 'template-parts/breadcrumbs' ); ?>
	</div>
</header><!-- .page-header -->