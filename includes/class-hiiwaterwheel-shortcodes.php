<?php
/**
 * 
 * Generates Hii Waterwheel from shortcode
 * 
 **/
function hii_ww_func( $atts ) {
    $a = shortcode_atts( array(
        'id' => '',
    ), $atts );

	include(HIIWATERWHEEL_DIR . '/templates/hiiwaterwheel-basic.php');

    return $html;
}
add_shortcode( 'hiiww', 'hii_ww_func' );
	
?>