<?php
namespace WPGDPRC\WordPress\Ajax;

use WPGDPRC\WordPress\Plugin;

/**
 * Class PostEditLink
 * @package WPGDPRC\WordPress\Ajax
 */
class PostEditLink extends AbstractAjax {

    /**
     * Returns AJAX action name
     * @return string
     */
    protected static function getAction() {
        return Plugin::PREFIX . '_post_edit_link';
    }

    /**
     * Determines if AJAX is public
     * @return bool
     */
    protected static function isPublic() {
        return false;
    }

    /**
     * Determines if AJAX call is sending a data attribute
     * @return bool
     */
    public static function hasData() {
        return false;
    }

    /**
     * Builds the AJAX response
     * (security handling + data validation -if any- is done in the abstract class)
     * @param array $data
     */
    public static function buildResponse( $data = [] ) {
        $message = get_edit_post_link((int) $_POST['post']);
        static::returnSuccess(htmlspecialchars_decode($message));
    }

}
