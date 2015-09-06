<?php

require_once( INSERTAGRAM_DIR . '/models/instance.php' );
require_once( INSERTAGRAM_DIR . '/models/media.php' );

class InsertagramInstallController
{

  public function __construct()
  {

    $this->instanceModel = new InsertagramInstanceModel();
    $this->mediaModel = new InsertagramMediaModel();

  }

  public function install() 
  {

    global $wpdb;

    $table_instance_name = $wpdb->prefix . 'insertagram_instances';
    $table_media_name = $wpdb->prefix . 'insertagram_media';

    $this->instanceModel->create( $table_instance_name );
    $this->mediaModel->create( $table_media_name );

    add_option( 'insertagram_db_version', INSERTAGRAM_DB_VERSION );

  }

}
