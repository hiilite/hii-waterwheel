<?php
/*
Plugin Name: HiiWaterwheel
Plugin URI: https://hiilite.com/wordpress-plugins/hiiwaterwheel/
Description: This plugin allows you create a basic waterwheel image carousel
Version: 0.0.5
Author: Hiilite
Author URI: https://hiilite.com
Text Domain: hiiwaterwheel
Domain Path: /languages/

------------------------------------------------------------------------
Copyright 2009-2018 Hiilite, Inc.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}




/**
 * HiiWaterwheel class.
 * Handles core plugin hooks and action setup.
 *
 * @package hiiwaterwheel
 * @since 1.0.0
 */
class HiiWaterwheel {
	
	/**
	 * The single instance of the class.
	 *
	 * @var self
	 * @since  1.0.0
	 */
	private static $_instance = null;

	/**
	 * @var HiiWaterwheel_REST_API
	 */
	private $rest_api = null;

	/**
	 * Main HiiWaterwheel Instance.
	 *
	 * Ensures only one instance of HiiWaterwheel is loaded or can be loaded.
	 *
	 * @since  1.0.0
	 * @static
	 * @see HIIWATERWHEEL()
	 * @return self Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * Constructor - get the plugin hooked in and ready
	 */
	public function __construct() {
		// Define constants
		define( 'HIIWATERWHEEL_VERSION', '1.0.0' );
		define( 'HIIWATERWHEEL_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
		define( 'HIIWATERWHEEL_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		
		include( 'lib/cmb2/functions.php' );
		
		include( 'lib/cmb-field-select_tagger/cmb-field-select_tagger.php' );
		include( 'lib/cmb2-field-post-search-ajax/cmb-field-post-search-ajax.php' );
		include( 'lib/cmb2-attached-posts-field/cmb2-attached-posts-field.php' );
		include( 'lib/cmb2-field-type-tags/cmb2-field-type-tags.php' );
		include( 'lib/cmb2-taxonomy/init.php' );
		
		// Includes
		include( 'includes/class-hiiwaterwheel-install.php');
		include( 'includes/class-hiiwaterwheel-post-types.php');
		include( 'includes/class-hiiwaterwheel-ajax.php');
		include( 'includes/class-hiiwaterwheel-shortcodes.php');
		//include( 'includes/class-hiiwaterwheel-api.php');
		//include( 'includes/class-hiiwaterwheel-cache-helper.php'); 
		
		
		if( is_admin() ) {
			include( 'includes/admin/class-hiiwaterwheel-admin.php');
		}
		
		// Init classes
		$this->post_types = new HiiWaterwheel_Post_Types();
		
		// Activation - works with symlinks
		register_activation_hook( basename( dirname( __FILE__ ) ) . '/'. basename( __FILE__ ), array( $this, 'activate' ) );
		
		// Switch theme
		add_action( 'after_switch_theme', array( 'HiiWaterwheel_Ajax', 'add_endpoint'), 10);
		add_action( 'after_switch_theme', array( $this->post_types, 'register_post_types'), 11);
		add_action( 'after_switch_theme', 'flush_rewrite_rules', 15);
		
		// Actions
		add_action( 'after_setup_theme', array( $this, 'load_plugin_textdomain') );
		add_action( 'after_setup_theme', array( $this, 'include_template_functions' ), 11);
		add_action( 'widget_init', array( $this, 'widget_init'));
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		add_action( 'admin_init', array( $this, 'updater') );
		
	}
	
	/**
	 * Called on plugin activation
	 */
	public function activate() {
		HiiWaterwheel_Ajax::add_endpoint();
		$this->post_types->register_post_types();
		HiiWaterwheel_Install::install();
		flush_rewrite_rules();
	}
	
	/**
	 * Handle Updates
	 */
	public function updater() {
		if ( version_compare( HIIWATERWHEEL_VERSION, get_option( 'hiiwaterwheel_version' ), '>' ) ) {
			HiiWaterwheel_Install::install();
			flush_rewrite_rules();
		}
	}
	
	/**
	 * Localisation
	 */
	public function load_plugin_textdomain() {
		load_textdomain( 'hiiwaterwheel', WP_LANG_DIR . 'hiiwaterwheel/hiiwaterwheel-' . apply_filters( 'plugin_locale', get_locale( ), 'hiiwaterwheel' ) . '.mo' );
		load_plugin_textdomain( 'hiiwaterwheel', false, dirname( plugin_basename( __FILE__ )) . '/languages/' );
	}
	
	/**
	 * Load functions
	 */
	public function include_template_functions() {
		include( 'hiiwaterwheel-functions.php' );
		include( 'hiiwaterwheel-template.php' );
	}

	/**
	 * Widgets init
	 */
	public function widgets_init() {
		include_once( 'includes/class-hiiwaterwheel-widgets.php' );
	}
	
	/**
	 * Register and enqueue scripts, css and js
	 */
	public function frontend_scripts() {
		$ajax_url			= HiiWaterwheel_Ajax::get_endpoint();
		$ajax_filter_deps	= array( 'jquery', 'jquery-deserialize' );
		$ajax_data			= array(
			'ajax_url'					=> $ajax_url,
			'is_rtl'					=> is_rtl(  ) ? 1 : 0,
			'i18n_load_prev_episodes'	=> __( 'Load Previous Episodes' , 'hiiwaterwheel'),
		);
		
		// WPML workaround
		if ( defined( 'ICL_SITEPRESS_VERSION' )) {
			$ajax_data['lang']	= apply_filters( 'wpml_current_language', NULL );
		}
		
		wp_register_script( 'jquery-deserialize', HIIWATERWHEEL_URL . '/assets/js/jquery-deserialize/jquery.deserialize.js', array('jquery'), '1.2.1', true );
		
		wp_enqueue_script( 'hiiwaterwheel-scripts', HIIWATERWHEEL_URL . '/assets/js/hiiwaterwheel-scripts.js', array('jquery'), '', true );

		wp_enqueue_style( 'hiiwaterwheel-frontend', HIIWATERWHEEL_URL . '/assets/css/frontend.css' );
	}
	
	
}

/**
 * Main instance of WP Job Manager.
 *
 * Returns the main instance of WP Job Manager to prevent the need to use globals.
 *
 * @since  1.26
 * @return WP_Job_Manager
 */
function HIIWATERWHEEL() {
	return HiiWaterwheel::instance();
}

$GLOBALS['hiiwaterwheel'] = new HiiWaterwheel();

?>