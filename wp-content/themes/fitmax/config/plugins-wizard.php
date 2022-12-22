<?php
/**
 * Jet Plugins Wizard configuration.
 *
 * @package Storycle
 */
$license = array(
	'enabled' => false,
);

/**
 * Plugins configuration
 *
 * @var array
 */
$plugins = array(
	'jet-data-importer' => array(
		'name'   => esc_html__( 'Jet Data Importer', 'fitmax' ),
		'source' => 'remote', // 'local', 'remote', 'wordpress' (default).
		'path'   => 'https://assets.rovadex.com/plugins/jet-data-importer.zip',
		'access' => 'base',
	),

	'elementor' => array(
		'name'   => esc_html__( 'Elementor Page Builder', 'fitmax' ),
		'access' => 'base',
	),

	'header-footer-elementor' => array(
		'name'   => esc_html__( 'Header Footer Elementor', 'fitmax' ),
		'access' => 'base',
	),

	'rx-theme-assistant' => array(
		'name'   => esc_html__( 'Rx Theme Assistant', 'fitmax' ),
		'source' => 'remote', // 'local', 'remote', 'wordpress' (default).
		'path'   => 'https://assets.rovadex.com/plugins/rx-theme-assistant.zip',
		'access' => 'base',
	),

	'jetwidgets-for-elementor' => array(
		'name'   => esc_html__( 'JetWidgets For Elementor', 'fitmax' ),
		'access' => 'base',
	),

	'revslider' => array(
		'name'   => esc_html__( 'Slider Revolution', 'fitmax' ),
		'source' => 'local', // 'local', 'remote', 'wordpress' (default).
		'path'   => get_theme_file_uri( 'assets/plugins/revslider.zip' ),
		'access' => 'base',
	),

	'contact-form-7' => array(
		'name'   => esc_html__( 'Contact Form 7', 'fitmax' ),
		'access' => 'base',
	),

	'premium-addons-for-elementor' => array(
		'name'   => esc_html__( 'Premium Addons for Elementor', 'fitmax' ),
		'access' => 'base',
	),

	'woocommerce' => array(
		'name'   => esc_html__( 'WooCommerce', 'fitmax' ),
		'access' => 'base',
	),

	'woocommerce-currency-switcher' => array(
		'name'   => esc_html__( 'WOOCS – Currency Switcher for WooCommerce', 'fitmax' ),
		'access' => 'base',
	),

	'jetwoo-widgets-for-elementor' => array(
		'name'   => esc_html__( 'JetWoo Widgets For Elementor', 'fitmax' ),
		'access' => 'base',
	),

	'yith-color-and-label-variations-for-woocommerce' => array(
		'name'   => esc_html__( 'YITH Color and Label Variations for WooCommerce', 'fitmax' ),
		'access' => 'base',
	),

	'cherry-ld-mods-switcher' => array(
		'name'   => esc_html__( 'Cherry ld mods switcher', 'fitmax' ),
		'source' => 'remote', // 'local', 'remote', 'wordpress' (default).
		'path'   => 'https://assets.rovadex.com/plugins/cherry-ld-mods-switcher.zip',
		
		'access' => 'base',
	),

	'block-builder' => array(
		'name'   => esc_html__( 'Elementor Blocks for Gutenberg', 'fitmax' ),
		'access' => 'base',
	),

	'wp-gdpr-compliance' => array(
		'name'   => esc_html__( 'WP GDPR Compliance', 'fitmax' ),
		'access' => 'skins',
	),

	'wordpress-seo' => array(
		'name'   => esc_html__( 'Yoast SEO', 'fitmax' ),
		'access' => 'skins',
	),

	'autoptimize' => array(
		'name'   => esc_html__( 'Autoptimize', 'fitmax' ),
		'access' => 'skins',
	),

	'wp-super-cache' => array(
		'name'   => esc_html__( 'WP Super Cache', 'fitmax' ),
		'access' => 'skins',
	),
);

/**
 * Skins configuration
 *
 * @var array
 */
$theme = wp_get_theme();
$theme_slag = get_template();
$skins = array(
	'base' => array(
		'jet-data-importer',
		'elementor',
		'jetwidgets-for-elementor',
		'revslider',
		'rx-theme-assistant',
		'woocommerce',
		'contact-form-7',
		'premium-addons-for-elementor',
		'jetwoo-widgets-for-elementor',
		'woocommerce-currency-switcher',
		'yith-color-and-label-variations-for-woocommerce',
	),
	'advanced' => array(
		'default' => array(
			'full'  => array(
				'cherry-ld-mods-switcher',
				'wp-gdpr-compliance',
				'gutenberg',
				'block-builder',
			),
			'lite'            => false,
			'demo'            => 'https://wp.rovadex.com/' . $theme_slag,
			'thumb'           => get_theme_file_uri( 'screenshot.png' ),
			'name'            => $theme->get( 'Name' ),
			'additional_info' => array(
				'title'       => sprintf( '%1$s %2$s %3$s', $theme->get( 'Name' ), esc_html__( 'Theme', 'fitmax' ), $theme->get( 'Version' ) ),
				'description' => $theme->get( 'Description' ),
				'social_links' => array(
					'facebook' => array(
						'icon' => '#',
						'link' => '#',
					)
				),
				'info_blocks' => array(
					'documentation' => array(
						'thumb'       => 'https://assets.rovadex.com/plugins/rx-theme-wizard/documentation-thumb.png',
						'title'       => esc_html__( 'Documentation', 'fitmax' ),
						'description' => esc_html__( 'Detailed documentation which explains in easy way how to setup and customize our theme. Your site customisations will be easy and fast!', 'fitmax' ),
						'link_text'   => esc_html__( 'Read', 'fitmax' ),
						'link'        => 'https://assets.rovadex.com/documentation/' . $theme_slag,
					),
					'support' => array(
						'thumb'       => 'https://assets.rovadex.com/plugins/rx-theme-wizard/support-thumb.png',
						'title'       => esc_html__( 'Support', 'fitmax' ),
						'description' => esc_html__( 'We always care about our customers, our loyal support team are always ready to help', 'fitmax' ),
						'link_text'   => esc_html__( 'Submit Ticket', 'fitmax' ),
						'link'        => 'https://rovadex.ticksy.com',
					),
					'author' => array(
						'thumb'       => 'https://assets.rovadex.com/plugins/rx-theme-wizard/author-thumb.png',
						'title'       => esc_html__( 'Author', 'fitmax' ),
						'description' => esc_html__( 'Business has an idea, an idea has a realization. We develop ideas for your business on the Internet. With our help, you will put into effect the most demanding and quality projects.', 'fitmax' ),
						'link_text'   => esc_html__( 'Author Site', 'fitmax' ),
						'link'        => 'https://rovadex.com',
					),
				),
			)
		),
	),
);

$texts = array(
	'theme-name' => $theme->get( 'Name' ),
);

$config = array(
	'license' => $license,
	'plugins' => $plugins,
	'skins'   => $skins,
	'texts'   => $texts,
);
