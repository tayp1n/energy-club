<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Cherry Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Rx_Theme_Wizard_License' ) ) {

	/**
	 * Define Rx_Theme_Wizard_License class
	 */
	class Rx_Theme_Wizard_License {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * OPtion name to store license key in.
		 *
		 * @var string
		 */
		public $license_option = 'rx_envato_license';

		/**
		 * [$api_url description]
		 * @var string
		 */
		public $api_url = 'https://api.envato.com/v3/market/author/sale';

		/**
		 * License checking status
		 *
		 * @var boolean
		 */
		private $is_enabled = null;

		/**
		 * Constructor for the class
		 */
		public function __construct() {

			if ( ! $this->is_enabled() ) {
				return;
			}

			add_filter( 'rx-theme-wizard/steps', array( $this, 'replace_zero_step' ), 10, 2 );
			add_filter( 'rx-theme-wizard/js-settings', array( $this, 'add_license_strings' ) );
			add_action( 'wp_ajax_rx_theme_wizard_activate_license', array( $this, 'activate_license' ) );

		}

		/**
		 * Retuirn license
		 *
		 * @return [type] [description]
		 */
		public function get_license() {
			return get_option( $this->license_option );
		}

		/**
		 * Check if license is already active
		 *
		 * @return boolean
		 */
		public function is_active() {

			$license = get_option( $this->license_option );

			if ( ! $license ) {
				return false;
			}

			$response = $this->license_request( 'check_license', $license );
			$result   = wp_remote_retrieve_body( $response );
			$result   = json_decode( $result, true );

			if ( isset( $result['error'] ) ) {
				return false;
			}

			if ( isset( $result['license'] ) ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * [license_request description]
		 * @param  [type] $action  [description]
		 * @param  [type] $license [description]
		 * @return [type]          [description]
		 */
		public function license_request( $action, $license ) {

			$personal_token = rx_theme_wizard_settings()->get( array( 'license', 'personal_token' ) );

			if ( ! $personal_token ) {
				wp_send_json_error( array(
					'errorMessage' => __( 'Personal Token not found', 'rx-theme-wizard' ),
				) );
			}

			$url = add_query_arg(
				array(
					'code' => $license,
				),
				$this->api_url
			);

			$args = array(
				'timeout'   => 60,
				'headers'   => array(
					'Authorization' => 'Bearer ' . $personal_token,
				),
				'User-Agent' => 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0',
			);

			return wp_remote_get( $url, $args );
		}

		/**
		 * Activate license.
		 *
		 * @return void
		 */
		public function activate_license() {

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( array(
					'errorMessage' => __( 'Sorry, you not allowed to activate license', 'rx-theme-wizard' ),
				) );
			}

			$license = isset( $_REQUEST['license'] ) ? esc_attr( $_REQUEST['license'] ) : false;

			if ( ! $license ) {
				wp_send_json_error( array(
					'errorMessage' => __( 'Please provide valid license key', 'rx-theme-wizard' ),
				) );
			}

			$response = $this->license_request( 'activate_license', $license );

			$result   = wp_remote_retrieve_body( $response );
			$result   = json_decode( $result, true );

			if ( isset( $result['error'] ) ) {
				wp_send_json_error( array(
					'errorMessage' => $result['description'],
				) );
			}

			if ( isset( $result['license'] ) ) {

				update_option( $this->license_option, $license, 'no' );

				ob_start();

				printf(
					'<div class="rx-theme-wizard-msg">%1$s</div>',
					__( 'Thanks for license activation. Press Next to continue installation.', 'rx-theme-wizard' )
				);

				rx_theme_wizard()->get_template( 'start-install-button.php' );

				wp_send_json_success( array( 'replaceWith' => ob_get_clean() ) );
			} else {
				wp_send_json_error( array(
					'errorMessage' => $this->get_error_by_code( 'default' ),
				) );
			}
		}

		/**
		 * Retrirve error message by error code
		 *
		 * @return string
		 */
		public function get_error_by_code( $code ) {

			$messages = array(
				'missing' => __( 'Your license is missing. Please check your key again.', 'rx-theme-wizard' ),
				'no_activations_left' => __( '<strong>You have no more activations left.</strong> Please upgrade to a more advanced license (you\'ll only need to cover the difference).', 'rx-theme-wizard' ),
				'expired' => __( '<strong>Your License Has Expired.</strong> Renew your license today to keep getting feature updates, premium support and unlimited access to the template library.', 'rx-theme-wizard' ),
				'revoked' => __( '<strong>Your license key has been cancelled</strong> (most likely due to a refund request). Please consider acquiring a new license.', 'rx-theme-wizard' ),
				'disabled' => __( '<strong>Your license key has been cancelled</strong> (most likely due to a refund request). Please consider acquiring a new license.', 'rx-theme-wizard' ),
				'invalid' => __( '<strong>Your license key doesn\'t match your current domain</strong>. This is most likely due to a change in the domain URL of your site (including HTTPS/SSL migration). Please deactivate the license and then reactivate it again.', 'rx-theme-wizard' ),
				'site_inactive' => __( '<strong>Your license key doesn\'t match your current domain</strong>. This is most likely due to a change in the domain URL. Please deactivate the license and then reactivate it again.', 'rx-theme-wizard' ),
				'inactive' => __( '<strong>Your license key doesn\'t match your current domain</strong>. This is most likely due to a change in the domain URL of your site (including HTTPS/SSL migration). Please deactivate the license and then reactivate it again.', 'rx-theme-wizard' ),
			);

			$default = __( 'An error occurred. Please check your internet connection and try again. If the problem persists, contact our support.', 'rx-theme-wizard' );

			return isset( $messages[ $code ] ) ? $messages[ $code ] : $default;

		}

		/**
		 * Add licesne texts into localize object
		 *
		 * @param  array $data [description]
		 * @return array
		 */
		public function add_license_strings( $data = array() ) {

			$data['license'] = array(
				'empty' => __( 'Please enter your license', 'rx-theme-wizard' ),
			);

			return $data;
		}

		/**
		 * Replace welcome step with activate license step.
		 *
		 * @param  array $steps Default stepa data
		 * @return array
		 */
		public function replace_zero_step( $steps, $step ) {

			if ( 'configure-plugins' === $step || 0 !== absint( $step ) ) {
				return $steps;
			}

			if ( $this->is_active() ) {
				return $steps;
			}

			$steps[0] = 'step-activate-licesne.php';
			return $steps;
		}

		/**
		 * Is license checking enabled or not
		 *
		 * @return boolean [description]
		 */
		public function is_enabled() {

			if ( null !== $this->is_enabled ) {
				return $this->is_enabled;
			}

			$this->is_enabled = rx_theme_wizard_settings()->get( array( 'license', 'enabled' ) );

			return $this->is_enabled;
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}

}

/**
 * Returns instance of Rx_Theme_Wizard_License
 *
 * @return object
 */
function rx_theme_wizard_license() {
	return Rx_Theme_Wizard_License::get_instance();
}
