<?php
/**
 * Images list item template
 */
?>
<article class="rxta-dynamic-posts__item <?php echo esc_attr__( $item_class ); ?> ">
	<div class="rxta-dynamic-posts__inner">
		<?php
			$template_content = rx_theme_assistant_tools()->elementor()->frontend->get_builder_content_for_display( $items_template );

			if ( ! empty( $template_content ) ) {
				printf( '%s', $template_content );
			}else {
				esc_html_e( 'Elementor template not found!', 'rx-theme-assistant');
			}
		?>
	</div>
</article>
