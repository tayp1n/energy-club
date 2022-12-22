<?php

use WPGDPRC\Utils\Elements;
use WPGDPRC\Utils\Template;
use WPGDPRC\WordPress\Config;
use WPGDPRC\WordPress\Plugin;

$text = sprintf(_x('Powered by %1s', 'admin', 'wp-gdpr-compliance'), '<span class="screen-reader-text">' . _x('Cookie Information, Consent Management Platform', 'admin', 'wp-gdpr-compliance') . '</span>' . Template::getSvg('logo-ci.svg', true));

?>
	</main>

	<footer class="wpgdprc-footer">

        <!-- super secret easter egg to open the modal-->
        <button tabindex="-1" data-signup-open="wpgdprc-sign-up-modal" class="wpgdprc-sign-up-modal__open">
            <?php Template::renderSvg( 'logo-cow.svg' ); ?>
        </button>

		<p class="wpgdprc-footer__developer">
			<?php Elements::link(Config::cookieInformationUrl(), $text, [ 'target' => '_blank' ]); ?>
		</p>
	</footer>

    <?php Template::render('Admin/modal'); ?>

</div> <!-- .wpgdprc -->
