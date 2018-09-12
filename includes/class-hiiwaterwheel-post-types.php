<?php
/**
 * HiiWaterwheel_Post_Types class.
 * Handles displays and hooks for the HiiWaterwheel custom post types.
 *
 * @package hiiwaterwheel
 * @since 1.0.0
 */
class HiiWaterwheel_Post_Types {
	
	/**
	 * The single instance of the class.
	 *
	 * @var self
	 * @since  1.0.0
	 */
	private static $_instance = null;

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @since  1.0.0
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
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_types'), 0 );
		add_action( 'init', array( $this, 'register_taxonomies'), 0 );
		
		// RP4WP
		add_filter( 'rp4wp_get_template', array( $this, 'rp4wp_template' ), 10, 3 );

	}
	
	
	/**
	 * register_taxonomies function.
	 * 
	 * @access public
	 * @return void
	 */
	public function register_taxonomies() {

	}
	
	
	/**
	 * register_post_types function.
	 * 
	 * @access public
	 * @return void
	 */
	public function register_post_types() {
		
		if( post_type_exists( 'waterwheel' ) ) 
			return;
		
		$admin_capability = 'manage_options';
		
				
		//$permalink_structure = HiiWaterwheel_Post_Types::get_permalink_structure();
		/**
		 * Post types
		 */
		 
		// Show
		$singular	= __( 'Waterwheel', 'hiiwaterwheel');
		$plural		= __( 'Waterwheels', 'hiiwaterwheel');
		 
		if ( current_theme_supports( 'hiiwaterwheel-templates' ) ) {
			$has_archive = _x( 'waterwheels', 'Post type archive slug - resave permalinks after changing this', 'hiiwaterwheel' );
		} else {
			$has_archive = true;
		}
		
		$rewrite     = array(
			'slug'       => _x( 'waterwheel', 'Show permalink - resave permalinks after changing this', 'hiiwaterwheel' ),
			'with_front' => false,
			'feeds'      => true,
			'pages'      => true
		);
		
		register_post_type( 'waterwheel',
			apply_filters( 'register_post_type_show', array(
				'labels'	=> array(
					'name'				=> $plural,
					'singular_name'		=> $singular,
					'menu_name'			=> __( 'Hii Waterwheels', 'hiiwaterwheel'),
					'all_items'         => sprintf( __( 'All %s', 'hiiwaterwheel' ), $plural ),
					'search_items'      => sprintf( __( 'Search %s', 'hiiwaterwheel' ), $plural ),
					'parent_item'       => sprintf( __( 'Parent %s', 'hiiwaterwheel' ), $singular ),
					'parent_item_colon' => sprintf( __( 'Parent %s:', 'hiiwaterwheel' ), $singular ),
					'edit' 				=> __( 'Edit', 'hiiwaterwheel' ),
					'edit_item'         => sprintf( __( 'Edit %s', 'hiiwaterwheel' ), $singular ),
					'update_item'       => sprintf( __( 'Update %s', 'hiiwaterwheel' ), $singular ),
					'add_new' 			=> __( 'Add New', 'hiiwaterwheel' ),
					'add_new_item'      => sprintf( __( 'Add New %s', 'hiiwaterwheel' ), $singular ),
					'new_item' 				=> sprintf( __( 'New %s', 'hiiwaterwheel' ), $singular ),
					'view' 					=> sprintf( __( 'View %s', 'hiiwaterwheel' ), $singular ),
					'view_item' 			=> sprintf( __( 'View %s', 'hiiwaterwheel' ), $singular ),
					'not_found' 			=> sprintf( __( 'No %s found', 'hiiwaterwheel' ), $plural ),
					'not_found_in_trash' 	=> sprintf( __( 'No %s found in trash', 'hiiwaterwheel' ), $plural ),
					'parent' 				=> sprintf( __( 'Parent %s', 'hiiwaterwheel' ), $singular ),
				),
				'description' => sprintf( __( 'This is where you can create and manage %s.', 'hiiwaterwheel' ), $plural ),
				'public' 				=> true,
				'show_ui' 				=> true,
				'capability_type' 		=> 'post',
				'map_meta_cap'          => true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> true,
				'hierarchical' 			=> false,
				'rewrite' 				=> $rewrite,
				'query_var' 			=> true,
				'supports' 				=> array( 'title', 'publicize' ),
				'has_archive' 			=> false,
				'show_in_nav_menus' 	=> true,
				'menu_icon'				=> 'dashicons-slides',
				'menu_position'			=> 6,
			) )
		);

	}
}