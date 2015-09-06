<?php

require_once( INSERTAGRAM_DIR . '/views/settings.php' );

class InsertagramSettingsController
{

  public function __construct()
  {

    $this->view = new InsertagramSettingsView();

  }

  public function add_admin_menu() 
  { 

    // Settings
    add_options_page( 'Insertagram', 'Insertagram', 'manage_options', 'insertagram', array( $this, 'options_page' ) );
    
    // Menu
    $insertagram_menu =  array (
      'page_title' => 'Insertagram - Create Shortcode',
      'menu_title' => 'Insertagram +',
      'capability' => 'manage_options',
      'slug' => 'insertagram/shortcode.php',
      'callback' => '',
      'icon' => plugins_url( 'insertagram/images/icon-menu.png' ),
      'position' => 4
    );

    add_menu_page( $insertagram_menu['page_title'], $insertagram_menu['menu_title'], $insertagram_menu['capability'], $insertagram_menu['slug'], $insertagram_menu['callback'], $insertagram_menu['icon'], $insertagram_menu['position'] );

  }

  public function settings_init() 
  { 

    register_setting( 'pluginPage', 'insertagram_settings' );

    add_settings_section(
      'insertagram_pluginPage_section', 
      __( '', 'insertagram' ), 
      false, 
      'pluginPage'
    );

    add_settings_field( 
      'insertagram_text_instagram_userId', 
      __( 'Instagram User ID', 'insertagram' ), 
      array( $this, 'text_instagram_userId' ), 
      'pluginPage', 
      'insertagram_pluginPage_section' 
    );

    add_settings_field( 
      'insertagram_text_instagram_api_token', 
      __( 'Instagram API Token', 'insertagram' ), 
      array( $this, 'text_instagram_api_token_render' ), 
      'pluginPage', 
      'insertagram_pluginPage_section' 
    );

  }

  public function text_instagram_userId() 
  { 

    $options = get_option( 'insertagram_settings' );
    echo $this->view->text_instagram_userId( $options );

  }

  public function text_instagram_api_token_render() 
  { 

    $options = get_option( 'insertagram_settings' );
    echo $this->view->text_instagram_api_token_render( $options );

  }

  public function options_page() 
  { 

    $this->view->options_page();

  }

}
