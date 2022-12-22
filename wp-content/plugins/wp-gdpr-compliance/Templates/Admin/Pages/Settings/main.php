<?php

use WPGDPRC\Utils\Template;
use WPGDPRC\WordPress\Settings;
use WPGDPRC\WordPress\Admin\Pages\PageSettings;
use WPGDPRC\WordPress\Plugin;
use WPGDPRC\Utils\Elements;
use WPGDPRC\WordPress\Admin\Pages\PageWizard;
use WPGDPRC\Utils\Wizard;

/**
 * @var string $current
 * @var string $title
 * @var string $intro
 * @var array  $sections
 */

reset($sections);
$selected = key($sections);

if( !empty($_GET['section']) ) {
	$section = sanitize_key($_GET['section']);
    if( isset($sections[ $section ]) ) $selected = $section;
} else {
    $transient = Settings::getSectionTransient();
    if( !empty($transient) ) {
        if( isset($sections[ $transient ]) ) $selected = $transient;
    }
}

?>

<header class="wpgdprc-content__header">
	<h2 class="wpgdprc-content__title"><?php echo $title; ?></h2>
	<p class="wpgdprc-content__text"><?php echo $intro; ?></p>
</header>

<div class="wpgdprc-content__container wpgdprc-content__container--no-border">
	<section class="wpgdprc-tabs wpgdprc-tabs--alt" data-tabs>
		<div class="wpgdprc-tabs__header">
			<ul class="wpgdprc-tabs__list" role="tablist">
				<?php foreach( $sections as $key => $section ) : ?>
					<li class="wpgdprc-tabs__item" role="presentation">
						<a class="wpgdprc-tabs__anchor" data-title="<?php echo esc_attr($section['title']); ?>" href="<?php echo $section['url']; ?>" id="tab-<?php echo $key; ?>" tabindex="0"
						   role="tab" aria-controls="<?php echo $key; ?>" aria-selected="<?php echo $selected == $key ? 'true' : 'false'; ?>">
							<?php echo esc_attr($section['title']); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="wpgdprc-tabs__container">

			<form method="post" action="options.php">
				<?php settings_fields(Settings::getGroupKey($current)); ?>
				<input type="hidden" name="tab" value="<?php echo $current; ?>"/>

			<?php foreach( $sections as $key => $section ) : ?>
				<?php if( $key == PageSettings::SECTION_INTEGRATE ) : ?>
			</form>
			<form method="post" action="">
				<input type="hidden" name="tab" value="<?php echo $current; ?>"/>
				<input type="hidden" name="section" value="<?php echo $key; ?>"/>
				<?php endif; ?>
				<div class="wpgdprc-tabs__block wpgdprc-tabs__block--active" id="<?php echo $key; ?>"
					 role="tabpanel" aria-labelledby="tab-<?php echo $key; ?>" aria-hidden="<?php echo $selected == $key ? 'false' : 'true'; ?>">
					<?php Template::render($section['template'], []); ?>
				</div>
			<?php endforeach; ?>

			</form>

		</div>
	</section>

    <section class="wpgdprc-tiles">
        <div class="wpgdprc-tiles__container">
            <div class="grid-x grid-margin-y">
                <?php Template::render('Admin/tile', [
                    'title'  => _x('Skipped the tour?', 'admin', 'wp-gdpr-compliance'),
                    'text'   => _x('We recommend taking Cookie Information’s tour to find out if you’re set up correctly and to learn more about the features of this free plugin. ', 'admin', 'wp-gdpr-compliance'),
                    'footer' => Elements::getLink(
                        Wizard::getRestartLink(PageWizard::getPageUrl()),
                        _x('Take the tour', 'admin', 'wp-gdpr-compliance'),
                        [ 'class' => 'wpgdprc-button wpgdprc-button--white wpgdprc-button--small' ]
                    ),
                ]); ?>
            </div>
        </div>
    </section>
</div>
