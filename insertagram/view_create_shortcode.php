<?php
function insertagram_insert_instance( $id ) {

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

function insertagram_insert_media( $id, $index ) {

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

function insertagram_insert_init() {
  $insertagram_post_response = array();
  $insertagram_success = false;

  if ( isset( $_POST ) && isset( $_POST['insertagram'] ) ) {

    $date = new DateTime();
    $id = $date->getTimestamp();

    foreach ($_POST as $key => $value) {
      $pos = strrpos( $key, 'instagram_id' );
      if ($pos !== false) {
        $index = str_replace('instagram_id','', $key);
        $insertagram_sub_post_response = insertagram_insert_media( $id, $index );
        if ( isset( $insertagram_sub_post_response ) ) {
          if( $insertagram_sub_post_response['status'] ) $insertagram_success = $id;
          array_push( $insertagram_post_response, $insertagram_sub_post_response );
        }
      }
    }

    if( $insertagram_success ) {
      insertagram_insert_instance( $id );
    }
  }

  insertagram_insert_template( $insertagram_post_response, $insertagram_success );

  return false;

};

function insertagram_insert_template( $insertagram_post_response, $insertagram_success ) {
  $namespace = 'Insertagram';
?>
<div class="wrap">
  <h1>Select and Group Media to Create a Shortcode</h1>
<?php
  if ( !empty( $insertagram_post_response ) ) {
    foreach ( $insertagram_post_response as &$insertagram_sub ) {
      if( !$insertagram_sub['status'] && $insertagram_sub['data'] ) {
        $insertagram_post_status = 'notice-warning';
?>
  <div class="<?php echo $insertagram_post_status; ?> notice is-dismissible"> 
    <p><strong><?php echo $namespace; ?></strong> (warning)</p>
    <?php echo $insertagram_sub['data']; ?>
    <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
  </div>
<?php
      } // end if( !$insertagram_sub['status'] && $insertagram_sub['data'] )
    } // end foreach
    if( $insertagram_success ) {
      $insertagram_post_status = 'updated';
?>
  <div class="<?php echo $insertagram_post_status; ?> notice is-dismissible">
    <p><strong><?php echo $namespace; ?></strong></p>
    <p>Thanks for submitting! Your shortcode is below.</p>
    <p><code>[insertagram id="<?php echo $insertagram_success ?>"]</code></p>
    <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
  </div>
<?php
    } else {
      $insertagram_post_status = 'error';
?>
  <div class="<?php echo $insertagram_post_status; ?> notice is-dismissible"> 
    <p><strong><?php echo $namespace; ?></strong> (error)</p>
    <p>Unfortunately it all went wrong. Copy and paste the warning messages above and send to Insertagram contact.</p>
    <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
  </div>
<?php
    } // end if( $insertagram_success )
  } // end if !empty( $insertagram_post_response )
?>
  <div id="insertagram-gallery-admin" class="insertagram-container">
    <div class="insertagram-gallery-admin-content">
    </div>
    <button class="insertagram__button--more">
      More
      <div class="insertagram__preloader"><div></div><div></div><div>
    </button>
    <form action="" method="post" id="insertagram-admin-form">
      <input type="hidden" name="insertagram" value="true" />
      <button class="insertagram__button--submit" type="submit">
        Submit
        <div class="insertagram__preloader"><div></div><div></div><div>
      </button>
    </form>
  </div>
</div>
<?php
  return false;
}

insertagram_insert_init();
