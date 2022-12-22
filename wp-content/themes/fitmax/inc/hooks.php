<?php
/**
 * Theme hooks.
 *
 * @package Rvdx Theme
 */

use WPGDPRC\Includes\Integration;
use WPGDPRC\Includes\Extensions\WP;

// Adds the meta viewport to the header.
add_action( 'wp_head', 'rvdx_theme_meta_viewport', 0 );

// Additional body classes.
add_filter( 'body_class', 'rvdx_theme_assistant_body_classes' );

// Enqueue sticky menu if required.
add_filter( 'rvdx-theme/assets-depends/script', 'rvdx_theme_enqueue_misc' );

// Additional image sizes for media gallery.
add_filter( 'image_size_names_choose', 'rvdx_theme_image_size_names_choose' );

// Modify a comment form.
add_filter( 'comment_form_defaults', 'rvdx_theme_modify_comment_form' );

// Modify a nav menu.
add_filter( 'widget_nav_menu_args', 'rvdx_theme_modify_nav_menu', 10, 4 );

// Render macros in widget text.
add_filter( 'widget_text', 'rvdx_theme_widget_text_parse_content', 10, 1 );

add_filter( 'wpgdprc_wordpress_field', 'rvdx_theme_wpgdprc_wordpress_field', 10, 2 );

add_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 40 );

add_filter( 'woocommerce_gallery_image_size', 'rvdx_woocommerce_gallery_image_size', 10 );

// woo single
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 11 );

// Add a pingback url auto-discovery header for single posts, pages, or attachments.
add_action( 'wp_head', 'rvdx_theme_pingback_header' );
/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
  *
 * @since  1.0.0
 * @return string `<link>` tag for pingback.
 */
function rvdx_theme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

/**
 * Adds the meta viewport to the header.
 *
 * @since  1.0.0
 * @return string `<meta>` tag for viewport.
 */
function rvdx_theme_meta_viewport() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";
}

/**
 * Add extra body classes
 *
 * @param  array $classes Existing classes.
 * @return array
 */
function rvdx_theme_assistant_body_classes( $classes ) {
	global $post;

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( ! rvdx_theme_is_top_panel_visible() ) {
		$classes[] = 'top-panel-invisible';
	}

	// Adds a options-based classes.
	$options_based_classes = array();

	$layout      = rvdx_theme()->customizer->get_value( 'container_type' );
	$blog_layout = rvdx_theme()->customizer->get_value( 'blog_layout_type' );
	$page_preloader = ( rvdx_theme()->customizer->get_value( 'page_preloader' ) ) ? 'website-loading' : '' ;
	$sb_position = rvdx_theme()->sidebar_position;
	$sidebar     = rvdx_theme()->customizer->get_value( 'sidebar_width' );
	$post_name   = ! empty( $post->post_name ) ? $post->post_name : '';

	array_push( $options_based_classes, 'layout-' . $layout, 'blog-' . $blog_layout, $post_name, $page_preloader );
	if( 'none' !== $sb_position ) {
		array_push( $options_based_classes, 'sidebar_enabled', 'position-' . $sb_position, 'sidebar-' . str_replace( '/', '-', $sidebar ) );
	}

	return array_merge( $classes, $options_based_classes );
}

/**
 * Add misc to theme script dependencies if required.
 *
 * @param  array $depends Default dependencies.
 * @return array
 */
function rvdx_theme_enqueue_misc( $depends ) {
	$totop_visibility = rvdx_theme()->customizer->get_value( 'totop_visibility' );

	if ( $totop_visibility ) {
		$depends[] = 'jquery-totop';
	}

	return $depends;
}

/**
 * Add image sizes for media gallery
 *
 * @param  array $classes Existing classes.
 * @return array
 */
function rvdx_theme_image_size_names_choose( $image_sizes ) {
	$image_sizes['post-thumbnail'] = esc_html__( 'Post Thumbnail', 'fitmax' );

	return $image_sizes;
}

/**
 * Add placeholder attributes for comment form fields.
 *
 * @param  array $args Argumnts for comment form.
 * @return array
 */
function rvdx_theme_modify_comment_form( $args ) {
	$args = wp_parse_args( $args );

	if ( ! isset( $args['format'] ) ) {
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
	}

	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );
	$html_req  = ( $req ? " required='required'" : '' );
	$html5     = 'html5' === $args['format'];
	$commenter = wp_get_current_commenter();

	$args['label_submit'] = esc_html__( 'Submit Comment', 'fitmax' );

	$args['fields']['author'] = '<p class="comment-form-author"><input id="author" class="comment-form__field" name="author" type="text" placeholder="' . esc_attr__( 'Name', 'fitmax' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' /></p>';

	$args['fields']['email'] = '<p class="comment-form-email"><input id="email" class="comment-form__field" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' placeholder="' . esc_attr__( 'E-mail', 'fitmax' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p>';

	$args['fields']['url'] = '<p class="comment-form-url"><input id="url" class="comment-form__field" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' placeholder="' . esc_attr__( 'Website', 'fitmax' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>';

	$args['comment_field'] = '<p class="comment-form-comment"><textarea id="comment" class="comment-form__field" name="comment" placeholder="' . esc_attr__( 'Comments *', 'fitmax' ) . '" cols="45" rows="7" aria-required="true" required="required"></textarea></p>';

	return $args;
}

/**
 * Adds an extra div around the menu.
 *
 * @param  array $args Argumnts for nav menu.
 * @return array
 */
function rvdx_theme_modify_nav_menu( $args ) {
	$args['items_wrap'] = '<div class="main-navigation"><div class="main-navigation-inner"><ul id="%1$s" class="%2$s">%3$s</ul></div></div>';

	return $args;
}

function rvdx_theme_wpgdprc_wordpress_field( $submitField ){
	$submitField = '<label style="font-size: 14px; width: 100%;"><i>' . esc_html__('This checkbox is checked because you are an admin','fitmax') . '</i></label>' .
	'<p class="wpgdprc-checkbox"><label><input type="checkbox" name="wpgdprc" id="wpgdprc" value="1" checked="checked" /><span class="check-icon" ></span> ' . Integration::getCheckboxText(WP::ID) . ' <abbr class="required" title="' . esc_attr__('required', 'fitmax') . '">*</abbr></label></p>';

	return $submitField;
}

/**
 * Render macros in widget text
 *
 * @since  1.0.0
 * @return string widget content.
 */
function rvdx_theme_widget_text_parse_content( $content ) {
	$content = rvdx_theme_render_macros( $content );

	return $content;
}

function rvdx_woocommerce_gallery_image_size( $image_size ) {
	return 'rvdx-theme-thumb-single-prod';
}
