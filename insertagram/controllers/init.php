<?php
require_once( INSERTAGRAM_DIR . '/controllers/install.php' );
require_once( INSERTAGRAM_DIR . '/controllers/page.php' );
require_once( INSERTAGRAM_DIR . '/controllers/settings.php' );

class InsertagramInitController
{

  public function __construct()
  {

    $this->add_hooks();

  }

  public function add_hooks()
  {

    $installController = new InsertagramInstallController();
    $pageController = new InsertagramPageController();
    $settingsController = new InsertagramSettingsController();

    register_activation_hook( __FILE__, array( $installController, 'install' ) );

    // actions
    add_action( 'wp_enqueue_scripts', array( $pageController, 'wp_enqueue_scripts' ) );
    add_action( 'admin_enqueue_scripts', array( $pageController, 'admin_enqueue_scripts' ) );
    add_action( 'wp_head', array( $pageController, 'wp_head' ) );
    add_action( 'wp_footer', array( $pageController, 'wp_footer' ) );
    add_action( 'admin_head', array( $pageController, 'wp_head' ) );
    add_action( 'admin_footer', array( $pageController, 'admin_footer' ) );
    add_shortcode( 'insertagram', array( $pageController, 'shortcode' ) );
    // settings & menu actions
    add_action( 'admin_menu', array( $settingsController, 'add_admin_menu' ) );
    add_action( 'admin_init', array( $settingsController, 'settings_init' ) );

  }

}
