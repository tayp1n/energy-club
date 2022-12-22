<?php
/**
 * Posts loop start template
 */
?>
<div class="rx-theme-assistant-posts__item <?php echo rx_theme_assistant_tools()->col_classes( array(
	'desk' => $this->get_attr( 'columns' ),
	'tab'  => $this->get_attr( 'columns_tablet' ),
	'mob'  => $this->get_attr( 'columns_mobile' ),
) ); ?>">
	<div class="rx-theme-assistant-posts__inner-box"<?php $this->add_box_bg(); ?>><?php

		include $this->get_template( 'item-thumb' );
		rvdx_theme_posted_in( array(
			'prefix'  => '',
			'delimiter' => '',
			'before'    => '<div class="cat-links btn-style">',
			'after'     => '</div>',
		) );

		echo '<div class="rx-theme-assistant-posts__inner-content">';

			include $this->get_template( 'item-title' );
			include $this->get_template( 'item-meta' );
			include $this->get_template( 'item-content' );
			include $this->get_template( 'item-more' );

		echo '</div>';

	?></div>
</div>
