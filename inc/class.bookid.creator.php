<?php

/**
 * Registers post types, custom fields to use as storage
 */
class BookID_Creator {

	public function __construct() {
	}

  /**
	 * Register the filters and actions with Wordpress
	 */
	public function run() {
		add_action( 'init', array($this, 'create_bookable_post_type') );
    $this->register_bookable_custom_fields();
	}

	/**
	 * Create the post type
	 */
	public function create_bookable_post_type() {
  	$args = array(
			'description' => 'Bookable Post Type',
			'show_ui' => true,
			'menu_position' => 4,
			'exclude_from_search' => false,
			'labels' => array(
				'name'=> 'Bookable events',
				'singular_name' => 'Bookable event',
				'add_new' => 'Add new bookable event',
				'add_new_item' => 'Add new bookable event',
				'edit' => 'Edit bookable event',
				'edit_item' => 'Edit bookable event',
				'new-item' => 'New bookable event',
				'view' => 'View bookable event',
				'view_item' => 'View bookable event',
				'search_items' => 'Search bookable events',
				'not_found' => 'No bookable events found',
				'not_found_in_trash' => 'No bookable events found in the trash',
				'parent' => 'Parent bookable event'
			),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-calendar',
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => true,
			'supports' => array( 'title' )
		);
		register_post_type( 'bookable' , $args );
  }

	/**
 	 * Register the custom fields
 	 */
  private function register_bookable_custom_fields() {
    if( function_exists('acf_add_local_field_group') ):

      acf_add_local_field_group(array(
      	'key' => 'group_5f65bb2b6c5d9',
      	'title' => 'Bookable event',
      	'fields' => array(
      		array(
      			'key' => 'field_5f65bcf819ec3',
      			'label' => 'Date',
      			'name' => 'date',
      			'type' => 'date_picker',
      			'instructions' => '',
      			'required' => 1,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'display_format' => 'd/m/Y',
      			'return_format' => 'd/m/Y',
      			'first_day' => 1,
      		),
      		array(
      			'key' => 'field_5f65bb3419ebc',
      			'label' => 'Timeslots',
      			'name' => 'timeslots',
      			'type' => 'repeater',
      			'instructions' => '',
      			'required' => 1,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'collapsed' => 'field_5f65bb6819ebd',
      			'min' => 0,
      			'max' => 0,
      			'layout' => 'table',
      			'button_label' => 'Add timeslot',
      			'sub_fields' => array(
      				array(
      					'key' => 'field_5f65bb6819ebd',
      					'label' => 'Begin time',
      					'name' => 'begin_time',
      					'type' => 'time_picker',
      					'instructions' => '',
      					'required' => 0,
      					'conditional_logic' => 0,
      					'wrapper' => array(
      						'width' => '',
      						'class' => '',
      						'id' => '',
      					),
      					'display_format' => 'H:i',
      					'return_format' => 'H:i',
      				),
      				array(
      					'key' => 'field_5f65bb8e19ebe',
      					'label' => 'End time',
      					'name' => 'end_time',
      					'type' => 'time_picker',
      					'instructions' => '',
      					'required' => 0,
      					'conditional_logic' => 0,
      					'wrapper' => array(
      						'width' => '',
      						'class' => '',
      						'id' => '',
      					),
      					'display_format' => 'H:i',
      					'return_format' => 'H:i',
      				),
      				array(
      					'key' => 'field_5f65bca219ec2',
      					'label' => 'Capacity',
      					'name' => 'capacity',
      					'type' => 'number',
      					'instructions' => '',
      					'required' => 0,
      					'conditional_logic' => 0,
      					'wrapper' => array(
      						'width' => '',
      						'class' => '',
      						'id' => '',
      					),
      					'default_value' => '',
      					'placeholder' => '',
      					'prepend' => '',
      					'append' => '',
      					'min' => '',
      					'max' => '',
      					'step' => 1,
      				),
      			),
      		),
      		array(
      			'key' => 'field_5f65bbb319ebf',
      			'label' => 'Bookings',
      			'name' => 'bookings',
      			'type' => 'repeater',
      			'instructions' => 'Can be left empty',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'collapsed' => '',
      			'min' => 0,
      			'max' => 0,
      			'layout' => 'table',
      			'button_label' => '',
      			'sub_fields' => array(
      				array(
      					'key' => 'field_5f65bc0819ec0',
      					'label' => 'Member ID',
      					'name' => 'member',
      					'type' => 'user',
      					'instructions' => '',
      					'required' => 0,
      					'conditional_logic' => 0,
      					'wrapper' => array(
      						'width' => '',
      						'class' => '',
      						'id' => '',
      					),
      					'role' => '',
      					'allow_null' => 0,
      					'multiple' => 0,
      					'return_format' => 'id',
      				),
							array(
								'key' => 'field_5f6ddc1814ac7',
								'label' => 'Member name',
								'name' => 'member_name',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
      				array(
      					'key' => 'field_5f65bc2c19ec1',
      					'label' => 'Timeslot',
      					'name' => 'timeslot',
      					'type' => 'time_picker',
      					'instructions' => '',
      					'required' => 0,
      					'conditional_logic' => 0,
      					'wrapper' => array(
      						'width' => '',
      						'class' => '',
      						'id' => '',
      					),
      					'display_format' => 'H:i',
      					'return_format' => 'H:i',
      				),
      			),
      		),
      	),
      	'location' => array(
      		array(
      			array(
      				'param' => 'post_type',
      				'operator' => '==',
      				'value' => 'bookable',
      			),
      		),
      	),
      	'menu_order' => 0,
      	'position' => 'normal',
      	'style' => 'default',
      	'label_placement' => 'top',
      	'instruction_placement' => 'label',
      	'hide_on_screen' => '',
      	'active' => true,
      	'description' => '',
      ));

    endif;
  }

}
