<?php
namespace WPGDPRC\WordPress;

use WPGDPRC\Objects\DataProcessor;
use WPGDPRC\Utils\Cookie;
use WPGDPRC\WordPress\Ajax\ConsentCookie;
use WPGDPRC\WordPress\Ajax\ProcessAction;
use WPGDPRC\WordPress\Front\Actions;
use WPGDPRC\WordPress\Front\Consent\Bar as ConsentBar;
use WPGDPRC\WordPress\Front\Filters;
use WPGDPRC\WordPress\Shortcodes\ProcessorSettingsLink;
use WPGDPRC\WordPress\Shortcodes\RequestAccessForm;

/**
 * Class Front
 * @package WPGDPRC\WordPress
 */
class Front {

    /**
     * Front constructor
     */
    public static function init() {
        add_action('wp_enqueue_scripts', [ self::class, 'loadAssets' ], 999);
        add_action('init', [ self::class, 'initShortcodes' ]);

        // add (custom) front actions
        Actions::init();
        Ajax::init();
        Cron::init();
        Filters::init();
    }

    /**
     * Registers/ enqueues scripts & styles for the website
     */
    public static function loadAssets() {
        if( !Settings::isPremium() ) {
            $handle = Plugin::enqueueStyle('front.css', []);
            wp_add_inline_style($handle, ConsentBar::listCustomStyleVars());

            // enqueue Google font style
            $google_font = ConsentBar::getGoogleFontUrl();
            if( $google_font ) {
                wp_enqueue_style(Plugin::PREFIX . '-google-font', $google_font);
            }
        }

        $handle = Plugin::enqueueScript('front.min.js', [ 'jquery' ]);
        wp_localize_script($handle, 'wpgdprcFront', self::collectJSParams());
    }

    /**
     * Adds shortcodes
     */
    public static function initShortcodes() {
        new RequestAccessForm();
        new ProcessorSettingsLink();
    }

    /**
     * Collects localized JS parameters to pass
     * @return array
     */
    protected static function collectJSParams() {
        $list = Plugin::listJsParams() + [
                'cookieName'     => Plugin::PREFIX . '-consent',
                'consentVersion' => '',
                'path'           => '/',
                'prefix'         => Plugin::PREFIX
            ];

        if( !empty($_REQUEST[ Plugin::PREFIX ]) ) {
            $list['token'] = esc_html(urldecode($_REQUEST[ Plugin::PREFIX ]));
        }

        if( DataProcessor::isActive() ) {
            $list['consentVersion'] = Cookie::getVersion();
            $list['consents']       = DataProcessor::getListByPlacements();

            // update cookie name with version
            $list['cookieName'] .= '-' . $list['consentVersion'];
        }

        // set premium state (if any)
        if( Settings::isPremium() ) $list['isPremium'] = 1;

        // return if no multi-site
        if( empty($list['isMultiSite']) ) return $list;

        // update cookie name with multi-site blog ID
        $list['cookieName'] = $list['blogId'] . '-' . $list['cookieName'];

        $blog_details = get_blog_details();
        if( empty($blog_details) ) return $list;
        if( !property_exists($blog_details, 'path') ) return $list;

        // update cookie pathe with multi-site blog path
        $list['path'] = $blog_details->path;
        return $list;
    }

}
