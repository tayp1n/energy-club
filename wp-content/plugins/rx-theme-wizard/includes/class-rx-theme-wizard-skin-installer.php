<?php
/**
 * Settings manager
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Rx_Theme_Wizard_Skin_Installer' ) ) {

	/**
	 * Define Rx_Theme_Wizard_Skin_Installer class
	 */
	class Rx_Theme_Wizard_Skin_Installer {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Holder for current skin data.
		 *
		 * @var array
		 */
		private $remout_skin = null;

		/**
		 * Holder for current skin data.
		 *
		 * @var array
		 */
		private $theme_slug = null;


		/**
		 * Constructor for the class
		 */
		function __construct() {
			$get_remout_skin= rx_theme_wizard_settings()->get( array( 'skins', 'advanced' ) );
			foreach ( $get_remout_skin as $parent_slug => $url ) {
				if( 'default' !== $parent_slug ){
					$this->theme_slug = $parent_slug;
					$this->remout_skin = rx_theme_wizard_settings()->get_remote_data( $url, $this->theme_slug . '_template_skins') ;
					break;
				}
			}

			add_action( 'admin_enqueue_scripts', array( $this, 'generate_nonce' ) );

			if( wp_doing_ajax() ){
				add_action( 'wp_ajax_rx_theme_wizard_install_skin', array( $this, 'rx_theme_wizard_install_skin' ) );
				add_action( 'wp_ajax_nopriv_rx_theme_wizard_install_skin', array( $this, 'rx_theme_wizard_install_skin' ) );
			}
		}

		/**
		 *
		 *
		 * @return array
		 */
		public function get_theme_skins() {
			if( ! $this->remout_skin ){
				return false;
			}

			$admin_url = esc_url( admin_url( 'admin.php' ) );
			$template_skins = get_option( $this->theme_slug . '_template_skins', array() );

			?>
			<div class="rx-theme-wizard-skins rx-theme-wizard-row">
				<div class="rx-theme-wizard-col col-12">
					<h2 class><?php esc_html_e( 'Template Skin', 'rx-theme-wizard' ); ?></h2>
				</div>
				<div class="rx-theme-wizard-skin-preview col-12">
					<?php
						foreach ( $this->remout_skin as $skin_slug => $value ) {
							$is_instaled = $this->check_skin_installed( $skin_slug ) ? 'is_instaled dashicons dashicons-yes' : '' ;
							?>
							<div class="rx-theme-wizard-skin-item">
								<div class="rx-theme-wizard-skin-item-content">
									<?php if ( $value['thumb'] ) : ?>
										<div class="rx-theme-wizard-skin-item__thumb">
											<a href="<?php echo $value['demo']; ?>" target="_blank"><img src="<?php echo $value['thumb']; ?>" alt="<?php echo $value['name']; ?>"></a>
										</div>
									<?php endif; ?>
									<div class="rx-theme-wizard-skin-item__summary">
										<h4 class="rx-theme-wizard-skin-item__title"><?php echo $value['name']; ?></h4>
										<div class="rx-theme-wizard-skin-item__actions">
											<a href="<?php echo $admin_url; ?>" data-loader="true" class="btn btn-primary rx-theme-install-template-skin <?php echo $is_instaled ?>" data-skin="<?php echo $skin_slug ?>"><span class="text"><?php esc_html_e( 'Start Install', 'rx-theme-wizard' ); ?></span><span class="rx-theme-wizard-loader"><span class="rx-theme-wizard-loader__spinner"></span></span></a>
											<a href="<?php echo $value['demo']; ?>" data-loader="true" class="btn btn-default" target="_blank"><?php esc_html_e( 'View Demo', 'rx-theme-wizard' ); ?></a>
										</div>
										<div class="rx-theme-wizard-skin-item__notice"></div>
									</div>
								</div>
							</div>
					<?php } ?>
				</div>
			</div>
			<?php
		}

		/**
		 *
		 *
		 * @return array
		 */
		public function generate_nonce(){
			wp_localize_script( 'rx-theme-wizard', 'rxThemeWizard',
				array(
					'nonce' => wp_create_nonce('rx-theme-wizard-nonce')
				)
			);
		}

		/**
		 *
		 *
		 * @return array
		 */
		public function rx_theme_wizard_install_skin() {
			$skin_slug = empty( $_POST['skinSlug'] ) ? false : $_POST['skinSlug'] ;

			if( ! $skin_slug || $this->check_skin_installed( $skin_slug ) || ! check_ajax_referer( 'rx-theme-wizard-nonce', 'nonce_code' ) ){
				exit();
			}

			$template_skins = get_option( $this->theme_slug . '_template_skins', array() );
			$url            = $this->remout_skin[ $skin_slug ]['package'];
			$upgrader       = new Theme_Upgrader( new Rx_Theme_Wizard_Skin_Upgrader() );
			$install_result = $upgrader->install( $url );

			if( is_wp_error( $install_result ) ){
				$support_link = sprintf( '<a href="https://rovadex.ticksy.com/" alt="%1$s" target="_blank">%1$s</a>', esc_html__( 'our support team', 'rx-theme-wizard' ) );

				wp_send_json_error( array(
					'errorMessage' => sprintf( esc_html__( 'Sorry. Installation error. Please contact %s.', 'rx-theme-wizard' ), $support_link ),
				) );
			}else{
				$skin_version = isset( $this->remout_skin[ $skin_slug ]['version'] ) ? $this->remout_skin[ $skin_slug ]['version'] : '1.0.0' ;
				$template_skins[ $skin_slug ] = array(
					'installed' => true,
					'version' => $skin_version
				);
				update_option( $this->theme_slug . '_template_skins', $template_skins );

				switch_theme( $skin_slug );

				wp_send_json_success( array( 'redirecUrl' => esc_url( admin_url( 'themes.php' ) ) ) );
			}

			exit();
		}

		/**
		 *
		 *
		 * @return array
		 */
		public function check_skin_installed( $skin_slug ) {
			$template_skins = get_option(  $this->theme_slug . '_template_skins', array() );
			$skin_path      = get_theme_root() . "\\" . $skin_slug . "\\functions.php";

			if( ! empty( $template_skins[ $skin_slug ][ 'installed' ] ) && $template_skins[ $skin_slug ][ 'installed'] && file_exists( $skin_path ) ){
				return true;
			} else {
				return false;
			}
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
 * Returns instance of Rx_Theme_Wizard_Skin_Installer
 *
 * @return object
 */
function Rx_Theme_Wizard_Skin_Installer() {
	return Rx_Theme_Wizard_Skin_Installer::get_instance();
}
Rx_Theme_Wizard_Skin_Installer();
