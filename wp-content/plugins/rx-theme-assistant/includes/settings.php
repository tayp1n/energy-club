<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Rovadex
 * @license   GPL-2.0+
 */

use Elementor\Plugin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Rx_Theme_Assistant_Settings' ) ) {

	/**
	 * Define Rx_Theme_Assistant_Settings class
	 */
	class Rx_Theme_Assistant_Settings {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * [$key description]
		 * @var string
		 */
		public $key = 'rx-theme-assistant-settings';

		/**
		 * [$builder description]
		 * @var null
		 */
		public $interface_builder  = null;

		/**
		 * [$settings description]
		 * @var null
		 */
		public $settings = null;

		/**
		 * [$default_avaliable_widgets description]
		 * @var array
		 */
		public $default_avaliable_widgets = [];

		/**
		 * [$avaliable_widgets description]
		 * @var array
		 */
		public $avaliable_widgets = [];

		/**
		 * [$is_customizer_option description]
		 * @var array
		 */
		public $is_customizer_option = [
			'blog_sidebar_position',
			'single_sidebar_position',
		];

		/**
		 * [$default_avaliable_extensions description]
		 * @var [type]
		 */
		public $default_avaliable_extensions = [
			'widget_parallax'  => 'true',
			'widget_satellite' => 'true',
		];

		/**
		 * Init page
		 */
		public function init() {

			if ( ! $this->is_enabled() ) {
				return;
			}

			add_action( 'init', array( $this, 'init_interface_builder' ), 0 );
			add_action( 'admin_menu', array( $this, 'register_page' ), 99 );
			add_action( 'init', array( $this, 'save' ), 40 );
			add_action( 'admin_notices', array( $this, 'saved_notice' ) );

			$this->prepare_avaliable_widget_data();
		}

		/**
		 * Is default settings page enabled or not.
		 *
		 * @return boolean
		 */
		public function is_enabled() {
			return apply_filters( 'rx-theme-assistant/settings-page/is-enabled', true );
		}

		/**
		 * [prepare_avaliable_widget description]
		 * @return [type] [description]
		 */
		public function prepare_avaliable_widget_data() {

			foreach ( glob( rx_theme_assistant()->plugin_path( 'includes/addons/' ) . '*.php' ) as $file ) {
				$data = get_file_data( $file, array( 'class'=>'Class', 'name' => 'Name', 'slug'=>'Slug' ) );

				$slug = basename( $file, '.php' );
				$this->avaliable_widgets[ $slug ] = $data['name'];
				$this->default_avaliable_widgets[ $slug ] = 'true';
			}
		}

		/**
		 * [init_interface_builder description]
		 *
		 * @return [type] [description]
		 */
		public function init_interface_builder() {

			if ( isset( $_REQUEST['page'] ) && $this->key === $_REQUEST['page'] ) {

				$builder_data = rx_theme_assistant()->framework->get_included_module_data( 'cherry-x-interface-builder.php' );

				$this->interface_builder = new CX_Interface_Builder(
					array(
						'path' => $builder_data['path'],
						'url'  => $builder_data['url'],
					)
				);

				$this->set_settings_page();
			}
		}

		/**
		 * Show saved notice
		 *
		 * @return bool
		 */
		public function saved_notice() {

			if ( ! isset( $_REQUEST['page'] ) || $this->key !== $_REQUEST['page'] ) {
				return false;
			}

			if ( ! isset( $_GET['settings-saved'] ) ) {
				return false;
			}

			$message = esc_html__( 'Settings saved', 'rx-theme-assistant' );

			printf( '<div class="notice notice-success is-dismissible"><p>%s</p></div>', $message );

			return true;

		}

		/**
		 * Save settings
		 *
		 * @return void
		 */
		public function save() {

			if ( ! isset( $_REQUEST['page'] ) || $this->key !== $_REQUEST['page'] ) {
				return;
			}

			if ( ! isset( $_REQUEST['action'] ) || 'save-settings' !== $_REQUEST['action'] ) {
				return;
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			$current = get_option( $this->key, array() );
			$data    = $_REQUEST;

			unset( $data['action'] );

			foreach ( $data as $key => $value ) {
				$current[ $key ] = is_array( $value ) ? $value : esc_attr( $value );

				if( in_array( $key, $this->is_customizer_option ) ){
					set_theme_mod( $key, $value );
				}
			}

			update_option( $this->key, $current );

			$redirect = add_query_arg(
				array( 'dialog-saved' => true ),
				$this->get_settings_page_link()
			);

			wp_redirect( $redirect );
			die();

		}

		/**
		 * Update single option key in options array
		 *
		 * @return void
		 */
		public function save_key( $key, $value ) {

			$current         = get_option( $this->key, array() );
			$current[ $key ] = $value;

			update_option( $this->key, $current );

		}

		/**
		 * Return settings page URL
		 *
		 * @return string
		 */
		public function get_settings_page_link() {

			return add_query_arg(
				array(
					'page' => $this->key,
				),
				esc_url( admin_url( 'admin.php' ) )
			);

		}

		/**
		 * [get description]
		 * @param  [type]  $setting [description]
		 * @param  boolean $default [description]
		 * @return [type]           [description]
		 */
		public function get( $setting, $default = false ) {

			if ( null === $this->settings ) {
				$this->settings = get_option( $this->key, array() );
			}

			return isset( $this->settings[ $setting ] ) ? $this->settings[ $setting ] : $default;
		}

		/**
		 * Register add/edit page
		 *
		 * @return void
		 */
		public function register_page() {
			add_menu_page(
				esc_html__( 'Theme Assistant', 'rx-theme-assistant' ),
				esc_html__( 'Theme Assistant', 'rx-theme-assistant' ),
				'manage_options',
				$this->key,
				array( $this, 'render_page' ),
				rx_theme_assistant()->plugin_url( 'assets/images/rovadex-icon.png' ),
				100
			);
		}

		/**
		 * Set settings page
		 *
		 * @return void
		 */
		public function set_settings_page() {

			$this->interface_builder->register_section(
				array(
					'rx_theme_assistant_settings' => array(
						'type'   => 'section',
						'scroll' => false,
						'title'  => esc_html__( 'Rx Theme Settings', 'rx-theme-assistant' ),
					),
				)
			);

			$this->interface_builder->register_form(
				array(
					'rx_theme_assistant_settings_form' => array(
						'type'   => 'form',
						'parent' => 'rx_theme_assistant_settings',
						'action' => add_query_arg(
							array( 'page' => $this->key, 'action' => 'save-settings' ),
							esc_url( admin_url( 'admin.php' ) )
						),
					),
				)
			);

			$this->interface_builder->register_settings(
				array(
					'settings_top' => array(
						'type'   => 'settings',
						'parent' => 'rx_theme_assistant_settings_form',
					),
					'settings_bottom' => array(
						'type'   => 'settings',
						'parent' => 'rx_theme_assistant_settings_form',
					),
				)
			);

			$this->interface_builder->register_component(
				array(
					'rx_theme_assistant_tab_vertical' => array(
						'type'   => 'component-tab-vertical',
						'parent' => 'settings_top',
					),
				)
			);

			$this->interface_builder->register_settings(
				array(
					'google_api_options' => array(
						'parent'      => 'rx_theme_assistant_tab_vertical',
						'title'       => esc_html__( 'Google API', 'rx-theme-assistant' ),
					),
				)
			);

			$this->interface_builder->register_settings(
				array(
					'additional_icons_options' => array(
						'parent'      => 'rx_theme_assistant_tab_vertical',
						'title'       => esc_html__( 'Font Extensions', 'rx-theme-assistant' ),
					),
				)
			);

			$this->interface_builder->register_settings(
				array(
					'avaliable_widgets_options' => array(
						'parent'      => 'rx_theme_assistant_tab_vertical',
						'title'       => esc_html__( 'Elementor Widgets', 'rx-theme-assistant' ),
					),
				)
			);

			$this->interface_builder->register_settings(
				array(
					'avaliable_extensions_options' => array(
						'parent'      => 'rx_theme_assistant_tab_vertical',
						'title'       => esc_html__( 'Elementor Extensions', 'rx-theme-assistant' ),
					),
				)
			);

			$this->interface_builder->register_settings(
				array(
					'avaliable_dynamic_pages_options' => array(
						'parent'      => 'rx_theme_assistant_tab_vertical',
						'title'       => esc_html__( 'Dynamic Pages', 'rx-theme-assistant' ),
					),
				)
			);

			$controls = $this->get_controls_list( 'settings_top' );

			$this->interface_builder->register_control( $controls );

			$this->interface_builder->register_html(
				array(
					'save_button' => array(
						'type'   => 'html',
						'parent' => 'settings_bottom',
						'class'  => 'cherry-control dialog-save',
						'html'   => '<button type="submit" class="cx-button cx-button-primary-style">' . esc_html__( 'Save', 'rx-theme-assistant' ) . '</button>',
					),
				)
			);
		}

		/**
		 * Render settings page
		 *
		 * @return void
		 */
		public function render_page() {
			echo '<div class="rx-theme-assistant-settings-page">';
				$this->interface_builder->render();
			echo '</div>';
		}

		/**
		 * Returns parent-independent controls list
		 *
		 * @return void
		 */
		public function get_controls_list( $parent = 'settings_top' ) {
			$settings = array();

			$settings['nucleo-mini-package'] = array(
					'type'        => 'switcher',
					'parent'      => 'additional_icons_options',
					'title'       => esc_html__( 'Use nucleo-mini icon package', 'rx-theme-assistant' ),
					'description' => esc_html__( 'Add nucleo-mini icon package to Elementor icon picker control', 'rx-theme-assistant' ),
					'value'       => $this->get( 'nucleo-mini-package' ),
					'toggle'      => array(
						'true_toggle'  => 'On',
						'false_toggle' => 'Off',
					),
				);

			$settings['font-awesome-package'] = array(
				'type'        => 'switcher',
				'parent'      => 'additional_icons_options',
				'title'       => esc_html__( 'Use Font Awesome 5 icon package', 'rx-theme-assistant' ),
				'description' => esc_html__( 'Add Font Awesome 5 icon package to Elementor icon picker control', 'rx-theme-assistant' ),
				'value'       => $this->get( 'font-awesome-package' ),
				'toggle'      => array(
					'true_toggle'  => 'On',
					'false_toggle' => 'Off',
				),
			);

			$settings['google_api_key'] = array(
				'type'        => 'text',
				'id'          => 'google_api_key',
				'name'        => 'google_api_key',
				'parent'      => 'google_api_options',
				'value'       => $this->get( 'google_api_key' ),
				'title'       => esc_html__( 'Google API Key:', 'rx-theme-assistant' ),
				'placeholder' => esc_html__( 'Google API key', 'rx-theme-assistant' ),
				'description' => sprintf(
					esc_html__( 'Create own Google API key here %s', 'rx-theme-assistant' ),
					make_clickable( 'https://developers.google.com/maps/documentation/javascript/get-api-key' )
				)
			);

			$settings['disable_google_api_js'] = array(
				'type'        => 'checkbox',
				'id'          => 'disable_google_api_js',
				'name'        => 'disable_google_api_js',
				'parent'      => 'google_api_options',
				'value'       => $this->get( 'disable_google_api_js' ),
				'options'     => array( 'disable' => esc_html__( 'Disable', 'rx-theme-assistant' ), ),
				'title'       => esc_html__( 'Disable Google Maps API JS file:', 'rx-theme-assistant' ),
				'description' => esc_html__( 'Disable Google Maps API JS file, if it already included by another plugin or theme', 'rx-theme-assistant' ),
			);

			$settings['avaliable_widgets'] = array(
				'type'        => 'checkbox',
				'id'          => 'avaliable_widgets',
				'name'        => 'avaliable_widgets',
				'parent'      => 'avaliable_widgets_options',
				'value'       => $this->get( 'avaliable_widgets', $this->default_avaliable_widgets ),
				'options'     => $this->avaliable_widgets,
				'title'       => esc_html__( 'Avaliable Widgets', 'rx-theme-assistant' ),
				'description' => esc_html__( 'List of widgets that will be available when editing the page', 'rx-theme-assistant' ),
				'class'       => 'rx-theme-assistant-settings-form__checkbox-group'
			);

			$settings['avaliable_extensions'] = array(
				'type'        => 'checkbox',
				'id'          => 'avaliable_extensions',
				'name'        => 'avaliable_extensions',
				'parent'      => 'avaliable_extensions_options',
				'value'       => $this->get( 'avaliable_extensions', $this->default_avaliable_extensions ),
				'options'     => [
					'widget_parallax'  => esc_html__( 'Parallax Widget Extension', 'rx-theme-assistant' ),
					'widget_satellite' => esc_html__( 'Satellite Widget Extension', 'rx-theme-assistant' ),
					'section_actions'    => esc_html__( 'Section Actions Extension', 'rx-theme-assistant' ),
				],
				'title'       => esc_html__( 'Avaliable Extensions', 'rx-theme-assistant' ),
				'description' => esc_html__( 'List of Extension that will be available when editing the page', 'rx-theme-assistant' ),
				'class'       => 'rx-theme-assistant-settings-form__checkbox-group'
			);

			$settings['dynamic_pages_description'] = array(
				'type'        => 'html',
				'parent'      => 'avaliable_dynamic_pages_options',
				'html'        => sprintf( '<h4>%s</h4><p class="cx-ui-kit__description">%s</p>', esc_html__( 'Dynamic Pages', 'rx-theme-assistant' ), esc_html__( 'You can select a template for changing the static pages, for example a blog, single blog, 404 pages and others. Templates are in the library "Templates -> Saved Templates -> Page".', 'rx-theme-assistant' ) ),
				'class'       => 'rx-theme-assistant-settings-form__dynamic-pages-html'
			);

			$settings['dynamic_blog_pages'] = array(
				'type'        => 'select',
				'parent'      => 'avaliable_dynamic_pages_options',
				'filter'      => true,
				'placeholder' => esc_html__( '-- Select Page Template --', 'rx-theme-assistant' ),
				'title'       => esc_html__( 'Blog', 'rx-theme-assistant' ),
				'description' => esc_html__( 'For this page you can select any template from the library "Templates -> Saved Templates -> Page". Attention! The sidebar will remain unchanged.', 'rx-theme-assistant' ),
				'value'       => $this->get( 'dynamic_blog_pages', 'default' ),
				'options'     => $this->get_template_list(),
			);

			if ( class_exists( 'Rvdx_Theme_Setup' ) ) {
				$settings['blog_sidebar_position'] = array(
					'type'        => 'radio',
					'parent'      => 'avaliable_dynamic_pages_options',
					'placeholder' => esc_html__( 'Select', 'rx-theme-assistant' ),
					'title'       => esc_html__( 'Blog Sidebar', 'rvdx-theme' ),
					'filter'      => true,
					'value'       => rvdx_theme()->customizer->get_value( 'blog_sidebar_position' ),
					'options'     => array(
						'one-left-sidebar' => array(
							'label' => esc_html__( 'Sidebar on left side', 'rvdx-theme' ),
						),
						'one-right-sidebar' => array(
							'label' => esc_html__( 'Sidebar on right side', 'rvdx-theme' ),
						),
						'none' => array(
							'label' => esc_html__( 'No sidebar', 'rvdx-theme' ),
						),
					),
				);
			}

			$settings['dynamic_single_blog_pages'] = array(
				'type'        => 'select',
				'parent'      => 'avaliable_dynamic_pages_options',
				'filter'      => true,
				'placeholder' => esc_html__( '-- Select Page Template --', 'rx-theme-assistant' ),
				'title'       => esc_html__( 'Single Post', 'rx-theme-assistant' ),
				'description' => esc_html__( 'For this page you can select any template from the library "Templates -> Saved Templates -> Page". Attention! Comment blocks, related posts and sidebars will remain unchanged.', 'rx-theme-assistant' ),
				'value'       => $this->get( 'dynamic_single_blog_pages', 'default' ),
				'options'     => $this->get_template_list(),
			);

			if ( class_exists( 'Rvdx_Theme_Setup' ) ) {
				$settings['single_sidebar_position'] = array(
					'type'        => 'radio',
					'parent'      => 'avaliable_dynamic_pages_options',
					'placeholder' => esc_html__( 'Select', 'rx-theme-assistant' ),
					'title'       => esc_html__( 'Single Post Sidebar', 'rvdx-theme' ),
					'filter'      => true,
					'value'       => rvdx_theme()->customizer->get_value( 'single_sidebar_position' ),
					'options'     => array(
						'one-left-sidebar' => array(
							'label' => esc_html__( 'Sidebar on left side', 'rvdx-theme' ),
						),
						'one-right-sidebar' => array(
							'label' => esc_html__( 'Sidebar on right side', 'rvdx-theme' ),
						),
						'none' => array(
							'label' => esc_html__( 'No sidebar', 'rvdx-theme' ),
						),
					),
				);
			}

			$settings['dynamic_search_pages'] = array(
				'type'        => 'select',
				'parent'      => 'avaliable_dynamic_pages_options',
				'filter'      => true,
				'placeholder' => esc_html__( '-- Select Page Template --', 'rx-theme-assistant' ),
				'title'       => esc_html__( 'Search Page ( if content not found )', 'rx-theme-assistant' ),
				'description' => esc_html__( 'For this page you can select any template from the library "Templates -> Saved Templates -> Page".', 'rx-theme-assistant' ),
				'value'       => $this->get( 'dynamic_search_pages', 'default' ),
				'options'     => $this->get_template_list(),
			);

			$settings['dynamic_404_pages'] = array(
				'type'        => 'select',
				'parent'      => 'avaliable_dynamic_pages_options',
				'filter'      => true,
				'placeholder' => esc_html__( '-- Select Page Template --', 'rx-theme-assistant' ),
				'title'       => esc_html__( '404 Page', 'rx-theme-assistant' ),
				'description' => esc_html__( 'For this page you can select any template from the library "Templates -> Saved Templates -> Page".', 'rx-theme-assistant' ),
				'value'       => $this->get( 'dynamic_404_pages', 'default' ),
				'options'     => $this->get_template_list(),
			);

			return apply_filters( 'rx-theme-assistant/settings-page/controls-list', $settings );
		}

		/**
		 * Get elementor template list.
		 *
		 * @return array
		 */
		public function get_template_list() {
			$result_list = array(
				'default' => esc_html__( 'Default View', 'rx-theme-assistant' ),
			);
			$templates = Plugin::$instance->templates_manager->get_source( 'local' )->get_items();

			if ( $templates ) {
				foreach ( $templates as $template ) {
					$result_list[ $template['template_id'] ] = $template['title'];
				}
			}

			return $result_list;
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
 * Returns instance
 *
 * @return object
 */
function rx_theme_assistant_settings() {
	return Rx_Theme_Assistant_Settings::get_instance();
}
