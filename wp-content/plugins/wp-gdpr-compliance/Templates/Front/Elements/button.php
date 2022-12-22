<?php

if( empty( $text ) ) return;
if( empty( $attr ) ) $attr = [];

?>

<button <?php foreach( $attr as $name => $value ) echo $name . '="' . esc_attr($value) . '" '; ?>><?php echo $text; ?></button>
