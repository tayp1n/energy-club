<?php
namespace WPGDPRC\Utils;

use WPGDPRC\WordPress\Plugin;

/**
 * Class Elements
 * @package WPGDPRC\Utils
 */
class Elements {

    /**
     * Builds a button element (with attributes)
     * @param string $text
     * @param array  $attr
     * @param bool   $admin
     * @return string
     */
    public static function getButton( string $text = '', array $attr = [], bool $admin = true ): string {
        if( empty($text) || !is_string($text) ) return '';

        return Template::get($admin ? 'Admin/Elements/button' : 'Front/Elements/button', [
            'text' => $text,
            'attr' => $attr,
        ]);
    }

    /**
     * Prints a button element (with attributes)
     * @param string $text
     * @param array  $attr
     * @param bool   $admin
     */
    public static function button( string $text = '', array $attr = [], bool $admin = true ) {
        echo self::getButton($text, $attr, $admin);
    }

    /**
     * Builds a warning
     * @param string $error
     * @param bool   $wrap
     * @return string
     */
    public static function getError( string $error = '', bool $wrap = true ): string {
        if( empty($error) ) return '';

        $html = '<span class="wpgdprc-text--error">' . sprintf(_x('<strong>ERROR</strong>: %1$s', 'admin', 'wp-gdpr-compliance'), $error) . '</span>';
        return $wrap ? '<p>' . $html . '</p>' : $html;
    }

    /**
     * Prints a warning
     * @param string $error
     * @param bool   $wrap
     */
    public static function error( string $error = '', bool $wrap = true ) {
        echo self::getError($error, $wrap);
    }

    /**
     * Builds a post edit link element (with attributes)
     * @param int    $id
     * @param string $text
     * @param array  $attr
     * @return string
     */
    public static function getEditLink( int $id = 0, string $text = '', array $attr = [] ): string {
        $url = get_edit_post_link((int) $id);
        if( empty($url) ) return '';

        return self::getLink(htmlspecialchars_decode($url), $text, $attr);
    }

    /**
     * Prints a post edit link element (with attributes)
     * @param int    $id
     * @param string $text
     * @param array  $attr
     */
    public static function editLink( int $id = 0, string $text = '', array $attr = [] ) {
        echo self::getEditLink($id, $text, $attr);
    }

    /**
     * Builds a heading element (with attributes)
     * @param string $text
     * @param int    $level
     * @param array  $attr
     * @return string
     */
    public static function getHeading( string $text = '', int $level = 2, array $attr = [] ): string {
        if( empty($text) || !is_string($text) ) return '';

        $html = '<h' . $level . ' ';
        foreach( $attr as $name => $value ) $html .= $name . '="' . esc_attr($value) . '" ';
        return $html . '>' . $text . '</h' . $level . '>';
    }

    /**
     * Prints a heading element (with attributes)
     * @param string $text
     * @param int    $level
     * @param array  $attr
     */
    public static function heading( string $text = '', int $level = 2, array $attr = [] ) {
        echo self::getHeading($text, $level, $attr);
    }

    /**
     * Builds a link element (with attributes)
     * @param string $url
     * @param string $text
     * @param array  $attr
     * @return string
     */
    public static function getLink( string $url = '', string $text = '', array $attr = [], $noIcon = false ): string {
        if( empty($url) || !is_string($url) ) return '';
        if( empty($text) || !is_string($text) ) $text = Helper::stripUrl($url);

        // trim removes the space after links which gets added because php storm always forces a linebreak at the end of an file.
        return trim(Template::get('Admin/Elements/link', [
            'url'  => $url,
            'text' => $text,
            'attr' => $attr,
            'icon' => !$noIcon,
        ]));
    }

    /**
     * Prints a link element (with attributes)
     * @param string $url
     * @param string $text
     * @param array  $attr
     */
    public static function link( string $url = '', string $text = '', array $attr = [], $noIcon = false ) {
        echo self::getLink($url, $text, $attr, $noIcon);
    }

    /**
     * Builds a warning
     * @param string $warning
     * @param bool   $wrap
     * @return string
     */
    public static function getWarning( string $warning = '', bool $wrap = true ): string {
        if( empty($warning) ) return '';

        $html = '<span class="wpgdprc-text--warning">' . sprintf(_x('<strong>NOTE:</strong> %1$s', 'admin', 'wp-gdpr-compliance'), $warning) . '</span>';
        return $wrap ? '<p>' . $html . '</p>' : $html;
    }

    /**
     * Prints a warning
     * @param string $warning
     * @param bool   $wrap
     */
    public static function warning( string $warning = '', bool $wrap = true ) {
        echo self::getWarning($warning, $wrap);
    }

    /**
     * Builds a notice
     * @param string $title
     * @param string $text
     * @param string $button
     * @param string $type
     * @return string
     */
    public static function getNotice( string $title = '', string $text = '', string $button = '', string $type = 'notice' ): string {
        $icon = 'icon-info-circle.svg';
        switch( $type ) {
            case 'error' :
                $icon = 'icon-times-circle.svg';
                break;

            case 'warning' :
                $icon = 'icon-exclamation-triangle.svg';
                break;

            case 'wizard' :
                $icon = 'icon-wave.svg';
                break;
        }

        return Template::get('Admin/Elements/notice-fancy', [
            'type'   => $type,
            'icon'   => Template::getSvg($icon, true),
            'title'  => $title,
            'text'   => $text,
            'button' => $button,
        ]);
    }

    /**
     * Prints a notice
     * @param string $title
     * @param string $text
     * @param string $button
     * @param string $type
     */
    public static function notice( string $title = '', string $text = '', string $button = '', string $type = 'notice' ) {
        echo self::getNotice($title, $text, $button, $type);
    }

}
