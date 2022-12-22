<?php
namespace WPGDPRC\WordPress\Ajax;

use WPGDPRC\Utils\FormHandler;
use WPGDPRC\Utils\Template;
use WPGDPRC\Utils\Wizard;
use WPGDPRC\WordPress\Admin\Pages\PageDashboard;

/**
 * Class UpdateWizardConsent
 * @package WPGDPRC\WordPress\Ajax
 */
class UpdateWizardConsent extends AbstractAjax {

    /**
     * Returns AJAX action name
     * @return string
     */
    protected static function getAction() {
        return Wizard::AJAX_SAVE_CONSENT;
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
	 * Validates the data attribute
	 * @return array|void
	 */
    public static function validateData() {
		return $_POST[ PageDashboard::TAB_PROCESSORS ];
    }

    /**
     * Builds the AJAX response
     * (security handling + data validation -if any- is done in the abstract class)
     * @param array $data
     */
    public static function buildResponse( $data = [] ) {

    	$args = FormHandler::consentEditForm($data);

    	ob_start();

        Template::render('Admin/Pages/Wizard/Steps/Parts/consent-form', ['id' => $args['edit']]);

        $response = [
            'success' => true,
            'form' => ob_get_clean(),
        ];

        static::returnResponse($response);
    }

}
