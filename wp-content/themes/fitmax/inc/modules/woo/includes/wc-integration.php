<?php
/**
 * Extends basic functionality for better WooCommerce compatibility
 *
 * @package Rvdx Theme
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function rvdx_theme_wc_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

add_action( 'after_setup_theme', 'rvdx_theme_wc_setup' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 *
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function rvdx_theme_wc_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}

add_filter( 'body_class', 'rvdx_theme_wc_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 *
 * @return array $args related products args.
 */
function rvdx_theme_wc_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 4,
		'columns'        => 4,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}

add_filter( 'woocommerce_output_related_products_args', 'rvdx_theme_wc_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'rvdx_theme_wc_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function rvdx_theme_wc_wrapper_before() {
		?>
			<div <?php rvdx_theme_content_class() ?>>
			<div class="row">
			<div id="primary" <?php rvdx_theme_primary_content_class(); ?>>
			<main id="main" class="site-main">
		<?php
			woocommerce_taxonomy_archive_description();
			woocommerce_product_archive_description();
	}
}

add_action( 'woocommerce_before_main_content', 'rvdx_theme_wc_wrapper_before' );

if ( ! function_exists( 'rvdx_theme_wc_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
function rvdx_theme_wc_wrapper_after() {
	?>
	</main><!-- #main -->
	</div><!-- #primary -->
	<?php
}
}
add_action( 'woocommerce_after_main_content', 'rvdx_theme_wc_wrapper_after' );


if ( ! function_exists( 'rvdx_theme_wc_sidebar_after' ) ) {
	/**
	 * Close tags after sidebar
	 */
	function rvdx_theme_wc_sidebar_after() {
		?>
			</div>
			</div>
		<?php
	}
}
add_action( 'woocommerce_sidebar', 'rvdx_theme_wc_sidebar_after', 99 );


/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
 * <?php
 * if ( function_exists( 'rvdx_theme_wc_header_cart' ) ) {
 * rvdx_theme_wc_header_cart();
 * }
 * ?>
 */

if ( ! function_exists( 'rvdx_theme_wc_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 *
	 * @return array Fragments to refresh via AJAX.
	 */
	function rvdx_theme_wc_cart_link_fragment( $fragments ) {
		ob_start();
		rvdx_theme_wc_cart_link();
		$fragments['a.header-cart__link'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'add_to_cart_fragments', 'rvdx_theme_wc_cart_link_fragment' );

if ( ! function_exists( 'rvdx_theme_wc_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function rvdx_theme_wc_cart_link() {
		?>
			<a class="header-cart__link" href="#" title="<?php esc_attr_e( 'View your shopping cart', 'fitmax' ); ?>">
		  <?php
		  $item_count_text = sprintf(
		  /* translators: number of items in the mini cart. */
			  esc_html__( '%d', 'fitmax' ),
			  WC()->cart->get_cart_contents_count()
		  );

		  ?>
				<i class="header-cart__link-icon"></i>
				<span class="header-cart__link-count"><?php echo esc_html( $item_count_text ); ?></span>
			</a>
		<?php
	}
}

if ( ! function_exists( 'rvdx_theme_wc_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function rvdx_theme_wc_header_cart() {
		add_filter( 'woocommerce_widget_cart_is_hidden', function(){ return false; } );
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
			<div class="header-cart">
				<div class="header-cart__link-wrap <?php echo esc_attr( $class ); ?>">
			<?php rvdx_theme_wc_cart_link(); ?>
				</div>
				<div class="header-cart__content">
			<?php
			$instance = array( 'title' => esc_html__( 'My cart', 'fitmax' ) );
			the_widget( 'WC_Widget_Cart', $instance );
			?>
				</div>
			</div>
		<?php
	}
}

add_action( 'rvdx-theme/top-panel/elements-right', 'rvdx_theme_wc_header_cart' );

if ( ! function_exists( 'rvdx_theme_wc_pagination' ) ) {

	/**
	 * WooCommerce pagination
	 *
	 * @param $args
	 *
	 * @return mixed
	 */
	function rvdx_theme_wc_pagination( $args ) {
		$args['prev_text'] = sprintf( '
		<span class="nav-icon icon-prev"></span><span>%1$s</span>',
			esc_html__( 'Prev', 'fitmax' ) );

		$args['next_text'] = sprintf( '
		<span>%1$s</span><span class="nav-icon icon-next"></span>',
			esc_html__( 'Next', 'fitmax' ) );

		return $args;
	}

}
add_filter( 'woocommerce_pagination_args', 'rvdx_theme_wc_pagination' );

if ( ! function_exists( 'rvdx_theme_init_wc_properties' ) ) {

	/**
	 * Init shop properties
	 */
	function rvdx_theme_init_wc_properties() {

		// Sidebar properties for archive product
		if ( ( is_shop() || is_product_taxonomy() ) && ! is_singular( 'product' ) ) {
			if ( is_active_sidebar( 'sidebar-shop' ) ) {
				rvdx_theme()->sidebar_position = 'one-left-sidebar';
			} else {
				rvdx_theme()->sidebar_position = 'none';
			}
		}

	}

}
add_action( 'wp_head', 'rvdx_theme_init_wc_properties', 2 );
