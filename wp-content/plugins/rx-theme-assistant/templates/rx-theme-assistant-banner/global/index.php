<?php
/**
 * Loop item template
 */
?>
<figure class="rx-banner rx-effect-<?php $this->__html( 'animation_effect', '%s' ); ?>"><?php
	$target = $this->__get_html( 'banner_link_target', ' target="%s"' );

	$this->__html( 'banner_link', '<a href="%s" class="rx-banner__link"' . $target . '>' );
		echo '<span class="rx-banner__overlay"></span>';
		echo $this->__get_banner_image();
		echo '<span class="rx-banner__content">';
			echo '<span class="rx-banner__content-wrap">';
				$title_tag = $this->__get_html( 'banner_title_html_tag', '%s' );

				$this->__html( 'banner_title', '<' . $title_tag  . ' class="rx-banner__title">%s</' . $title_tag  . '>' );
				$this->__html( 'banner_text', '<span class="rx-banner__text">%s</span>' );
			echo '</span>';
		echo '</span>';
	$this->__html( 'banner_link', '</a>' );
?></figure>
