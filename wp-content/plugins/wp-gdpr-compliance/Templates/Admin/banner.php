<?php

/**
 * @var string $status
 * @var string $text
 * @var string $class
 */
$class = !empty($class) ? $class : '';
?>

<span class="wpgdprc-label wpgdprc-label--<?php echo $status; ?> <?php echo $class; ?>"><?php echo $text; ?></span>
