<?php

class BookID {

  protected $plugin_name;
  protected $version;
  protected $renderer;
  protected $creator;

  public function __construct() {
    $this->plugin_name = 'BookID';
    $this->version = '0.1';
    $this->load_dependencies();
  }

  // Load the required dependencies for this plugin
  private function load_dependencies() {
    require_once plugin_dir_path( dirname(__FILE__) ) . 'inc/class.bookid.renderer.php';
    require_once plugin_dir_path( dirname(__FILE__) ) . 'inc/class.bookid.creator.php';
    require_once plugin_dir_path( dirname(__FILE__) ) . 'inc/class.bookid.ajax.php';
    $this->renderer = new BookID_Renderer();
    $this->creator = new BookID_Creator();
    $this->ajax = new BookID_Ajax();
  }

  // Run the loader to execute all of the hooks with Wordpress
  public function run() {
    $this->renderer->run();
    $this->creator->run();
    $this->ajax->run();
	}

}
