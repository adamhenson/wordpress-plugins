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

  public function messages_template( $namespace, $status, $message )
  {

    return '<div class="' . $status . ' notice is-dismissible">' 
      . '<p><strong>' . $namespace . '</strong></p>'
      . $message
      . '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>'
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
          echo $this->messages_template( $namespace, $insertagram_post_status, $insertagram_sub['data'] );
        } // end if( !$insertagram_sub['status'] && $insertagram_sub['data'] )
      } // end foreach
      if( $insertagram_success ) {
        $insertagram_post_status = 'updated';
        $message = '<p>Thanks for submitting! Your shortcode is below.</p>';
        $message .= '<p><code>[insertagram id=' . $insertagram_success . ']</code></p>';
        echo $this->messages_template( $namespace, $insertagram_post_status, $message );
      } else {
        $insertagram_post_status = 'error';
        $message = '<p>Unfortunately it all went wrong. Copy and paste the warning messages above and send to Insertagram contact.</p>';
        echo $this->messages_template( $namespace, $insertagram_post_status, $message );
      } // end if( $insertagram_success )
    } // end if !empty( $insertagram_post_response )
  ?>
  <?php

    $options = get_option( 'insertagram_settings' );

    if ( empty( $options['insertagram_text_instagram_api_token'] ) || empty( $options['insertagram_text_instagram_user_id'] ) ) {
      
      $message = '';

      if( empty( $options['insertagram_text_instagram_user_id'] ) ) {
        $message .= 'User ID is not set. ';
      }

      if( empty( $options['insertagram_text_instagram_api_token'] ) ) {
        $message .= 'Access Token is not set.';
      }
      
      $message = '<p>' . $message . ' Please visit the <a href="' . get_site_url() . '/wp-admin/options-general.php?page=insertagram">settings page</a> to set your credentials.</p>';

      $insertagram_post_status = 'error';

      echo $this->messages_template( $namespace, $insertagram_post_status, $message );

    } else {

  ?>
    <p>Select one or more items and click "submit" to generate a shortcode to paste into any post or page.</p>
    <p>If you want to display a feed of recent posts, simply paste in this shortcode: <code>[insertagram feed=true]</code>.</p>
    <script>window.insertagramConfig.shortcodePage = true;</script>
    <div id="insertagram-gallery-admin" class="insertagram-container">
      <div class="insertagram-gallery-admin-content"></div>
      <div class="insertagram__buttons">
        <button class="insertagram__button--more">
          More
          <div class="insertagram__preloader"><div></div><div></div><div></div></div>
        </button>
        <form action="" method="post" id="insertagram-admin-form">
          <input type="hidden" name="insertagram" value="true" />
          <button class="insertagram__button--submit" type="submit">
            Submit
            <div class="insertagram__preloader"><div></div><div></div><div></div></div>
          </button>
        </form>
      </div>
    </div>
  </div>
  <?php

    }

    return false;

  }

}
