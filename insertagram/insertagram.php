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

// globals
global $insertagram_db_version;
$insertagram_db_version = '0.0.1';

// on activation
register_activation_hook( __FILE__, 'insertagram_install' );
// actions
//add_action( 'init', 'insertagram_init');
add_action( 'wp_enqueue_scripts', 'insertagram_wp_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'insertagram_admin_enqueue_scripts' );
add_action( 'wp_head', 'insertagram_wp_head' );
add_action( 'wp_footer', 'insertagram_wp_footer' );
add_action( 'admin_head', 'insertagram_wp_head' );
add_action( 'admin_footer', 'insertagram_admin_footer' );
add_shortcode( 'insertagram', 'insertagram_shortcode' );
// settings & menu actions
add_action( 'admin_menu', 'insertagram_add_admin_menu' );
add_action( 'admin_init', 'insertagram_settings_init' );

function insertagram_install() {

  global $wpdb;
  global $insertagram_db_version;

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

  add_option( 'insertagram_db_version', $insertagram_db_version );

}

function insertagram_wp_enqueue_scripts() {
  wp_enqueue_style( 'ss-standard', plugin_dir_url( __FILE__ ) . 'css/webfonts/ss-standard.css' );
  wp_enqueue_style( 'main', plugin_dir_url( __FILE__ ) . 'css/main.css' );
  wp_enqueue_script( 'modernizr', plugin_dir_url( __FILE__ ) . 'js/lib/modernizr.js', array(), false, true );
  wp_enqueue_script( 'main', plugin_dir_url( __FILE__ ) . 'js/main.js', array('jquery', 'underscore'), false, true );
}

function insertagram_admin_enqueue_scripts() {

  wp_enqueue_style( 'ss-standard', plugin_dir_url( __FILE__ ) . 'css/webfonts/ss-standard.css' );
  wp_enqueue_style( 'main', plugin_dir_url( __FILE__ ) . 'css/main.css' );
  wp_enqueue_script( 'admin', plugin_dir_url( __FILE__ ) . 'js/admin.js', array('jquery', 'underscore'), false, true );

}

function insertagram_wp_head() {

  $options = get_option( 'insertagram_settings' );

?>

<script>
  window.insertagramConfig = {
    'license' : '<?php echo $options["insertagram_text_license"]; ?>',
    'instagram' : {
      'username' : '<?php echo $options["insertagram_text_instagram_username"]; ?>',
      'userId' : '<?php echo $options["insertagram_text_instagram_userId"]; ?>',
      'token' : '<?php echo $options["insertagram_text_instagram_api_token"]; ?>'
    },
    'instances' : [],
    'feeds' : []
  }
</script>

<?php

}

function insertagram_wp_footer() {

  require_once( 'view_gallery.php' );

  $html = insertagram_view_template_gallery_figure();
  $html .= insertagram_view_template_gallery_figure_overlay();

  echo $html;

}

function insertagram_admin_footer() {

  require_once( 'view_gallery.php' );

  $html = insertagram_view_template_admin_gallery_figure();
  $html .= insertagram_view_template_admin_gallery_inputs();

  echo $html;

}

function insertagram_shortcode( $attributes, $content = null ) {

  require_once( 'view_gallery.php' );

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
      $html .= insertagram_view_gallery_image( $elId, $results_value, $info );
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


// Settings & menus
function insertagram_add_admin_menu() { 

  // Settings
  add_options_page( 'Insertagram', 'Insertagram', 'manage_options', 'insertagram', 'insertagram_options_page' );
  
  // Menu
  $insertagram_menu =  array (
    'page_title' => 'Insertagram - Create Shortcode',
    'menu_title' => 'Insertagram +',
    'capability' => 'manage_options',
    'slug' => 'insertagram/view_create_shortcode.php',
    'callback' => '',
    'icon' => plugins_url( 'insertagram/images/icon-menu.png' ),
    'position' => 4
  );

  add_menu_page( $insertagram_menu['page_title'], $insertagram_menu['menu_title'], $insertagram_menu['capability'], $insertagram_menu['slug'], $insertagram_menu['callback'], $insertagram_menu['icon'], $insertagram_menu['position'] );

}

function insertagram_settings_init() { 

  register_setting( 'pluginPage', 'insertagram_settings' );

  add_settings_section(
    'insertagram_pluginPage_section', 
    __( '', 'insertagram' ), 
    false, 
    'pluginPage'
  );

  add_settings_field( 
    'insertagram_text_license', 
    __( 'License #', 'insertagram' ), 
    'insertagram_text_license_render', 
    'pluginPage', 
    'insertagram_pluginPage_section' 
  );

  add_settings_field( 
    'insertagram_text_instagram_username', 
    __( 'Instagram Username: @', 'insertagram' ), 
    'insertagram_text_instagram_username_render', 
    'pluginPage', 
    'insertagram_pluginPage_section' 
  );

  add_settings_field( 
    'insertagram_text_instagram_userId', 
    __( 'Instagram User ID', 'insertagram' ), 
    'insertagram_text_instagram_userId',
    'pluginPage', 
    'insertagram_pluginPage_section' 
  );

  add_settings_field( 
    'insertagram_text_instagram_api_token', 
    __( 'Instagram API Token (optional)', 'insertagram' ), 
    'insertagram_text_instagram_api_token_render', 
    'pluginPage', 
    'insertagram_pluginPage_section' 
  );

}

function insertagram_text_license_render() { 

  $options = get_option( 'insertagram_settings' );
  ?>
  <input type='text' name='insertagram_settings[insertagram_text_license]' value='<?php echo $options['insertagram_text_license']; ?>'>
  <?php

}

function insertagram_text_instagram_username_render() { 

  $options = get_option( 'insertagram_settings' );
  ?>
  <input type='text' name='insertagram_settings[insertagram_text_instagram_username]' value='<?php echo $options['insertagram_text_instagram_username']; ?>'>
  <?php

}

function insertagram_text_instagram_userId() { 

  $options = get_option( 'insertagram_settings' );
  ?>
  <input type='text' name='insertagram_settings[insertagram_text_instagram_userId]' value='<?php echo $options['insertagram_text_instagram_userId']; ?>'>
  <?php

}

function insertagram_text_instagram_api_token_render() { 

  $options = get_option( 'insertagram_settings' );
  ?>
  <input type='text' name='insertagram_settings[insertagram_text_instagram_api_token]' value='<?php echo $options['insertagram_text_instagram_api_token']; ?>'>
  <?php

}

function insertagram_options_page() { 

  ?>
  <form action='options.php' method='post' class="wrap">
    
    <h2>insertagram</h2>
    
    <?php
    settings_fields( 'pluginPage' );
    do_settings_sections( 'pluginPage' );
    submit_button();
    ?>
    
  </form>
  <?php

}
