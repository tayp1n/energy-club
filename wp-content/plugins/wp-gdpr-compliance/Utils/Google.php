<?php

namespace WPGDPRC\Utils;

use Cassandra\Set;
use WPGDPRC\WordPress\Plugin;
use WPGDPRC\WordPress\Settings;

/**
 * Class Google
 * @package WPGDPRC\Utils
 */
class Google {

    /**
     * Lists Google Fonts (i.e. for Consent Bar styling)
     * @return array
     */
    public static function listFonts( $limit = 0 ) {
        $trans_key = Plugin::PREFIX . '_font_list_' . $limit;
        $cached    = get_transient($trans_key);
        if( !empty($cached) && is_iterable($cached) ) return $cached;

        $list     = [];
        $expire   = WEEK_IN_SECONDS;
        $api_args = [
            'key'    => Settings::get(Settings::KEY_CONSENT_API_KEY),
            'sort'   => 'popularity',
            'fields' => 'items',
        ];

        $api_url = add_query_arg($api_args, 'https://www.googleapis.com/webfonts/v1/webfonts');
        $curl    = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        $error = curl_error($curl);
        curl_close($curl);

        if( $error ) {
            Debug::log($error, Plugin::PLUGIN_SLUG);
            return $list;
        }

        $result = json_decode($response, true);
        if( empty($result['items']) ) {
            Debug::log('No fonts found.', Plugin::PLUGIN_SLUG);
            return $list;
        }

        foreach( $result['items'] as $font ) {
            if( empty($font['family']) ) continue;
            if( empty($font['variants']) ) continue;
            if( !in_array('regular', $font['variants']) ) continue;

            $key = esc_attr($font['family']);

            $list[ $key ] = $font['family'];
            if( $limit && count($list) == $limit ) break;
        }

        ksort($list);
        set_transient($trans_key, $list, $expire);

        return $list;
    }

    /**
     * Array with the top 50 popular Google Fonts
     * @return string[]
     */
    public static function getPopularFonts() {
        return [
            'Anton',
            'Arimo',
            'Barlow',
            'Bebas Neue',
            'Bitter',
            'Cabin',
            'Dosis',
            'Fira Sans',
            'Heebo',
            'Hind Siliguri',
            'Inconsolata',
            'Inter',
            'Josefin Sans',
            'Karla',
            'Lato',
            'Libre Baskerville',
            'Libre Franklin',
            'Lora',
            'Merriweather',
            'Montserrat',
            'Mukta',
            'Mulish',
            'Nanum Gothic',
            'Noto Sans',
            'Noto Sans JP',
            'Noto Sans KR',
            'Noto Sans TC',
            'Noto Serif',
            'Nunito',
            'Nunito Sans',
            'Open Sans',
            'Oswald',
            'Oxygen',
            'PT Sans',
            'PT Sans Narrow',
            'PT Serif',
            'Playfair Display',
            'Poppins',
            'Quicksand',
            'Raleway',
            'Roboto',
            'Roboto Condensed',
            'Roboto Mono',
            'Roboto Slab',
            'Rubik',
            'Source Code Pro',
            'Source Sans Pro',
            'Titillium Web',
            'Ubuntu',
            'Work Sans',
        ];
    }

    /**
     * Setup array with key values
     * @return array
     */
    public static function getPopularFontsList() {
        $fonts = static::getPopularFonts();
        $list = [];

        if (!$fonts) {
            return $list;
        }

        foreach ($fonts as $font) {
            $list[$font] = $font;
        }

        return $list;
    }

}
