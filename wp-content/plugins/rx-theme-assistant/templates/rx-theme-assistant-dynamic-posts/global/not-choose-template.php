<?php
/**
 * template is note choose
 */
$message = '<span>' . esc_html__( 'Template is not defined. ', 'rx-theme-assistant' ) . '</span>';

//$link =  Utils::get_create_new_post_url( 'elementor_library' );

$link = add_query_arg(
	array(
		'post_type'     => 'elementor_library',
		'action'        => 'elementor_new_post',
		'_wpnonce'      => wp_create_nonce( 'elementor_action_new_post' ),
		'template_type' => 'section',
	),
	esc_url( admin_url( '/edit.php' ) )
);

$new_link = '<span>' . esc_html__( 'Select an existing template or create a ', 'rx-theme-assistant' ) . '</span><a class="rx-theme-assistant-tabs-new-template-link elementor-clickable" target="_blank" href="' . $link . '">' . esc_html__( 'new one', 'rx-theme-assistant' ) . '</a>' ;

printf(
	'<div class="rx-theme-assistant-tabs-no-template-message">%1$s%2$s</div>',
	$message,
	rx_theme_assistant_tools()->in_elementor() ? $new_link : ''
);
