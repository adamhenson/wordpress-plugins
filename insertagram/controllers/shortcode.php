<?php

require_once( INSERTAGRAM_DIR . '/views/shortcode.php' );

class InsertagramShortcodeController
{

  public function __construct()
  {

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

}
