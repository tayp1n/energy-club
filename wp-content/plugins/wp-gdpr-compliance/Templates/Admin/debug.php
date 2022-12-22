<?php

use WPGDPRC\WordPress\Config;
use WPGDPRC\Utils\Elements;

?>

<div style="border-top:1px dashed #888;color:#888;margin-top:2rem;width:95%;">
	<p>Info below is for styling & debugging purposes while developing this plugin.</p>
	<div>
		<p class="h4">Button styles</p>
		<button class="wpgdprc-button">Activate</button>
		<button class="wpgdprc-button wpgdprc-button--small">Activate</button>
		<button class="wpgdprc-button wpgdprc-button--white wpgdprc-button--small">Activate</button>
		<button class="wpgdprc-button wpgdprc-button--white-primary wpgdprc-button--small">Activate</button>
		<button class="wpgdprc-button wpgdprc-button--white-alert wpgdprc-button--small">Activate</button>
		<button class="wpgdprc-button wpgdprc-button--transparent wpgdprc-button--small">Activate</button>
		<button disabled class="wpgdprc-button wpgdprc-button--transparent wpgdprc-button--small">Activate</button>
		<button disabled class="wpgdprc-button wpgdprc-button--small">Activate</button>
	</div>

	<div>
		<p class="h4">Notice styles</p>
		<div class="wpgdprc">
			<?php
			$args = [
				'title'  => 'Title',
				'text'   => 'Text',
				'button' => 'Close',
			];
			Elements::notice($args['title'], $args['text'], $args['button']);
			Elements::notice($args['title'], $args['text'], $args['button'], 'warning');
			Elements::notice($args['title'], $args['text'], $args['button'], 'error');
			?>
		</div>
	</div>

	<div>
		<pre class="debug">
			<strong>$_GET:</strong> <?php echo print_r($_GET, true); ?>
			<strong>$_POST:</strong> <?php echo print_r($_POST, true); ?>
			<strong>$_FILES:</strong> <?php echo print_r($_FILES, true); ?>
		</pre>
	</div>
</div>

