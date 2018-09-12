<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * HiiWaterwheel_Install
 */
class HiiWaterwheel_Install {
	
	
	/**
	 * install function.
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	public static function install() {
		global $wpdb;
		
		// Redirect to setup screen for new installs
		if ( ! get_option(  'hiiwaterwheel_version' ) ) {
			set_transient( '_hiiwaterwheel_activation_redirect', 1, HOUR_IN_SECONDS);
		}
		
		delete_transient( 'hiiwaterwheel_addons_html' );
		update_option( 'hiiwaterwheel_version', HIIWATERWHEEL_VERSION );
	}
}