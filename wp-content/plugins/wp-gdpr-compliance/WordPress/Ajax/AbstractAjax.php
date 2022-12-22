<?php
namespace WPGDPRC\WordPress\Ajax;

use WPGDPRC\WordPress\Plugin;

/**
 * Class AbstractAjax
 * @package WPGDPRC\WordPress\Ajax
 */
abstract class AbstractAjax {

    /**
     * AbstractAjax constructor
     */
    public static function init() {
        add_action('wp_ajax_' . static::getAction(), [ static::class, 'execute' ]);

        if( static::isPublic() ) {
            add_action('wp_ajax_nopriv_' . static::getAction(), [ static::class, 'execute' ]);
        }
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
        return true;
    }

    /**
     * Lists the required data keys
     * @return array
     */
    public static function requiredData() {
        return [];
    }

    /**
     * Returns AJAX action name
     * @return string
     */
    protected static function getAction() {
    }

    /**
     * Executes the AJAX request
     */
    public static function execute() {
        check_ajax_referer(Plugin::AJAX_NONCE, Plugin::AJAX_ARG);

        if( !static::hasData() ) {
            static::buildResponse([]);
            return;
        }

        $data = static::validateData();
        static::buildResponse($data);
    }

    /**
     * Validates the data attribute
     * @return array|void
     */
    public static function validateData() {
        $data = !empty($_POST['data']) ? $_POST['data'] : false;
        if( is_string($data) ) $data = (array) json_decode(stripslashes($_POST['data']));

        $error = __('Missing data.', 'wp-gdpr-compliance');
        if( empty($data) ) static::returnError($error);

        $required = static::requiredData();
        if( empty($required) ) return $data;

        foreach( $required as $key ) {
            if( !isset($data[ $key ]) ) static::returnError($error);
        }

        return $data;
    }

    /**
     * Builds the AJAX response
     * (security handling + data validation -if any- is already done at this point)
     * @param array $data
     */
    public static function buildResponse( $data = [] ) {
    }

    /**
     * Returns a JSON response with an error message
     * @param string $message
     */
    public static function returnError( $message = '' ) {
        $response = [
            'success' => false,
            'error'   => $message,
        ];
        static::returnResponse($response);
    }

    /**
     * Returns a JSON response with a success message
     * @param string $message
     */
    public static function returnSuccess( $message = '' ) {
        $response = [
            'success' => true,
            'message' => $message,
        ];
        static::returnResponse($response);
    }

    /**
     * Returns a JSON response and exits php execution
     * @param array $response
     */
    public static function returnResponse( $response = [] ) {
        if( Plugin::DEBUG_MODE ) $response['debug'] = $_POST;

        header('Content-type: application/json');
        echo json_encode($response);
        wp_die();
    }

}
