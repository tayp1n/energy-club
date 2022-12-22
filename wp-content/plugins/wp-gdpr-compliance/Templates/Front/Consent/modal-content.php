<?php

use WPGDPRC\Objects\DataProcessor;
use WPGDPRC\Utils\Template;
use WPGDPRC\WordPress\Plugin;
use WPGDPRC\WordPress\Config;

/**
 * @var string $title
 * @var string $text
 * @var array $list
 * @var array $consents
 * @var string $button
 */

?>

<div class="wpgdprc-consent-modal__body">
    <nav class="wpgdprc-consent-modal__navigation">
        <ul class="wpgdprc-consent-modal__navigation-list">
            <li class="wpgdprc-consent-modal__navigation-item">
                <button class="wpgdprc-consent-modal__navigation-button wpgdprc-consent-modal__navigation-button--active" data-target="description"><?php echo $title; ?></button>
            </li>
            <?php foreach( $list as $item ) : ?>
                <?php /** @var DataProcessor $item */ ?>
                <li>
                    <button class="wpgdprc-consent-modal__navigation-button" data-target="<?php echo $item->getId(); ?>"><?php echo !empty($item->getTitle()) ? __($item->getTitle(), 'wp-gdpr-compliance') : __('(no title)', 'wp-gdpr-compliance'); ?></button>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <div class="wpgdprc-consent-modal__information">
        <div class="wpgdprc-consent-modal__description wpgdprc-consent-modal__description--active" data-target="description">
            <p class="wpgdprc-consent-modal__title wpgdprc-consent-modal__title--description"><?php echo $title; ?></p>
            <div class="wpgdprc-content-modal__content">
                <?php echo $text; ?>
            </div>
        </div>

        <?php foreach( $list as $item ) : ?>
            <?php /** @var DataProcessor $item */ ?>
            <div class="wpgdprc-consent-modal__description" data-target="<?php echo $item->getId(); ?>">
                <p class="wpgdprc-consent-modal__title wpgdprc-consent-modal__title--description"><?php echo __($item->getTitle(), 'wp-gdpr-compliance'); ?></p>
                <div class="wpgdprc-content-modal__content">
                    <?php echo apply_filters(Plugin::PREFIX.'_the_content', __($item->getDescription(), 'wp-gdpr-compliance')); ?>
                </div>
                <?php if (!$item->getRequired()) : ?>
                    <div class="wpgdprc-content-modal__options">
                        <?php Template::render('Front/Consent/modal-content-option', [
                            'item'     => $item,
                            'consents' => $consents,
                            'border' => true
                        ]); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="wpgdprc-consent-modal__footer">
    <div class="wpgdprc-consent-modal__footer__information">
        <a href="<?php echo Config::cookieInformationUrl() ?>" target="_blank"><?php echo __('Powered by Cookie Information', 'wp-gdpr-compliance') ?></a>
    </div>
    <button class="wpgdprc-button wpgdprc-button--secondary"><?php echo $button; ?></button>
</div>
