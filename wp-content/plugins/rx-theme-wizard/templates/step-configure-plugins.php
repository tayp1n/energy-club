<?php
/**
 * Template for configure plugins step.
 */
?>
<h2><?php esc_html_e( 'Configure plugins', 'rx-theme-wizard' ); ?></h2>

<div class="tm-config-list">
<?php

	$required_plugins    = array();
	$recommended_plugins = array();
	$rest_plugins        = array();

	foreach ( rx_theme_wizard_data()->get_all_plugins_list() as $slug => $plugin_data ) {

		if ( ( 'base' === $plugin_data['access'] ) ) {
			$required_plugins[ $slug ] = $plugin_data;
			continue;
		}

		if ( rx_theme_wizard_data()->is_current_skin_plugin( $slug ) ) {
			$recommended_plugins[ $slug ] = $plugin_data;
			continue;
		}

		$rest_plugins[ $slug ] = $plugin_data;
	}

	if ( ! empty( $required_plugins ) ) {
		echo '<div class="plugins-set">';
		echo '<h4>' . esc_html__( 'Required Plugins', 'rx-theme-wizard' ) . '</h4>';
		echo '<div class="plugins-set__desc">' . esc_html__( 'The minimum set of service plugins for your theme installation is set by default.', 'rx-theme-wizard' ) . '</div>';


		foreach ( $required_plugins as $slug => $plugin_data ) {
			if( 'jet-data-importer' === $slug ){
				echo '<input type="checkbox" name="jet-data-importer" checked="" style="display:none">';
				continue;
			}

			rx_theme_wizard()->get_template( 'configure-plugins/item.php', array_merge(
				array( 'slug' => $slug ),
				$plugin_data
			) );
		}
		echo '</div>';
	}

	if ( ! empty( $recommended_plugins ) ) {
		echo '<div class="plugins-set">';
		echo '<h4>' . esc_html__( 'Recommended Plugins', 'rx-theme-wizard' ) . '</h4>';
		echo '<div class="plugins-set__desc">' . esc_html__( 'The recommended set of basic plugins to display the template’s pages. The best option for your site\'s future configuration. If you will not install one or more plugins from this list, the specific sections of the template, for which these plugins are responsible, will not be displayed.', 'rx-theme-wizard' ) . '</div>';

		foreach ( $recommended_plugins as $slug => $plugin_data ) {
			rx_theme_wizard()->get_template( 'configure-plugins/item.php', array_merge(
				array( 'slug' => $slug ),
				$plugin_data
			) );
		}
		echo '</div>';
	}

	if ( ! empty( $rest_plugins ) ) {
		echo '<div class="plugins-set">';
		echo '<h4>' . esc_html__( 'Extra Plugins', 'rx-theme-wizard' ) . '</h4>';
		echo '<div class="plugins-set__desc">' . esc_html__( 'The full list of plugins available for a template installation is recommended if you want to get additional functionality to your theme.', 'rx-theme-wizard' ) . '</div>';

		foreach ( $rest_plugins as $slug => $plugin_data ) {
			rx_theme_wizard()->get_template( 'configure-plugins/item.php', array_merge(
				array( 'slug' => $slug ),
				$plugin_data
			) );
		}
		echo '</div>';
	}
?>
</div>

<div class="plugins-wizard-actions">
	<a href="<?php echo rx_theme_wizard()->get_page_link( array( 'step' => 3 ) ); ?>" data-loader="true" class="btn btn-primary store-plugins">
		<span class="text"><?php esc_html_e( 'Install Plugins', 'rx-theme-wizard' ); ?></span>
		<span class="rx-theme-wizard-loader"><span class="rx-theme-wizard-loader__spinner"></span></span>
	</a>
	<div class="plugins-wizard-skip">
		<div class="plugins-wizard-skip__msg"><?php
			_e( 'If you already have these plugins, feel free to skip this step', 'rx-theme-wizard' );
		?></div>
		<a href="<?php echo rx_theme_wizard()->get_page_link( array( 'step' => 4 ) ); ?>" data-loader="true" class="btn"><?php
			esc_html_e( 'Skip to Demo Content', 'rx-theme-wizard' );
		?></a>
	</div>
</div>
