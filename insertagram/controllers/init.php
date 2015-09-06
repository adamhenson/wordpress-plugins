<?php
require_once( INSERTAGRAM_DIR . '/controllers/page.php' );

class InsertagramInitController
{
  public function __construct()
  {
    $this->add_hooks();
  }
  public function add_hooks()
  {
    $page = new InsertagramPageController();
    register_activation_hook( __FILE__, array( $page, 'install' ) );
    // actions
    add_action( 'wp_enqueue_scripts', array( $page, 'wp_enqueue_scripts' ) );
    add_action( 'admin_enqueue_scripts', array( $page, 'admin_enqueue_scripts' ) );
    add_action( 'wp_head', array( $page, 'wp_head' ) );
    add_action( 'wp_footer', array( $page, 'wp_footer' ) );
    add_action( 'admin_head', array( $page, 'wp_head' ) );
    add_action( 'admin_footer', array( $page, 'admin_footer' ) );
    add_shortcode( 'insertagram', array( $page, 'shortcode' ) );
    // settings & menu actions
    add_action( 'admin_menu', array( $page, 'add_admin_menu' ) );
    add_action( 'admin_init', array( $page, 'settings_init' ) );
  }
}
