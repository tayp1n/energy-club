<?php
/**
 * Testimonials item template
 */
$settings = $this->get_settings();
$stars = $this->render_stars();

?>
<div class="rx-theme-assistant-testimonials__item">
	<div class="rx-theme-assistant-testimonials__item-inner">
		<div class="rx-theme-assistant-testimonials__content"><?php
			echo $this->__get_testimonials_image();
			echo $this->__get_icon( 'item_icon', '<div class="rx-theme-assistant-testimonials__icon"><div class="rx-theme-assistant-testimonials__icon-inner">%s</div></div>' );
			echo $this->__loop_item( array( 'item_title' ), '<h5 class="rx-theme-assistant-testimonials__title">%s</h5>' );
			echo $this->__loop_item( array( 'item_comment' ), '<p class="rx-theme-assistant-testimonials__comment"><span>%s</span></p>' );
			echo $this->__loop_item( array( 'item_name' ), '<div class="rx-theme-assistant-testimonials__name"><span>%s</span></div>' );
			echo $this->__loop_item( array( 'item_position' ), '<div class="rx-theme-assistant-testimonials__position"><span>%s</span></div>' );
			echo $this->__loop_item( array( 'item_date' ), '<div class="rx-theme-assistant-testimonials__date"><span>%s</span></div>' );
			echo $this->__loop_item( array( 'item_rating' ), '<div class="rx-theme-assistant-testimonials__rating" data-rating="%s">' . $stars . '</div>' );
		?></div>
	</div>
</div>

