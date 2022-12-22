<?php
/**
 * Portfolio template
 */

$settings   = $this->get_settings_for_display();
$layout     = $settings['layout_type'];
$item_class = rx_theme_assistant_tools()->col_classes( array(
	'desk' => $settings['columns'],
	'tab'  => $settings['columns_tablet'],
	'mob'  => $settings['columns_mobile'],
) );
$options  = '';

switch ($layout) {
	case 'carousel':
		$items_wrapper_class = 'rx-theme-assistant-carousel';
		$options             = sprintf( 'data-slider_options="%s"', htmlspecialchars( json_encode( $this->get_carousel_options() ) ) );
	break;

	case 'grid':
		$items_wrapper_class = 'rxta-dynamic-posts__items col-row';
	break;

	case 'list':
		$items_wrapper_class = 'rxta-dynamic-posts__items';
	break;

	default:
		$items_wrapper_class = 'rxta-dynamic-posts__items';
	break;
}

$this->add_render_attribute( 'main-container', 'class', array(
	'rxta-dynamic-posts',
	'rxta-dynamic-posts__layout-' . $layout,
) );
?>

<div <?php echo $this->get_render_attribute_string( 'main-container' ); ?> >
	<?php

		$loop_start = $this->__get_global_template( 'dynamic-posts-loop-start' );
		$loop_item  = $this->__get_global_template( 'dynamic-posts-loop-item' );
		$loop_end   = $this->__get_global_template( 'dynamic-posts-loop-end' );

		global $post;

		ob_start();

		include $loop_start;

		while ( $query->have_posts() ) {

			$query->the_post();
			$post = $query->post;

			setup_postdata( $post );

			include $loop_item;
		}

		include $loop_end;

		wp_reset_postdata();

		echo ob_get_clean();
	?>
</div>
