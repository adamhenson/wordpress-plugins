<?php

require_once( INSERTAGRAM_DIR . '/views/page.php' );

class InsertagramPageController
{

  public function __construct()
  {

    $this->view = new InsertagramPageView();

  }

  public function wp_enqueue() 
  {

    wp_enqueue_style( 'ss-standard', INSERTAGRAM_URL . 'css/webfonts/ss-standard.css' );
    wp_enqueue_style( 'main', INSERTAGRAM_URL . 'css/main.css' );
    wp_enqueue_script( 'modernizr', INSERTAGRAM_URL . 'js/lib/modernizr.js', array(), false, true );
    wp_enqueue_script( 'main', INSERTAGRAM_URL . 'js/main-min.js', array('jquery', 'underscore'), false, true );
  
  }

  public function admin_enqueue() 
  {

    wp_enqueue_style( 'ss-standard', INSERTAGRAM_URL . 'css/webfonts/ss-standard.css' );
    wp_enqueue_style( 'main', INSERTAGRAM_URL . 'css/main.css' );
    wp_enqueue_script( 'admin', INSERTAGRAM_URL . 'js/admin-min.js', array('jquery', 'underscore'), false, true );

  }

  public function wp_head() 
  {

    $options = get_option( 'insertagram_settings' );
    $this->view->wp_head( $options );

  }

  public function wp_footer() 
  {

    $html = $this->view->gallery_figure();
    $html .= $this->view->gallery_figure_overlay();

    echo $html;

  }

  public function admin_footer() 
  {

    $html = $this->view->admin_gallery_figure();
    $html .= $this->view->admin_gallery_inputs();

    echo $html;

  }

}
