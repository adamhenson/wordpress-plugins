<?php
/*
Plugin Name: Insertagram
Plugin URI: http://portfolio.hensonism.com
Description: Inserts Instagram pics and galleries with ease.
Author: Adam Henson
Version: 0.0.1
Author URI: https://github.com/adamhenson
Text Domain: insertagram
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/
if (!defined( 'INSERTAGRAM_URL' )) {
  define( 'INSERTAGRAM_URL', plugin_dir_url( __FILE__ ) );
}
if (!defined( 'INSERTAGRAM_DIR' )) {
  define( 'INSERTAGRAM_DIR', dirname( __FILE__ ) );
}
if (!defined( 'INSERTAGRAM_DB_VERSION')) {
  define( 'INSERTAGRAM_DB_VERSION', '0.0.1' );
}

require_once( INSERTAGRAM_DIR . '/controllers/init.php' );

$insertagramInitController = new InsertagramInitController();
