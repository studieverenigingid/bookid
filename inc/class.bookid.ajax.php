<?php

/**
 * Registers methods for AJAX endpoints
 */
class BookID_Ajax {

	public function __construct() {
	}

  /**
	 * Register the filters and actions with Wordpress
	 */
	public function run() {
		add_action( 'wp_ajax_bookid_cancel', array($this, 'cancel_booking') );
    add_action( 'wp_ajax_bookid_add', array($this, 'add_booking') );
	}

	/**
	 * Cancel the user’s booking
	 */
	public function cancel_booking() {
    $post_ID = $_GET['post'];
    if ( have_rows('bookings', $post_ID) ): while ( have_rows('bookings', $post_ID) ): the_row();
      if (get_sub_field('member') == get_current_user_id()) {
        $deleting = delete_row('bookings', get_row_index(), $post_ID);
      }
    endwhile; endif;
    wp_send_json(array( 'success' => $deleting ));
  }

	/**
	 * Add a booking for the requested timeslot for the user
	 */
  public function add_booking() {
    $post_ID = $_GET['post'];
    $user_ID = get_current_user_id();
		$user_obj = get_userdata($user_ID);
    $booking = array(
      'member' => $user_ID,
			'member_name' => $user_obj->display_name,
      'timeslot' => $_GET['timeslot'],
			'guests' => esc_html($_GET['guests']),
    );
    $adding = add_row('bookings', $booking, $post_ID);
    wp_send_json(array( 'success' => $adding ));
  }

}
