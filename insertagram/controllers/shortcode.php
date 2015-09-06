<?php

require_once( INSERTAGRAM_DIR . '/models/instance.php' );
require_once( INSERTAGRAM_DIR . '/models/media.php' );
require_once( INSERTAGRAM_DIR . '/views/shortcode.php' );

class InsertagramShortcodeController
{

  public function __construct()
  {

    $this->instanceModel = new InsertagramInstanceModel();
    $this->mediaModel = new InsertagramMediaModel();
    $this->view = new InsertagramShortcodeView();

  }

  public function render( $attributes, $content = null ) 
  {

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
      $html .= $this->view->feed_item( $elId, $info );

    }

    return $this->view->gallery( $elId, $html );

  }

  public function admin() 
  {
    
    $insertagram_post_response = array();
    $insertagram_success = false;

    if ( isset( $_POST ) && isset( $_POST['insertagram'] ) ) {

      $date = new DateTime();
      $id = $date->getTimestamp();

      foreach ($_POST as $key => $value) {
        $pos = strrpos( $key, 'instagram_id' );
        if ($pos !== false) {
          $index = str_replace('instagram_id','', $key);
          $insertagram_sub_post_response = $this->mediaModel->insert( $id, $index );
          if ( isset( $insertagram_sub_post_response ) ) {
            if( $insertagram_sub_post_response['status'] ) $insertagram_success = $id;
            array_push( $insertagram_post_response, $insertagram_sub_post_response );
          }
        }
      }

      if( $insertagram_success ) {
        $this->instanceModel->insert( $id );
      }
    }

    $this->view->admin( $insertagram_post_response, $insertagram_success );

    return false;

  }

}
