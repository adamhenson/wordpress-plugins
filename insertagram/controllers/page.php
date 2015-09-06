<?php
require_once( INSERTAGRAM_DIR . '/views/page.php' );

class InsertagramPageController
{

  public function __construct()
  {

    $this->view = new InsertagramPageView();

  }

  public function wp_enqueue_scripts() {
    wp_enqueue_style( 'ss-standard', INSERTAGRAM_URL . 'css/webfonts/ss-standard.css' );
    wp_enqueue_style( 'main', INSERTAGRAM_URL . 'css/main.css' );
    wp_enqueue_script( 'modernizr', INSERTAGRAM_URL . 'js/lib/modernizr.js', array(), false, true );
    wp_enqueue_script( 'main', INSERTAGRAM_URL . 'js/main.js', array('jquery', 'underscore'), false, true );
  }

  public function admin_enqueue_scripts() {

    wp_enqueue_style( 'ss-standard', INSERTAGRAM_URL . 'css/webfonts/ss-standard.css' );
    wp_enqueue_style( 'main', INSERTAGRAM_URL . 'css/main.css' );
    wp_enqueue_script( 'admin', INSERTAGRAM_URL . 'js/admin.js', array('jquery', 'underscore'), false, true );

  }

  public function wp_head() {

    $options = get_option( 'insertagram_settings' );
    $this->view->wp_head( $options );

  }

  public function wp_footer() {

    $html = $this->view->gallery_figure();
    $html .= $this->view->gallery_figure_overlay();

    echo $html;

  }

  public function admin_footer() {

    $html = $this->view->admin_gallery_figure();
    $html .= $this->view->admin_gallery_inputs();

    echo $html;

  }

  public function shortcode( $attributes, $content = null ) {

    $options = get_option( 'insertagram_settings' );
    $username = '';

    extract( shortcode_atts( array(
      'id' => '',
      'info' => '',
      'feed' => ''
    ), $attributes ) );

    if($info != 'false') $info = 'true';

    if( !empty( $options['insertagram_text_instagram_username'] ) ) $username = $options['insertagram_text_instagram_username'];

    $elId = time();
    $html = '';

    if( $id ) {
      // get the data
      global $wpdb;
      $table_media_name = $wpdb->prefix . 'insertagram_media';

      $results = $wpdb->get_results( 'SELECT * FROM ' . $table_media_name . ' WHERE instance_id = ' . $id, ARRAY_A );

      foreach ( $results as &$results_value ) {
        $html .= $this->view->gallery_image( $elId, $results_value, $info );
      }
    } elseif ( $feed ) {

      $elId = 'feed-' . $elId;
      $html .= '<script>'
        . 'window.insertagramConfig.feeds.push({'
        . '"id" : "'. $elId . '",'
        . '"info" : '. $info
        . '});'
        . '</script>';

    }

    return '<div class="insertagram-container" id="insertagram-container-' . $elId . '">'
      . '<div class="insertagram-gallery">'
      . $html 
      . '</div>'
      . '</div>';

  }

}
