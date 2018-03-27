<?php
/**
 * 
 * Add shortcode column to waterwheel in dashboard
 * 
 **/
function hii_waterwheel_shortcode_column($columns) {
  $new = array();
  foreach($columns as $key => $title) {
    if ($key=='date') // Put the Thumbnail column before the Author column
      $new['shortcode'] = 'Shortcode';
    $new[$key] = $title;
  }
  return $new;
}
add_filter('manage_waterwheel_posts_columns', 'hii_waterwheel_shortcode_column');


function hii_waterwheel_shortcode($column_name, $post_id) {
    if ($column_name == 'shortcode') {
        echo '[hiiww id="'.$post_id.'"]';
    }
}
add_action('manage_waterwheel_posts_custom_column', 'hii_waterwheel_shortcode', 10, 2);


