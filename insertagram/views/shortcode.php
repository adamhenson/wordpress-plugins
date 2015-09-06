<?php

class InsertagramShortcodeView
{

  public function gallery_image( $elId, $item, $info ) 
  {

    $imageHtml = '';

    if ( $info != 'false' ) {
      $info = 'true';
    }

    $imageHtml .= '<script>'
      . 'window.insertagramConfig.instances.push({'
      . '"id" : "' . $item['instagram_id'] . '",'
      . '"timestamp" : "' . $elId . '",'
      . '"info" : ' . $info
      . '});'
      . '</script>';

    return $imageHtml;

  }

  public function feed_item( $elId, $info ) 
  {

    return '<script>'
      . 'window.insertagramConfig.feeds.push({'
      . '"id" : "'. $elId . '",'
      . '"info" : '. $info
      . '});'
      . '</script>';

  }

  public function gallery( $elId, $html ) 
  {

    return '<div class="insertagram-container" id="insertagram-container-' . $elId . '">'
      . '<div class="insertagram-gallery">'
      . $html 
      . '</div>'
      . '</div>';

  }

  public function admin( $insertagram_post_response, $insertagram_success ) 
  {

    $namespace = 'Insertagram';
?>
<div class="wrap">
  <h1>Select Media to Create a Shortcode</h1>
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

}