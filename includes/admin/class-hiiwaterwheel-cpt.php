<?php
	
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Handles actions and filters specific to the custom post type for Waterwheel.
 *
 * @package hiiwaterwheel
 * @since 0.0.1
 */
class HiiWaterwheel_CPT {
	
	/**
	 * The single instance of the class.
	 *
	 * @var self
	 * @since  0.0.1
	 */
	private static $_instance = null;
	
	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @since  0.0.1
	 * @static
	 * @return self Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		
	}
	
	
}
