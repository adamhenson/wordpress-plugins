<?php

class InsertagramInstallController
{
  
  public function install() {

    global $wpdb;

    $table_instance_name = $wpdb->prefix . 'insertagram_instances';
    $table_media_name = $wpdb->prefix . 'insertagram_media';

    $charset_collate = $wpdb->get_charset_collate();

    $table_instance = "CREATE TABLE IF NOT EXISTS $table_instance_name (
      id int(50) NOT NULL AUTO_INCREMENT,
      time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      instance_id int(50) DEFAULT 0 NOT NULL,
      PRIMARY  KEY (id)
    ) $charset_collate;";

    $table_media = "CREATE TABLE IF NOT EXISTS $table_media_name (
      id int(50) NOT NULL AUTO_INCREMENT,
      time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      instance_id int(50) DEFAULT 0 NOT NULL,
      instagram_id varchar(255) DEFAULT '' NOT NULL,
      PRIMARY  KEY (id)
    ) $charset_collate;";
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $table_instance );
    dbDelta( $table_media );

    add_option( 'insertagram_db_version', INSERTAGRAM_DB_VERSION );

  }

}
