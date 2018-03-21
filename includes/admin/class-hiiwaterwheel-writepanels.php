<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Handles the management of HiiWaterwheel meta fields.
 *
 * @package hiiwaterwheel
 * @since 0.0.1
 *
 *
 */
class HiiWaterwheel_Writepanels {
	
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
		add_action( 'cmb2_init', array( $this, 'add_waterwheel_meta_boxes' ) );
	}

	
	/**
	 * Handles the hooks to add custom field meta boxes.
	 */
	public function add_waterwheel_meta_boxes() {
		
		$cmb = new_cmb2_box( array(
			'id'           => 'hii_ww_slide_group',
			'title'        => __( 'Waterwheel Slides', 'hiiwaterwheel'),
			'object_types' => array( 'waterwheel' ), // post type
			'context'      => 'normal', //  'normal', 'advanced', or 'side'
			'priority'     => 'high',  //  'high', 'core', 'default' or 'low'
			'show_names'   => true, // Show field names on the left
		) );
		$group_field_id = $cmb->add_field( array(
			'id'          => 'hii_ww_slide',
			'type'        => 'group',
			'description' => __( 'Creates a new slide', 'hiiwaterwheel' ),
			'repeatable'  => true, 
			'options'     => array(
				'group_title'   => __( 'Slide {#}', 'hiiwaterwheel' ), // since version 1.1.4, {#} gets replaced by row number
				'add_button'    => __( 'Add Another Slide', 'hiiwaterwheel' ),
				'remove_button' => __( 'Remove Slide', 'hiiwaterwheel' ),
				'sortable'      => true, // beta
			),
			'attributes' => array(
				'data-validation' => 'required',
			),
		) );
		
		// Id's for group's fields only need to be unique for the group. Prefix is not needed.
		$cmb->add_group_field( $group_field_id, array(
			'name'    => 'Image',
			'desc'    => 'Upload an image.',
			'id'      => 'hii_ww_image',
			'type'    => 'file',
			// Optional:
			'options' => array(
				'url' => false, // Hide the text input for the url
			),
			'text'    => array(
				'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
			),
			// query_args are passed to wp.media's library query.
			'query_args' => array(
				'type' => array(
					'image/gif',
					'image/jpeg',
					'image/png',
				),
			),
			'preview_size' => 'medium', // Image size to use when previewing in the admin.
		) );
		
		$cmb->add_group_field( $group_field_id, array(
			'name'    => __( 'Image Display', 'hiiwaterwheel' ),
			'id'      => 'hii_ww_img_display',
			'type'    => 'radio_inline',
			'options' => array(
				'contain' => __( 'Contain', 'hiiwaterwheel' ),
				'cover'   => __( 'Cover', 'hiiwaterwheel' ),
			),
			'default' => 'contain',
		) );
		

		
		
	}

}

HiiWaterwheel_Writepanels::instance();