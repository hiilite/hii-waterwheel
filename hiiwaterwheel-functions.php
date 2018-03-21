<?php
	
/**
 * Get a list of terms
 *
 * Generic function to return an array of taxonomy terms formatted for CMB2.
 * Simply pass in your get_terms arguments and get back a beautifully formatted
 * CMB2 options array.
 *
 * @param string|array $taxonomies Taxonomy name or list of Taxonomy names
 * @param  array|string $query_args Optional. Array or string of arguments to get terms
 * @return array CMB2 options array
 */
function iweb_get_cmb_options_array_tax( $taxonomies, $query_args = '' ) {
	$defaults = array(
		'hide_empty' => false
	);
	$args = wp_parse_args( $query_args, $defaults );
	$terms = get_terms( $taxonomies, $args );
	$terms_array = array();
	if ( ! empty( $terms ) ) {
		foreach ( $terms as $term ) {
			$terms_array[$term->term_id] = $term->name;
		}
	}
	return $terms_array;
}


/**
 * 
 * Add shortcode column to waterwheel in dashboard
 * 
 **/
function waterwheel_shortcode_column($columns) {
  $new = array();
  foreach($columns as $key => $title) {
    if ($key=='date') // Put the Thumbnail column before the Author column
      $new['shortcode'] = 'Shortcode';
    $new[$key] = $title;
  }
  return $new;
}
add_filter('manage_waterwheel_posts_columns', 'waterwheel_shortcode_column');


function waterwheel_shortcode($column_name, $post_id) {
    if ($column_name == 'shortcode') {
        echo '[hiiww id="'.$post_id.'"]';
    }
}
add_action('manage_waterwheel_posts_custom_column', 'waterwheel_shortcode', 10, 2);


