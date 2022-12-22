<?php

use WPGDPRC\Utils\Wizard;
use WPGDPRC\WordPress\Plugin;
use WPGDPRC\Utils\Template;

?>

<div data-title="<?php _ex('Setup first consent', 'admin', 'wp-gdpr-compliance'); ?>" class="step">
	<h2 class="h2 step__title">
		<?php _ex('Setup your first consent', 'admin', 'wp-gdpr-compliance'); ?>
	</h2>
	<p><?php _ex("Most websites use services and plugins for statistical and marketing that require the user's consent to comply with GDPR. Here you can add the first of the services you use. You can always change this later.", 'admin', 'wp-gdpr-compliance'); ?></p>
	<div class="step__form-wrapper margin-top-1" data-action="<?php echo Wizard::AJAX_SAVE_CONSENT; ?>">
        <?php Template::render('Admin/Pages/Wizard/Steps/Parts/consent-form'); ?>
	</div>
</div>
