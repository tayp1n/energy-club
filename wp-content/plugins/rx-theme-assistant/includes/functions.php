<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Rovadex
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Rx_Theme_Assistant_Functions' ) ) {

	/**
	 * Define Rx_Theme_Assistant_Functions class
	 */
	class Rx_Theme_Assistant_Functions {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Constructor for the class
		 */
		public function init() {
			remove_action( 'admin_init', 'cptui_make_activation_redirect', 1 );
			update_option(' pa_activation_redirect', false );
			update_option(' pa_review_notice', '1' );

			add_action( 'init', array( $this, 'register_handler' ) );
			add_action( 'init', array( $this, 'login_handler' ) );

			// Add svg in types to uploads.
			add_filter('upload_mimes', array( $this, 'add_file_types_to_uploads' ), 1, 1 );

			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'cart_link_fragments' ), 11, 1 );
		}

		/**
		 * Allow to rewrite shop page layout from page options
		 *
		 * @param  int $id Current page ID.
		 * @return int
		 */
		public function get_post_id() {

			if ( ! function_exists( 'is_shop' ) || ! function_exists( 'wc_get_page_id' ) ) {
				return get_the_ID();
			}

			if ( ! is_shop() && ! is_tax( 'product_cat' ) && ! is_tax( 'product_tag' ) ) {
				return get_the_ID();
			}

			$page_id = wc_get_page_id( 'shop' );

			$woocommerce_shop_page_id = get_option( 'woocommerce_shop_page_id', false );

			if ( $woocommerce_shop_page_id ) {
				return $woocommerce_shop_page_id;
			}

			return $page_id;
		}

		/**
		 * Login form handler.
		 *
		 * @return void
		 */
		public function login_handler() {

			if ( ! isset( $_POST['rx_login'] ) ) {
				return;
			}

			try {

				if ( empty( $_POST['log'] ) ) {

					$error = sprintf(
						'<strong>%1$s</strong>: %2$s',
						__( 'ERROR', 'rx-theme-assistant' ),
						__( 'The username field is empty.', 'rx-theme-assistant' )
					);

					throw new Exception( $error );

				}

				$signon = wp_signon();

				if ( is_wp_error( $signon ) ) {
					throw new Exception( $signon->get_error_message() );
				}

				$redirect = isset( $_POST['redirect_to'] )
								? esc_url( $_POST['redirect_to'] )
								: esc_url( home_url( '/' ) );

				wp_redirect( $redirect );
				exit;

			} catch ( Exception $e ) {
				wp_cache_set( 'rx-login-messages', $e->getMessage() );
			}

		}

		/**
		 * Registration handler
		 *
		 * @return void
		 */
		public function register_handler() {

			if ( ! isset( $_POST['rx-register-nonce'] ) ) {
				return;
			}

			if ( ! wp_verify_nonce( $_POST['rx-register-nonce'], 'rx-register' ) ) {
				return;
			}

			try {

				$username           = isset( $_POST['username'] ) ? $_POST['username'] : '';
				$password           = isset( $_POST['password'] ) ? $_POST['password'] : '';
				$email              = isset( $_POST['email'] ) ? $_POST['email'] : '';
				$confirm_password   = isset( $_POST['rx_confirm_password'] ) ? $_POST['rx_confirm_password'] : '';
				$confirmed_password = isset( $_POST['password-confirm'] ) ? $_POST['password-confirm'] : '';
				$confirm_password   = filter_var( $confirm_password, FILTER_VALIDATE_BOOLEAN );

				if ( $confirm_password && $password !== $confirmed_password ) {
					throw new Exception( esc_html__( 'Entered passwords don\'t match', 'rx-theme-assistant' ) );
				}

				$validation_error = new WP_Error();

				$user = $this->create_user( $username, sanitize_email( $email ), $password );

				if ( is_wp_error( $user ) ) {
					throw new Exception( $user->get_error_message() );
				}

				global $current_user;
				$current_user = get_user_by( 'id', $user );
				wp_set_auth_cookie( $user, true );

				if ( ! empty( $_POST['rx_redirect'] ) ) {
					$redirect = wp_sanitize_redirect( $_POST['rx_redirect'] );
				} else {
					$redirect = $_POST['_wp_http_referer'];
				}

				wp_redirect( $redirect );
				exit;

			} catch ( Exception $e ) {
				wp_cache_set( 'rx-register-messages', $e->getMessage() );
			}

		}

		/**
		 * Create new user function
		 *
		 * @param  string $username
		 * @param  string $email
		 * @param  string $password
		 * @return mixed
		 */
		public function create_user( $username, $email, $password ) {

			// Check username
			if ( empty( $username ) || ! validate_username( $username ) ) {
				return new WP_Error(
					'registration-error-invalid-username',
					__( 'Please enter a valid account username.', 'rx-theme-assistant' )
				);
			}

			if ( username_exists( $username ) ) {
				return new WP_Error(
					'registration-error-username-exists',
					__( 'An account is already registered with that username. Please choose another.', 'rx-theme-assistant' )
				);
			}

			// Check the email address.
			if ( empty( $email ) || ! is_email( $email ) ) {
				return new WP_Error(
					'registration-error-invalid-email',
					__( 'Please provide a valid email address.', 'rx-theme-assistant' )
				);
			}

			if ( email_exists( $email ) ) {
				return new WP_Error(
					'registration-error-email-exists',
					__( 'An account is already registered with your email address. Please log in.', 'rx-theme-assistant' )
				);
			}

			// Check password
			if ( empty( $password ) ) {
				return new WP_Error(
					'registration-error-missing-password',
					__( 'Please enter an account password.', 'rx-theme-assistant' )
				);
			}

			$new_user_data = array(
				'user_login' => $username,
				'user_pass'  => $password,
				'user_email' => $email,
			);

			$user_id = wp_insert_user( $new_user_data );

			if ( is_wp_error( $user_id ) ) {
				return new WP_Error(
					'registration-error',
					'<strong>' . __( 'Error:', 'rx-theme-assistant' ) . '</strong> ' . __( 'Couldn&#8217;t register you&hellip; please contact us if you continue to have problems.', 'rx-theme-assistant' )
				);
			}

			return $user_id;
		}

		/**
		 * Add svg in types to uploads.
		 *
		 * @since  1.0.0
		 * @return array mime types.
		 */
		function add_file_types_to_uploads( $mime_types ){
			$mime_types['svg'] = 'image/svg+xml';
			return $mime_types;
		}

		/**
		 * Cart link fragments
		 *
		 * @since  1.3.6
		 * @return array
		 */
		public function cart_link_fragments( $fragments ) {
			global $woocommerce;

			$new_ragments = apply_filters( 'rx-theme-assistant/handlers/cart-fragments', array(
				'.rx-cart__total-val' => 'rx-theme-assistant-shop-cart/global/cart-totals.php',
				'.rx-cart__count-val' => 'rx-theme-assistant-shop-cart/global/cart-count.php',
			) );

			foreach ( $new_ragments as $selector => $template ) {
				ob_start();
				include rx_theme_assistant()->get_template( $template );
				$new_ragments[ $selector ] = ob_get_clean();
			}

			return array_merge( $fragments, $new_ragments );
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

function rx_theme_assistant_functions() {
	return Rx_Theme_Assistant_Functions::get_instance();
}
