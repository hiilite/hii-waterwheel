<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * HiiWaterwheel_Ajax class.
 */
class HiiWaterwheel_Ajax {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( __CLASS__, 'add_endpoint') );
		add_action( 'template_redirect', array( __CLASS__, 'do_hiiwaterwheel_ajax'), 0 );

		// Ajax endpoints


	}
	
	/**
	 * Add our endpoint for frontend ajax requests
	 */
	public static function add_endpoint() {
		add_rewrite_tag( '%hiiwaterwheel-ajax%', '([^/]*)' );
		add_rewrite_rule( 'hiiwaterwheel-ajax/([^/]*)/?', 'index.php?hiiwaterwheel-ajax=$matches[1]', 'top' );
		add_rewrite_rule( 'index.php/hiiwaterwheel-ajax/([^/]*)/?', 'index.php?hiiwaterwheel-ajax=$matches[1]', 'top' );
	}
	
	/**
	 * Get HiiWaterwheel Ajax Endpoint
	 * @param  string $request Optional
	 * @param  string $ssl     Optional
	 * @return string
	 */
	public static function get_endpoint( $request = '%%endpoint%%', $ssl = null ) {
		if ( strstr( get_option( 'permalink_structure' ), '/index.php/' ) ) {
			$endpoint = trailingslashit( home_url( '/index.php/hiiwaterwheel-ajax/' . $request . '/', 'relative' ) );
		} elseif ( get_option( 'permalink_structure' ) ) {
			$endpoint = trailingslashit( home_url( '/hiiwaterwheel-ajax/' . $request . '/', 'relative' ) );
		} else {
			$endpoint = add_query_arg( 'hiiwaterwheel-ajax', $request, trailingslashit( home_url( '', 'relative' ) ) );
		}
		return esc_url_raw( $endpoint );
	}
	
	/**
	 * Check for WC Ajax request and fire action
	 */
	public static function do_hiiwaterwheel_ajax() {
		global $wp_query;

		if ( ! empty( $_GET['hiiwaterwheel-ajax'] ) ) {
			 $wp_query->set( 'hiiwaterwheel-ajax', sanitize_text_field( $_GET['hiiwaterwheel-ajax'] ) );
		}

   		if ( $action = $wp_query->get( 'hiiwaterwheel-ajax' ) ) {
   			if ( ! defined( 'DOING_AJAX' ) ) {
				define( 'DOING_AJAX', true );
			}

			// Not home - this is an ajax endpoint
			$wp_query->is_home = false;

   			do_action( 'hiiwaterwheel_ajax_' . sanitize_text_field( $action ) );
   			die();
   		}
	}
	
	

}

new HiiWaterwheel_Ajax();