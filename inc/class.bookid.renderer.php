<?php

/**
 * Allows rendering user facing elements
 */
class BookID_Renderer {

	protected $styling = "
		.login__label {
			color: #444;
		}
		.login__input {
			border-color: #444;
			color: #444;
		}
		.login__input::placeholder {
			color: #777;
		}
		@media (min-width: 500px) {
			.timeslots {
				columns: 2;
			}
		}
		.timeslots__slot {
			break-inside: avoid;
			overflow: hidden;
			text-align: center;
		}
	";

	public function __construct() {
	}

  /**
	 * Register the filters and actions with Wordpress
	 */
	public function run() {
		add_action( 'init', array($this, 'register_shortcodes') );
	}

	/**
	 * Register the shortcodes
	 */
  public function register_shortcodes() {
    add_shortcode( 'bookid', array($this, 'timeslot_renderer') );
  }

  /**
	 * Create and a button
	 * @param js_id [string] the id which JS uses to bind an event handler
	 * @param text [string] text shown to user on button
	 * @param data [array] array of properties to pass to button/with xhr request
	 * @return string the button HTML
	 */
  private function build_button($js_id, $text, $data) {
    $button_args = "";
    foreach ($data as $key => $value) {
      $button_args .= "data-$key='$value' ";
    }
    $button = "<button class='button js-$js_id' $button_args>$text</button>";
    return $button;
  }

	/**
	 * Register the shortcodes
	 * @return string the timeslot HTML
	 */
	public function timeslot_renderer() {

		// If user is not logged in, show a login button
    if (!is_user_logged_in()) {
      return '<a href="' . wp_login_url( get_permalink() ) . '" class="button">Login to book</a>';
    }

		// Load JS
    $js_path = plugins_url('js/bookid_handling.js', dirname(__FILE__));
    $content = "<script src='$js_path'></script>";
		$content .= "<script>const bookidAjaxurl = '" . admin_url( 'admin-ajax.php' ) . "'</script>";


    $registered = false;

		// Load nearest bookable event
    $today = date('Ymd');
    $bookables_loop = new WP_Query( array(
      'post_type' => 'bookable',
      'posts_per_page' => 1,
      'meta_query' => array(
      	array(
      	  'key'     => 'date',
      	  'compare' => '>=',
      	  'value'   => $today,
      	  'type'    => 'DATE'
      	),
      ),
      'orderby' => 'meta_value',
      'meta_key' => 'date',
      'order' => 'ASC',
    ) );
    if ($bookables_loop->have_posts()) : while($bookables_loop->have_posts()) :
      $bookables_loop->the_post();

			// Render bookable title
      $title = get_the_title();
      $content .= "<h3>$title</h3>";

			// Make list of timeslots
      $timeslots = array();
      if ( have_rows('timeslots') ): while ( have_rows('timeslots') ): the_row();
        $begin_time = get_sub_field('begin_time');
        $timeslots[$begin_time]['begin'] = $begin_time;
        $timeslots[$begin_time]['end'] = get_sub_field('end_time');
        $timeslots[$begin_time]['available'] = get_sub_field('capacity');
      endwhile; endif;

			// Walk through bookings, check if current user has one and update
			// timeslots’ capacity/availability
      $user_id = get_current_user_id();
      if ( have_rows('bookings') ): while ( have_rows('bookings') ): the_row();
        $slot = get_sub_field('timeslot');
        $timeslots[$slot]['available']--;
        if (get_sub_field('member') == $user_id) $registered = $slot;
				$guests = esc_html(get_sub_field('guests'));
      endwhile; endif;

      if ($registered) {
				// If the user already has a booking, render a cancel button
        $content .= "<p>You’ve booked a table for $registered with $guests. See you then, make sure you’re on time!</p>";
        $content .= $this->build_button('cancel-booking', 'Cancel booking', array(
          'post' => get_the_ID(),
          'timeslot' => $slot['begin_time'],
        ) );
      } else {
				// If the user doesn’t have a booking, allow them to get a spot
				$content .= "<style>$this->styling</style>";
				$content .= "<form action='#' id='bookid-form'>";
				$content .= "<p><label for='guests' class='login__label'>
					Who are you bringing? (3 names)</label>";
				$content .= "<input name='guests' id='guests' type='text'
					placeholder='Jamie, Sam, Charlie' class='login__input' required></p>";

        $content .= "<div class='timeslots'>";
        foreach ($timeslots as $key => $slot) {
          $content .= "<div class='timeslots__slot'>";
          $button_text = 'Book a table for ' . $slot['begin'] . '–' . $slot['end'];
          $content .= $this->build_button('add-booking', $button_text, array(
            'post' => get_the_ID(),
            'timeslot' => $slot['begin'],
          ));
          $content .= "<p>Available: " . $slot['available'] . "</p>";
          $content .= "</div>";
        }
        $content .= "</div></form>";
      }

    endwhile; else:
			// Handle a lack of upcoming events
      $content .= "<p>There are no upcoming Kafees you can book a table for. $this->post_type</p>";
    endif;

    wp_reset_query();

    return $content;
  }


}
