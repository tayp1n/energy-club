<?php
/**
 * Theme import config file.
 *
 * @var array
 *
 * @package Storycle
 */
$theme = wp_get_theme();
$theme_slag = get_template();
$config = array(
	'xml' => false,
	'advanced_import' => array(
		'default' => array(
			'label'    => $theme->get( 'Name' ),
			'full'     => 'https://assets.rovadex.com/demo-content/' . $theme_slag . '/default/default.xml',
			'lite'     => false,
			'thumb'    => get_theme_file_uri( 'screenshot.png' ),
			'demo_url' => 'https://wp.rovadex.com/' . $theme_slag,
		),
	),
	'import' => array(
		'chunk_size' => 3,
	),
	'slider' => array(
		'path' => 'https://raw.githubusercontent.com/JetImpex/wizard-slides/master/slides.json',
	),
	'success-links' => array(
		'home' => array(
			'label'  => esc_html__( 'View your site', 'fitmax' ),
			'type'   => 'primary',
			'target' => '_blank',
			'icon'   => 'dashicons-welcome-view-site',
			'desc'   => esc_html__( 'Take a look at your site', 'fitmax' ),
			'url'    => home_url( '/' ),
		),
		'customize' => array(
			'label'  => esc_html__( 'Customize your theme', 'fitmax' ),
			'type'   => 'primary',
			'target' => '_self',
			'icon'   => 'dashicons-admin-generic',
			'desc'   => esc_html__( 'Proceed to customizing your theme', 'fitmax' ),
			'url'    => admin_url( 'customize.php' ),
		),
	),
	'export' => array(
		'options' => array(
			'theme_mods_fitmax',
			'site_icon',
			'header_bg_image',
			'header_bg_color',

			'elementor_cpt_support',
			'elementor_disable_color_schemes',
			'elementor_disable_typography_schemes',
			'elementor_container_width',
			'elementor_css_print_method',
			'elementor_load_fa4_shim',
			'elementor_allow_svg',
			'elementor_page_title_selector',
			'elementor_default_generic_fonts',
			'elementor_space_between_widgets',
			'elementor_stretched_section_container',
			'elementor_viewport_lg',
			'elementor_viewport_md',
			'elementor_global_image_lightbox',
			'elementor_load_fa4_shim',

			'cptui_post_types',
			'rx-theme-assistant-settings',
			'mc4wp',
			'mc4wp_mailchimp_list_ids',

			'wpgdprc_integrations_contact-form-7',
			'wpgdprc_integrations_wordpress',
			'wpgdprc_integrations_contact-form-7_form_text',
			'wpgdprc_integrations_contact-form-7_error_message',

			'woocommerce_catalog_columns',
			'woocommerce_catalog_rows',
			'woocommerce_cart_page_id',
			'woocommerce_checkout_page_id',
			'woocommerce_myaccount_page_id',
			'woocommerce_terms_page_id',
			'woocommerce_shop_page_id',
			'woocommerce_single_image_width',
			'woocommerce_thumbnail_image_width',
			'wp_page_for_privacy_policy',

			'woocs',
			'woocs_welcome_currency',
			'woocs_show_flags',

			'cptui_post_types',
		),

		'tables' => array(
			'wpgdprc_consents',
			'revslider_css',
			'revslider_css_bkp',
			'revslider_layer_animations',
			'revslider_layer_animations_bkp',
			'revslider_navigations',
			'revslider_navigations_bkp',
			'revslider_slides',
			'revslider_slides_bkp',
			'revslider_sliders',
			'revslider_sliders_bkp',
			'revslider_static_slides',
			'revslider_static_slides_bkp',
			'wp_woocommerce_attribute_taxonomies',

		),
	),
);
