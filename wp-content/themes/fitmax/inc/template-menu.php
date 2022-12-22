<?php
/**
 * Menu Template Functions.
 *
 * @package Rvdx Theme
 */

/**
 * Show main menu.
 *
 * @since  1.0.0
 * @return void
 */
function rvdx_theme_main_menu() {

	$classes[] = 'main-navigation ';
	$classes[] = 'default';

	?>
	<nav id="site-navigation" class="<?php echo join( ' ', $classes ); ?>" role="navigation">
		<div class="main-navigation-inner">
		<?php
			$args = apply_filters( 'rvdx-theme/menu/main-menu-args', array(
				'theme_location'   => 'main',
				'container'        => '',
				'menu_id'          => 'main-menu',
				'menu_class'       => 'menu slicknav-menu',
				'fallback_cb'      => '__return_empty_string',
			) );

			wp_nav_menu( $args );
		?>
		</div>
	</nav><!-- #site-navigation -->
	<?php
}

/**
 * Show footer menu.
 *
 * @since  1.0.0
 * @return void
 */
function rvdx_theme_footer_menu() { ?>
	<nav id="footer-navigation" class="footer-menu" role="navigation">
	<?php
		$args = apply_filters( 'rvdx-theme/menu/footer-menu-args', array(
			'theme_location'   => 'footer',
			'container'        => '',
			'menu_id'          => 'footer-menu-items',
			'menu_class'       => 'footer-menu__items',
			'depth'            => 1,
			'fallback_cb'      => '__return_empty_string',
		) );

		wp_nav_menu( $args );
	?>
	</nav><!-- #footer-navigation -->
	<?php
}

/**
 * Get social nav menu.
 *
 * @since  1.0.0
 * @since  1.0.1  Added arguments to the filter.
 * @param  string $context Current post context - 'single' or 'loop'.
 * @param  string $type    Content type - icon, text or both.
 * @return string
 */
function rvdx_theme_get_social_list( $context, $type = 'icon' ) {
	static $instance = 0;
	$instance++;

	$container_class = array( 'social-list' );

	if ( ! empty( $context ) ) {
		$container_class[] = sprintf( 'social-list--%s', sanitize_html_class( $context ) );
	}

	$container_class[] = sprintf( 'social-list--%s', sanitize_html_class( $type ) );

	$args = apply_filters( 'rvdx-theme/social/list-args', array(
		'theme_location'   => 'social',
		'container'        => 'div',
		'container_class'  => join( ' ', $container_class ),
		'menu_id'          => "social-list-{$instance}",
		'menu_class'       => 'social-list__items inline-list',
		'depth'            => 1,
		'link_before'      => ( 'icon' == $type ) ? '<span>' : '',
		'link_after'       => ( 'icon' == $type ) ? '</span>' : '',
		'echo'             => false,
		'fallback_cb'      => '__return_empty_string',
	), $context, $type );

	return wp_nav_menu( $args );
}
