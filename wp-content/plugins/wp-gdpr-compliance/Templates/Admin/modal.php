<?php

use WPGDPRC\Utils\Template;
use WPGDPRC\WordPress\Config;

?>

<div class="wpgdprc wpgdprc-sign-up-modal modal" id="wpgdprc-sign-up-modal" aria-hidden="true">
    <div class="wpgdprc-sign-up-modal__overlay" tabindex="-1" data-signup-close>
        <div class="wpgdprc-sign-up-modal__inner" role="dialog" aria-modal="true">
            <div class="wpgdprc-sign-up-modal__header">
                <p class="wpgdprc-sign-up-modal__title choose-type-title">
                    <?php echo _x('Choose your consent solution', 'admin', 'wp-gdpr-compliance'); ?>
                </p>
                <p class="wpgdprc-sign-up-modal__title sign-up-title" style="display: none">
                    <?php echo _x('Start your 30-day free trial', 'admin', 'wp-gdpr-compliance'); ?>
                </p>
                <button class="wpgdprc-sign-up-modal__close" aria-label="<?php
                _e('Close popup', 'wp-gdpr-compliance'); ?>" data-signup-close>
                    <?php
                    Template::renderSvg('icon-fal-times.svg'); ?>
                </button>
                <button class="wpgdprc-sign-up-modal__back" aria-label="<?php
                _e('Back', 'wp-gdpr-compliance'); ?>">
                    <?php
                    Template::renderIcon('arrow-left','fontawesome-pro-regular'); ?>
                </button>
            </div>

            <div class="wpgdprc-sign-up-modal__step wpgdprc-sign-up-modal__choose-type">
                <div class="wpgdprc-sign-up-modal__columns">
                    <div class="wpgdprc-sign-up-modal__column">
                        <?php Template::renderIcon('user-alt', 'fontawesome-pro-regular'); ?>
                        <p class="h3">
                            <?= _x('Non-business mode (personal websites)', 'admin', 'wp-gdpr-compliance') ?>
                        </p>
                        <p>
                            <?= _x('Recommended to all non-business or commercial websites.', 'admin', 'wp-gdpr-compliance') ?>
                        </p>
                        <div class="wpgdprc-button__wrap">
                            <button data-signup-private class="wpgdprc-button">
                                <?= _x(
                                    'Continue with the non-business mode',
                                    'admin',
                                    'wp-gdpr-compliance'
                                ) ?>
                            </button>
                        </div>
                    </div>
                    <div class="wpgdprc-sign-up-modal__column">
                        <?php Template::renderIcon('store-alt', 'fontawesome-pro-regular'); ?>
                        <p class="h3">
                            <?= _x('Global compliance (business websites)', 'admin', 'wp-gdpr-compliance') ?>
                        </p>
                        <p>
                            <?= _x('Recommended for companies that want to remove all risk and stay fully compliant with all global privacy regulations (GDPR, ePrivacy, and CCPA).', 'admin', 'wp-gdpr-compliance') ?>
                        </p>
                        <div class="wpgdprc-button__wrap">
                            <button data-signup-business class="wpgdprc-button">
                                <?= _x(
                                    'Try 30 days for free',
                                    'admin',
                                    'wp-gdpr-compliance'
                                ) ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wpgdprc-sign-up-modal__step wpgdprc-sign-up-modal__sign-up" style="display: none">
                <iframe id="signupCookieInformation"
                        title="<?= _x('Signup for Cookie Information', 'admin', 'wp-gdpr-compliance') ?>"
                        style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"
                        src="<?= Config::addUTMParams('https://cookieinformation.com/only-form/') ?>" loading="lazy"
                ></iframe>
            </div>
        </div>
    </div>
</div>
