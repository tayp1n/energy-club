<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Cherry Team
 * @license   GPL-2.0+
 */

use Elementor\Plugin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Rx_Theme_Assistant_Header_Footer_Plugin_Ext' ) ) {

	/**
	 * Define Rx_Theme_Assistant_Header_Footer_Plugin_Ext class
	 */
	class Rx_Theme_Assistant_Header_Footer_Plugin_Ext {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Instance of HFE_Admin.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private $HFE_Admin = null;

		/**
		* Instance of Elemenntor Frontend class.
		*
		* @var \Elementor\Frontend()
		*/
		private static $elementor_instance;

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
			$this->HFE_Admin = HFE_Admin::instance();
			self::$elementor_instance = Plugin::instance();

			remove_action( 'admin_notices', array( $this->HFE_Admin, 'location_notice' ) );
			remove_action( 'add_meta_boxes', array( $this->HFE_Admin, 'ehf_register_metabox' ) );

			add_action( 'admin_notices', array( $this, 'rx_theme_assistant_location_notice' ), 10 );
			add_action( 'add_meta_boxes', array( $this, 'rx_theme_assistant_register_metabox' ), 10 );
			add_action( 'save_post', array( $this, 'rx_theme_assistant_save_meta' ), 11 );

			//add_filter( 'rx_theme_header', array( $this, 'rx_theme_assistant_return_template' ), 10, 2 );
			//add_filter( 'rx_theme_footer', array( $this, 'rx_theme_assistant_return_template' ), 10, 2 );
		}

		/**
		 * Register meta box(es).
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function rx_theme_assistant_register_metabox() {
			add_meta_box(
				'ehf-meta-box',
				__( 'Elementor Header Footer options', 'rx-theme-assistant' ),
				array(
					$this,
					'rx_theme_assistant_metabox_render',
				),
				'elementor-hf',
				'normal',
				'high'
			);
		}

		/**
		 * Render Meta field.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  POST $post Currennt post object which is being displayed.
		 * @return void
		 */
		public function rx_theme_assistant_metabox_render( $post ) {
			$values            = get_post_custom( $post->ID );
			$template_type     = isset( $values['ehf_template_type'] ) ? esc_attr( $values['ehf_template_type'][0] ) : '';
			$display_on_canvas = isset( $values['display-on-canvas-template'] ) ? true : false;
			$global_template   = isset( $values['global-template'] ) ? true : false;
			$stick_up_template = isset( $values['set-stick-up'] ) ? true : false;

			// We'll use this nonce field later on when saving.
			wp_nonce_field( 'ehf_meta_nounce', 'ehf_meta_nounce' );
			?>

			<table class="hfe-options-table widefat">
				<tbody>
				<tr class="hfe-options-row">
					<td class="hfe-options-row-heading">
						<label for="ehf_template_type"><?php esc_html_e( 'Select the type of template this is', 'rx-theme-assistant' ); ?></label>
					</td>
					<td class="hfe-options-row-content">
					<select name="ehf_template_type" id="ehf_template_type">
						<option value="" <?php selected( $template_type, '' ); ?>><?php esc_html_e( 'Select Option', 'rx-theme-assistant' ); ?></option>
						<option value="type_header" <?php selected( $template_type, 'type_header' ); ?>><?php esc_html_e( 'Header', 'rx-theme-assistant' ); ?></option>
						<option value="type_footer" <?php selected( $template_type, 'type_footer' ); ?>><?php esc_html_e( 'Footer', 'rx-theme-assistant' ); ?></option>
					</select>
					</td>
				</tr>
				<tr class="hfe-options-row">
					<td class="hfe-options-row-heading">
						<label for="display-on-canvas-template"><?php esc_html_e( 'Display Layout automatically on Elementor Canvas Template?', 'rx-theme-assistant' ); ?></label>
						<p class="description"><?php esc_html_e( 'Enabling this option will display this layout on pages using Elementor Canvas Template.', 'rx-theme-assistant' ); ?></p>
					</td>
					<td class="hfe-options-row-content">
						<input type="checkbox" id="display-on-canvas-template" name="display-on-canvas-template" value="1" <?php checked( $display_on_canvas, true ); ?> />
					</td>
				</tr>
				<tr class="hfe-options-row">
					<td class="hfe-options-row-heading">
						<label for="global-template"><?php esc_html_e( 'Set this template for all pages.', 'rx-theme-assistant' ); ?></label>
					</td>
					<td class="hfe-options-row-content">
						<input type="checkbox" id="global-template" name="global-template" value="true" <?php checked( $global_template, true ); ?> />
					</td>
				</tr>
				<tr class="hfe-options-row">
					<td class="hfe-options-row-heading">
						<label for="set-stick-up"><?php esc_html_e( 'Stick Template.' ); ?></label>
						<p class="description"><?php esc_html_e(  'The option allows you to stick the header to the top of the page and the footer to the bottom of the page when scrolling.. If you want to hide some elements in the sticky menu, just add the class "hide-on-stick-up" to the element.', 'rx-theme-assistant' ); ?></p>
					</td>
					<td class="hfe-options-row-content">
						<input type="checkbox" id="set-stick-up" name="set-stick-up" value="true" <?php checked( $stick_up_template, true ); ?> />
					</td>
				</tr>
				</tbody>
			</table>
			<?php
		}

		/**
		 * Save meta field.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  POST $post_id Currennt post object which is being displayed.
		 * @return void
		 */
		public function rx_theme_assistant_save_meta( $post_id ) {
			// Bail if we're doing an auto save.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			// if our nonce isn't there, or we can't verify it, bail.
			if ( ! isset( $_POST['ehf_meta_nounce'] ) || ! wp_verify_nonce( $_POST['ehf_meta_nounce'], 'ehf_meta_nounce' ) ) {
				return;
			}

			// if our current user can't edit this post, bail.
			if ( ! current_user_can( 'edit_posts' ) ) {
				return;
			}

			if ( isset( $_POST['global-template'] ) ) {
				update_post_meta( $post_id, 'global-template', esc_attr( $_POST['global-template'] ) );
			} else {
				delete_post_meta( $post_id, 'global-template' );
			}

			if ( isset( $_POST['set-stick-up'] ) ) {
				update_post_meta( $post_id, 'set-stick-up', esc_attr( $_POST['set-stick-up'] ) );
			} else {
				delete_post_meta( $post_id, 'set-stick-up' );
			}
		}

		/**
		 * Return custom header/footer.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		static public function rx_theme_assistant_return_template( $location = "" ) {
			global $header_is_stick_up;

			$post_id = rx_theme_assistant_tools()->is_blog() ? get_option('page_for_posts') : get_the_ID();
			$template_id = get_post_meta( $post_id, 'rx_theme_assistant_page_'. $location, true );

			if ( ! $template_id || 'default' === $template_id ){
				$posts = self::rx_theme_assistant_get_global_templates( 'type_' . $location );
				$template_id = ! empty( $posts ) ? $posts[0]->ID : 'default' ;
			}

			if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
				$translate_template_id = apply_filters( 'wpml_object_id', $template_id, 'elementor-hf' );
				$template_id = $translate_template_id ? $translate_template_id : $template_id ;
			}

			if ( self::$elementor_instance && $template_id && 'default' !== $template_id ){
				$is_stick_up = get_post_meta( $template_id, 'set-stick-up', true );

				echo $is_stick_up && ! rx_theme_assistant_tools()->in_elementor() ? '<span class="rx-stick-' . $location . '"></span>' : '';
				echo self::$elementor_instance->frontend->get_builder_content_for_display( $template_id );

				return true;
			}

			return false;
		}

		/**
		 * Notice.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function rx_theme_assistant_location_notice() {
			global $pagenow;
			global $post;

			if ( 'post.php' != $pagenow || ! is_object( $post ) || 'elementor-hf' != $post->post_type ) {
				return;
			}

			$post_id = get_the_ID();
			$template_type = get_post_meta( $post_id, 'ehf_template_type', true );
			$global_posts = self::rx_theme_assistant_get_global_templates( $template_type );

			if( count( $global_posts ) > 1 ){
				$type = str_replace( 'type_', '', $template_type );
				$message = sprintf( esc_html__( 'Several %1$s templates are set global. Will be shown only one.', 'rx-theme-assistant'), $type );

				echo '<div class="error"><p>';
				echo $message;
				echo '</p></div>';
			}
		}

		/**
		 * Notice.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		static public function rx_theme_assistant_get_global_templates( $location = 'header' ) {
			return get_posts( array(
				'post_type'   => 'elementor-hf',
				'post_status' => 'publish',
				'meta_query'  => array(
					array(
						'key'   => 'ehf_template_type',
						'value' => $location,
					),
					array(
						'key'   => 'global-template',
						'value' => 'true',
					)
				)
			) );
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
 * Returns instance of Rx_Theme_Assistant_Header_Footer_Plugin_Ext
 *
 * @return object
 */
function Rx_Theme_Assistant_Header_Footer_Plugin_Ext() {
	if ( class_exists( 'Header_Footer_Elementor' ) && class_exists( 'Elementor\Plugin' ) ) {
		return Rx_Theme_Assistant_Header_Footer_Plugin_Ext::get_instance();
	}
}
Rx_Theme_Assistant_Header_Footer_Plugin_Ext();
