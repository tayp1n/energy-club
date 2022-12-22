<?php
/**
 * Installer class
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Rx_Theme_Wizard_Installer' ) ) {

	/**
	 * Define Rx_Theme_Wizard_Installer class
	 */
	class Rx_Theme_Wizard_Installer {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Installer storage
		 *
		 * @var object
		 */
		public $installer = null;

		/**
		 * Is wizard page trigger
		 *
		 * @var boolean
		 */
		private $is_wizard = false;

		/**
		 * Installation log.
		 *
		 * @var null
		 */
		private $log = null;

		/**
		 * Constructor for the class
		 */
		function __construct() {
			add_action( 'wp_ajax_rx_theme_wizard_install_plugin', array( $this, 'install_plugin' ) );
			add_action( 'wp_ajax_rx_theme_wizard_process_single_plugin', array( $this, 'process_single_plugin' ) );
		}

		/**
		 * Check if currently processing wizard request.
		 *
		 * @return bool
		 */
		public function is_wizard_request() {
			return $this->is_wizard;
		}

		/**
		 * AJAX-callback for plugin install
		 *
		 * @return void
		 */
		public function install_plugin() {

			$this->is_wizard = true;

			if ( ! current_user_can( 'install_plugins' ) ) {
				wp_send_json_error(
					array( 'message' => esc_html__( 'You don\'t have permissions to do this', 'rx-theme-wizard' ) )
				);
			}

			$plugin = ! empty( $_GET['slug'] ) ? esc_attr( $_GET['slug'] ) : false;
			$skin   = ! empty( $_GET['skin'] ) ? esc_attr( $_GET['skin'] ) : false;
			$type   = ! empty( $_GET['type'] ) ? esc_attr( $_GET['type'] ) : false;
			$first  = ! empty( $_GET['isFirst'] ) ? esc_attr( $_GET['isFirst'] ) : false;
			$first  = filter_var( $first, FILTER_VALIDATE_BOOLEAN );

			add_filter( 'site_transient_update_core', array( $this, 'disable_plugin_translate' ), 10, 2 );
			add_filter( 'site_transient_update_themes', array( $this, 'disable_plugin_translate' ), 10, 2 );
			add_filter( 'site_transient_update_plugins', array( $this, 'disable_plugin_translate' ), 10, 2 );

			if ( ! $plugin || ! $skin || ! $type ) {
				wp_send_json_error(
					array( 'message' => esc_html__( 'No plugin to install', 'rx-theme-wizard' ) )
				);
			}

			$this->do_plugin_install( rx_theme_wizard_data()->get_plugin_data( $plugin ) );

			$next = rx_theme_wizard_data()->get_next_skin_plugin( $plugin, $skin, $type );

			$result_type = isset( $this->installer->skin->result_type )
								? $this->installer->skin->result_type
								: 'success';

			if ( $first ) {
				$active_skin = get_option( 'tm_active_skin' );
				if ( $active_skin ) {
					add_filter( 'rx-theme-wizard/deactivate-skin-plugins', array( $this, 'unset_next_skin_plugins' ) );
					$this->deactivate_skin_plugins( $active_skin['skin'], $active_skin['type'] );
					remove_filter( 'rx-theme-wizard/deactivate-skin-plugins', array( $this, 'unset_next_skin_plugins' ) );
				}
			}

			if ( ! $next ) {

				$message  = esc_html__( 'All plugins are installed. Redirecting to the next step...', 'rx-theme-wizard' );
				$redirect = apply_filters(
					'rx-theme-wizards/install-finish-redirect',
					rx_theme_wizard()->get_page_link( array( 'step' => 4, 'skin' => $skin, 'type' => $type ) )
				);

				delete_option( 'rx_theme_wizard_show_notice' );
				delete_option( 'tm_active_skin' );
				delete_option( rx_theme_wizard_data()->advances_plugins );
				add_option( 'tm_active_skin', array( 'skin' => $skin, 'type' => $type ), '', false );

				do_action( 'rx-theme-wizard/install-finished' );

				$data = array(
					'isLast'     => true,
					'message'    => sprintf( '<div class="rx-theme-wizard-installed">%s</div>', $message ),
					'redirect'   => $redirect,
					'log'        => $this->log,
					'resultType' => $result_type,
				);

				$this->send_success( $data, $plugin );
			}

			$registered = rx_theme_wizard_settings()->get( array( 'plugins' ) );

			if ( ! isset( $registered[ $next ] ) ) {
				wp_send_json_error(
					array( 'message' => esc_html__( 'This plugin is not registered', 'rx-theme-wizard' ) )
				);
			}

			$data = array_merge(
				$registered[ $next ],
				array(
					'isLast'     => false,
					'skin'       => $skin,
					'type'       => $type,
					'slug'       => $next,
					'log'        => $this->log,
					'resultType' => $result_type,
				)
			);

			remove_filter( 'site_transient_update_core', array( $this, 'disable_plugin_translate' ), 10, 2 );
			remove_filter( 'site_transient_update_themes', array( $this, 'disable_plugin_translate' ), 10, 2 );
			remove_filter( 'site_transient_update_plugins', array( $this, 'disable_plugin_translate' ), 10, 2 );

			$this->send_success( $data, $plugin );

		}

		/**
		 * Send JSON success after plugin instalation.
		 *
		 * @param  array  $data   Data to send.
		 * @param  string $plugin Information about current plugin.
		 * @return void
		 */
		public function send_success( $data = array(), $plugin = '' ) {

			wp_send_json_success( apply_filters( 'rx-theme-wizard/send-install-data', $data, $plugin ) );

		}

		/**
		 * Remove plugins required for next skin from deactivation list.
		 *
		 * @param  array $plugins Plugins list.
		 * @return array
		 */
		public function unset_next_skin_plugins( $plugins = array() ) {

			$skin = ! empty( $_GET['skin'] ) ? esc_attr( $_GET['skin'] ) : false;
			$type = ! empty( $_GET['type'] ) ? esc_attr( $_GET['type'] ) : false;

			if ( ! $type || ! $skin || empty( $plugins ) ) {
				return $plugins;
			}

			$skin_plugins = rx_theme_wizard_data()->get_skin_plugins( $skin );
			$skin_plugins = $skin_plugins[ $type ];

			if ( empty( $skin_plugins ) ) {
				return $plugins;
			}

			return array_diff( $plugins, $skin_plugins );
		}

		/**
		 * Deactivate current skin plugins.
		 *
		 * @param  string $skin Skin slug.
		 * @param  string $type Skin type.
		 * @return null
		 */
		public function deactivate_skin_plugins( $skin = null, $type = null ) {

			$skins   = rx_theme_wizard_settings()->get( array( 'skins' ) );
			$plugins = isset( $skins['advanced'][ $skin ][ $type ] ) ? $skins['advanced'][ $skin ][ $type ] : array();
			$active  = get_option( 'active_plugins' );
			$plugins = apply_filters( 'rx-theme-wizard/deactivate-skin-plugins', $plugins, $skin );

			if ( ! $plugins ) {
				return;
			}

			foreach ( $plugins as $plugin ) {
				foreach ( $active as $active_plugin ) {
					if ( false !== strpos( $active_plugin, $plugin ) ) {
						deactivate_plugins( $active_plugin );
					}
				}
			}

		}

		/**
		 * Process single plugins installation or activation
		 *
		 * @return void
		 */
		public function process_single_plugin() {

			$action = isset( $_REQUEST['pluginAction'] ) ? esc_attr( $_REQUEST['pluginAction'] ) : false;

			if ( 'install' === $action ) {
				$this->install_single_plugin();
			}

			if ( 'activate' === $action ) {
				$this->activate_single_plugin();
			}

			wp_send_json_error( array(
				'message' => esc_html__( 'Action not provided', 'rx-theme-wizard' ),
			) );

		}

		/**
		 * Process single plugin installation
		 *
		 * @return void
		 */
		public function install_single_plugin() {

			$slug = isset( $_REQUEST['slug'] ) ? esc_attr( $_REQUEST['slug'] ) : false;

			if ( ! $slug ) {
				wp_send_json_error( array(
					'message' => esc_html__( 'Plugin slug not provided', 'rx-theme-wizard' ),
				) );
			}

			$this->do_plugin_install( rx_theme_wizard_data()->get_plugin_data( $slug ), false );

			$result_type = isset( $this->installer->skin->result_type )
								? $this->installer->skin->result_type
								: 'success';

			if ( 'success' === $result_type ) {

				ob_start();
				rx_theme_wizard_ext()->single_plugin_item( $slug, rx_theme_wizard_data()->get_plugin_data( $slug ) );
				$item = ob_get_clean();

				wp_send_json_success( array(
					'message' => $item,
				) );
			} else {
				wp_send_json_error( array(
					'message' => esc_html__( 'Installation failed', 'rx-theme-wizard' ),
					'log'     => $this->log
				) );
			}

		}

		/**
		 * Process single plugin activation
		 *
		 * @return void
		 */
		public function activate_single_plugin() {

			$path = isset( $_REQUEST['path'] ) ? esc_attr( $_REQUEST['path'] ) : false;
			$slug = isset( $_REQUEST['slug'] ) ? esc_attr( $_REQUEST['slug'] ) : false;

			if ( ! $path || ! $slug ) {
				wp_send_json_error( array(
					'message' => esc_html__( 'Plugin data not provided', 'rx-theme-wizard' ),
				) );
			}

			$activate = $this->activate_plugin( $path );

			if ( ! is_wp_error( $activate ) ) {

				ob_start();
				rx_theme_wizard_ext()->single_plugin_item( $slug, rx_theme_wizard_data()->get_plugin_data( $slug ) );
				$item = ob_get_clean();

				wp_send_json_success( array(
					'message' => $item,
				) );
			} else {
				wp_send_json_error( array(
					'message' => esc_html__( 'Can\'t perform plugin activation. Please try again later', 'rx-theme-wizard' ),
				) );
			}

		}

		/**
		 * Process plugin installation.
		 *
		 * @param  array $plugin   Plugin data.
		 * @param  bool  $activate Perform plugin activation or not.
		 * @return bool
		 */
		public function do_plugin_install( $plugin = array(), $activate = true ) {

			/**
			 * Hook fires before plugin installation.
			 *
			 * @param array $plugin Plugin data array.
			 */
			do_action( 'rx-theme-wizard/before-plugin-install', $plugin );

			$this->log = null;
			ob_start();

			$this->dependencies();

			$source          = $this->locate_source( $plugin );
			$this->installer = new Rx_Theme_Wizard_Plugin_Upgrader(
				new Rx_Theme_Wizard_Plugin_Upgrader_Skin(
					array(
						'url'    => false,
						'plugin' => $plugin['slug'],
						'source' => $plugin['source'],
						'title'  => $plugin['name'],
					)
				)
			);

			$installed       = $this->installer->install( $source );
			$this->log       = ob_get_clean();
			$plugin_activate = $this->installer->plugin_info();

			/**
			 * Hook fires after plugin installation but before activation.
			 *
			 * @param array $plugin Plugin data array.
			 */
			do_action( 'rx-theme-wizard/after-plugin-install', $plugin );


			if ( false !== $activate ) {
				$this->activate_plugin( $plugin_activate, $plugin['slug'] );
			}

			/**
			 * Hook fires after plugin activation.
			 *
			 * @param array $plugin Plugin data array.
			 */
			do_action( 'rx-theme-wizard/after-plugin-activation', $plugin );

			return $installed;
		}

		/**
		 * Activate plugin.
		 *
		 * @param  string $activation_data Activation data.
		 * @param  string $slug            Plugin slug.
		 * @return WP_Error|null
		 */
		public function activate_plugin( $activation_data, $slug ) {

			if ( ! empty( $activation_data ) ) {
				$activate = activate_plugin( $activation_data );
				return $activate;
			}

			$all_plugins = get_plugins();

			if ( empty( $all_plugins ) ) {
				return null;
			}

			$all_plugins = array_keys( $all_plugins );

			foreach ( $all_plugins as $plugin ) {

				if ( false === strpos( $plugin, $slug ) ) {
					continue;
				}

				if ( ! is_plugin_active( $plugin ) ) {
					$activate = activate_plugin( $plugin );
					return $activate;
				}
			}

			return null;
		}

		/**
		 * Returns plugin installation source URL.
		 *
		 * @param  array  $plugin Plugin data.
		 * @return string
		 */
		public function locate_source( $plugin = array() ) {

			$source = isset( $plugin['source'] ) ? $plugin['source'] : 'wordpress';
			$result = false;

			switch ( $source ) {
				case 'wordpress':

					require_once ABSPATH . 'wp-admin/includes/plugin-install.php'; // Need for plugins_api

					$api = plugins_api(
						'plugin_information',
						array( 'slug' => $plugin['slug'], 'fields' => array( 'sections' => false ) )
					);

					if ( is_wp_error( $api ) ) {
						wp_die( $this->installer->strings['oops'] . var_dump( $api ) );
					}

					if ( isset( $api->download_link ) ) {
						$result = $api->download_link;
					}

					break;

				case 'local':
					$result = ! empty( $plugin['path'] ) ? $plugin['path'] : false;
					break;

				case 'remote':
					$result = ! empty( $plugin['path'] ) ? esc_url( $plugin['path'] ) : false;
					break;

				case 'crocoblock':

					if ( rx_theme_wizard_license()->is_enabled() ) {
						$api_url = rx_theme_wizard_settings()->get( array( 'license', 'server' ) );
						$result  = add_query_arg(
							array(
								'ct_api_action' => 'get_plugin',
								'license'       => rx_theme_wizard_license()->get_license(),
								'url'           => urlencode( home_url( '/' ) ),
								'slug'          => $plugin['slug'],
							),
							$api_url
						);
					}

					break;
			}

			return $result;
		}

		/**
		 * Include dependencies.
		 *
		 * @return void
		 */
		public function dependencies() {

			if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
				require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			}

			require_once rx_theme_wizard()->path( 'includes/class-rx-theme-wizard-plugin-upgrader-skin.php' );
			require_once rx_theme_wizard()->path( 'includes/class-rx-theme-wizard-plugin-upgrader.php' );
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
 * Returns instance of Rx_Theme_Wizard_Installer
 *
 * @return object
 */
function rx_theme_wizard_installer() {
	return Rx_Theme_Wizard_Installer::get_instance();
}

rx_theme_wizard_installer();
