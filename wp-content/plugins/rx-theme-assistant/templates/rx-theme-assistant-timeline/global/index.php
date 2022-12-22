<?php
/**
 * Timeline list template
 */

$settings = $this->get_settings_for_display();

$classes_list[] = 'rx-theme-assistant-timeline';
$classes_list[] = 'rx-theme-assistant-timeline--align-' . $settings['horizontal_alignment'];
$classes_list[] = 'rx-theme-assistant-timeline--align-' . $settings['vertical_alignment'];
$classes = implode( ' ', $classes_list );

?>
<div class="<?php echo $classes ?>">
	<div class="rx-theme-assistant-timeline__line"><div class="rx-theme-assistant-timeline__line-progress"></div></div>
	<?php $this->__get_global_looped_template( 'timeline', 'cards_list' ); ?>
</div>
