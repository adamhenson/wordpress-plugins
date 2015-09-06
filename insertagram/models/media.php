<?php

class InsertagramMediaModel
{

  public function create( $table_name )
  {

    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $table = "CREATE TABLE IF NOT EXISTS $table_name (
      id int(50) NOT NULL AUTO_INCREMENT,
      time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      instance_id int(50) DEFAULT 0 NOT NULL,
      instagram_id varchar(255) DEFAULT '' NOT NULL,
      PRIMARY  KEY (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $table );

  }

  public function insert( $id, $index ) {

    global $wpdb;

    $table_media_name = $wpdb->prefix . 'insertagram_media';
    $namespace = 'Insertagram';

    $time = current_time( 'mysql' );
    $instance_id = $id;
    $instagram_id = ( isset ( $_POST['instagram_id' . $index] ) )
      ? $_POST['instagram_id' . $index]
      : '';

    $error_message_prefix = '';
    $error_message = $error_message_prefix;

    // validation
    if( empty( $instagram_id ) ) $error_message .= '<p>Image ' . $index . ': Instagram ID is not set.</p>';

    // handle data
    if( $error_message != $error_message_prefix) {
      return array( 
        'status' => false,
        'data' => $error_message
      );
    } else {
      $media_data = array( 
        'time' => $time,
        'instance_id' => $instance_id,
        'instagram_id' => $instagram_id
      );
      $wpdb->insert( 
        $table_media_name, 
        $media_data
      );
      return array( 
        'status' => true,
        'data' => ''
      );
    }

  }

}
