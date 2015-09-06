<?php

class InsertagramInstanceModel
{
  
  public function create( $table_name )
  {

    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $table = "CREATE TABLE IF NOT EXISTS $table_name (
      id int(50) NOT NULL AUTO_INCREMENT,
      time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      instance_id int(50) DEFAULT 0 NOT NULL,
      PRIMARY  KEY (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $table );

  }

  public function insert( $id ) {

    global $wpdb;

    $time = current_time( 'mysql' );
    $table_instance_name = $wpdb->prefix . 'insertagram_instances';

    $instance_data = array( 
      'time' => $time,
      'instance_id' => $id,
    );
    $wpdb->insert( 
      $table_instance_name, 
      $instance_data
    );

    return false;
  }

}
