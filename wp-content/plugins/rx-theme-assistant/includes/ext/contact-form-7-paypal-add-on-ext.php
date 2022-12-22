<?php
/**
 * A class that extends the ability to work with the plug-ins "Contact Form 7 - PayPal & Stripe Add-on" and "Contact Form 7 Cost Calculator (Add-on for CF7)"
 * Links to pagins
 * 1. https://wordpress.org/plugins/contact-form-7-paypal-add-on/
 * 2. https://wordpress.org/plugins/cf7-cost-calculator/
 *
 * @package   Contact_Form_7_Paypal_Plugin_Ext
 * @author    Rovadex Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Contact_Form_7_Paypal_Plugin_Ext' ) ) {

	/**
	 * Define Contact_Form_7_Paypal_Plugin_Ext class
	 */
	class Contact_Form_7_Paypal_Plugin_Ext {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
			remove_action( 'wpcf7_after_save', 'cf7pp_save_contact_form' );
			remove_action('wpcf7_before_send_mail', 'cf7pp_before_send_mail');

			add_filter( 'wpcf7_editor_panels', array( $this, 'cf7pp_editor_panels' ), 11, 1 );
			add_action( 'wpcf7_after_save', array( $this, 'cf7pp_save_contact_form' ) );
			add_action( 'wpcf7_before_send_mail', array( $this, 'cf7pp_before_send_mail' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'dequeue_scripts'), 2000);

			if( class_exists('BH_CF7_CC_Frontend') ) {
				add_action( 'wpcf7_init', array( $this, 'remove_calc_tag' ), 9999 );
			}

		}

		/**
		 * Editor panels.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return array
		 */
		public function remove_calc_tag() {
			wpcf7_remove_form_tag( "cf7cc_calculated*" );
			wpcf7_remove_form_tag( "cf7cc_calculated" );

			wpcf7_add_form_tag( array( 'cf7cc_calculated', 'cf7cc_calculated*' ),
				array( $this, 'cf7cc_calculated_callback' ), array(
					'name-attr' => true,
					'selectable-values' => true,
					'multiple-controls-container' => true
				)
			);
		}

		/**
		 * Calculated Callback.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string
		 */
		public function cf7cc_calculated_callback( $tag ) {
			$attr_formulas = '';
			$form = wpcf7_get_current_contact_form();

			$formulas = get_post_meta( $form->id(), '_cf7cc_' . $tag->name, true );

			if($formulas) {
				$attr_formulas = $formulas;
			}

			$format = apply_filters(
				'rx-theme-assistant/cf7cc_calculated/format',
				'<input class="cf7cc-totals cf7-calculated-name" name="%1$s" data-formulas="%2$s" value="0" readonly pattern="^[0-9]+$" type="text">' );

			return sprintf( $format, $tag->name, $attr_formulas );
		}

		/**
		 * Editor panels.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return array
		 */
		public function cf7pp_editor_panels( $panels ) {
			if( isset($panels['PayPal']['callback']) ){
				$panels['PayPal']['callback'] = array( $this, 'cf7pp_new_admin_settings' );
			}

			return $panels;
		}

		/**
		 * New Admin Settings.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function cf7pp_new_admin_settings( $cf7 ) {
			$post_id = sanitize_text_field($_GET['post']);

			$enable = 					get_post_meta($post_id, "_cf7pp_enable", true);
			$enable_stripe = 			get_post_meta($post_id, "_cf7pp_enable_stripe", true);
			$name = 					get_post_meta($post_id, "_cf7pp_name", true);
			$price = 					get_post_meta($post_id, "_cf7pp_price", true);
			$field_id = 				get_post_meta($post_id, "_cf7pp_field_id", true);
			$id = 						get_post_meta($post_id, "_cf7pp_id", true);
			$gateway = 					get_post_meta($post_id, "_cf7pp_gateway", true);
			$stripe_email = 			get_post_meta($post_id, "_cf7pp_stripe_email", true);

			if ($enable == "1") { $checked = "CHECKED"; } else { $checked = ""; }
			if ($enable_stripe == "1") { $checked_stripe = "CHECKED"; } else { $checked_stripe = ""; }

			$admin_table_output = "";
			$admin_table_output .= "<h2>PayPal & Stripe Settings</h2>";

			$admin_table_output .= "<div class='mail-field'></div>";

			$admin_table_output .= "<table><tr>";

			$admin_table_output .= "<td width='195px'><label>Enable PayPal on this form: </label></td>";
			$admin_table_output .= "<td width='250px'><input name='cf7pp_enable' value='1' type='checkbox' $checked></td></tr>";

			$admin_table_output .= "<td><label>Enable Stripe on this form</label></td>";
			$admin_table_output .= "<td><input name='cf7pp_enable_stripe' value='1' type='checkbox' $checked_stripe></td></tr>";

			$admin_table_output .= "<tr><td>Gateway Code: </td>";
			$admin_table_output .= "<td><input type='text' name='cf7pp_gateway' value='$gateway'> </td><td> (Required to use both Gateways at the same time. Documentation <a target='_blank' href='https://wpplugin.org/documentation/paypal-stripe-gateway-code/'>here</a>. Example: menu-231)</td></tr><tr><td>";

			$admin_table_output .= "<tr><td>Email Code: </td>";
			$admin_table_output .= "<td><input type='text' name='cf7pp_stripe_email' value='$stripe_email'> </td><td> (Optional. Pass email to Stripe. Example: text-105)</td></tr><tr><td colspan='3'><br />";


			$admin_table_output .= "<hr></td></tr>";

			$admin_table_output .= "<tr><td>Item Description: </td>";
			$admin_table_output .= "<td><input type='text' name='cf7pp_name' value='$name'> </td><td> (Optional)</td></tr>";

			$admin_table_output .= "<tr><td>Item Price: </td>";
			$admin_table_output .= "<td><input type='text' name='cf7pp_price' value='$price'> </td><td> (PayPal supports 0.00 to allow the customer to enter their own amount, Stripe does not and requires an amount. Format: for $2.99, enter 2.99)</td></tr>";

			$admin_table_output .= "<tr><td>Price Field ID: </td>";
			$admin_table_output .= "<td><input type='text' name='cf7pp_field_id' value='$field_id'> </td><td> (If the price of a product is dynamic and depends on various options, then you can specify the ID of the field in which the final price will be.)</td></tr>";

			$admin_table_output .= "<tr><td>Item ID / SKU: </td>";
			$admin_table_output .= "<td><input type='text' name='cf7pp_id' value='$id'> </td><td> (Optional)</td></tr>";

			$admin_table_output .= "<input type='hidden' name='cf7pp_post' value='$post_id'>";

			$admin_table_output .= "</td></tr></table>";

			echo $admin_table_output;
		}

		/**
		 * Save Contact Form.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function cf7pp_save_contact_form( $cf7 ) {

			$post_id = sanitize_text_field($_POST['cf7pp_post']);

			if (!empty($_POST['cf7pp_enable'])) {
				$enable = sanitize_text_field($_POST['cf7pp_enable']);
				update_post_meta($post_id, "_cf7pp_enable", $enable);
			} else {
				update_post_meta($post_id, "_cf7pp_enable", 0);
			}

			if (!empty($_POST['cf7pp_enable_stripe'])) {
				$enable_stripe = sanitize_text_field($_POST['cf7pp_enable_stripe']);
				update_post_meta($post_id, "_cf7pp_enable_stripe", $enable_stripe);
			} else {
				update_post_meta($post_id, "_cf7pp_enable_stripe", 0);
			}

			$name = sanitize_text_field($_POST['cf7pp_name']);
			update_post_meta($post_id, "_cf7pp_name", $name);

			$price = sanitize_text_field($_POST['cf7pp_price']);
			$price = cf7pp_format_currency($price);
			update_post_meta($post_id, "_cf7pp_price", $price);

			$field_id = sanitize_text_field( $_POST['cf7pp_field_id'] );
			update_post_meta( $post_id, "_cf7pp_field_id", $field_id );

			$id = sanitize_text_field($_POST['cf7pp_id']);
			update_post_meta($post_id, "_cf7pp_id", $id);

			$gateway = sanitize_text_field($_POST['cf7pp_gateway']);
			update_post_meta($post_id, "_cf7pp_gateway", $gateway);

			$stripe_email = sanitize_text_field($_POST['cf7pp_stripe_email']);
			update_post_meta($post_id, "_cf7pp_stripe_email", $stripe_email);
		}

		/**
		 * Save Contact Form.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function cf7pp_before_send_mail() {
			$wpcf7 = WPCF7_ContactForm::get_current();

			// need to save submission for later and the variables get lost in the cf7 javascript redirect
			$submission_orig = WPCF7_Submission::get_instance();

			if ($submission_orig) {
				// get form post id
				$posted_data = $submission_orig->get_posted_data();

				$options = 			get_option('cf7pp_options');

				$post_id = 			$posted_data['_wpcf7'];
				$gateway = 			strtolower(get_post_meta($post_id, "_cf7pp_gateway", true));
				$field_id = 		get_post_meta($post_id, "_cf7pp_field_id", true);
				$amount_total =		empty( $field_id ) ? get_post_meta($post_id, "_cf7pp_price", true) : $posted_data[$field_id] ;

				if (! empty( $amount_total ) ) {
					update_post_meta($post_id, "_cf7pp_price", $amount_total);
				}

				$enable = 			get_post_meta( $post_id, "_cf7pp_enable", true);
				$enable_stripe = 	get_post_meta( $post_id, "_cf7pp_enable_stripe", true);

				$stripe_email = 	strtolower(get_post_meta($post_id, "_cf7pp_stripe_email", true));

				if (!empty($stripe_email)) {
					$stripe_email = 	$posted_data[$stripe_email];
				} else {
					$stripe_email = '';
				}

				$gateway_orig = $gateway;

				if ($enable == '1') {
					$gateway = 'paypal';
				}

				if ($enable_stripe == '1') {
					$gateway = 'stripe';
				}

				if ($enable == '1' && $enable_stripe == '1') {
					$gateway = $posted_data[$gateway_orig];
				}

				if (!isset($options['default_symbol'])) {
					$options['default_symbol'] 	= '$';
				}

				if (isset($options['mode_stripe'])) {
					if ($options['mode_stripe'] == "1") {
						$tags['stripe_state'] = "test";
					} else {
						$tags['stripe_state'] = "live";
					}
				} else {
					$tags['stripe_state'] = "live";
				}

				$_SESSION['gateway'] = 			$gateway;
				$_SESSION['amount_total'] = 	$amount_total;
				$_SESSION['default_symbol'] = 	$options['default_symbol'];
				$_SESSION['stripe_state'] = 	$tags['stripe_state'];
				$_SESSION['stripe_email'] = 	$stripe_email;
				$_SESSION['stripe_return'] = 	$options['stripe_return'];
			}
		}

		/**
		 * Dequeue Plugins Scripts
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function dequeue_scripts() {
			wp_dequeue_style('cf7cc-style');
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
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
 * Returns instance of contact_form_7_paypal_plugin_ext
 *
 * @return object
 */
function contact_form_7_paypal_plugin_ext() {
	if ( function_exists( 'cf7pp_free' ) ) {
		return Contact_Form_7_Paypal_Plugin_Ext::get_instance();
	}

	return;
}

contact_form_7_paypal_plugin_ext();
