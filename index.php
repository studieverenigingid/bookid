<?php
/*
Plugin Name: BookID
Plugin URI: https://svid.nl
Description: Wordpress plugin which allows the creation of bookable events with timeslots.
Author: Floris Jansen
Version: 0.2
Author URI: https://fmjansen.nl
*/

require plugin_dir_path(__FILE__) . 'inc/class.bookid.php';

function run_bookid() {
	$bookid = new BookID();
	$bookid->run();
}

run_bookid();
