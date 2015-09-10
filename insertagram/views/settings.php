<?php

class InsertagramSettingsView
{

  public function text_instagram_userId( $options ) 
  {

    if( !isset( $options['insertagram_text_instagram_user_id'] ) ) $options['insertagram_text_instagram_user_id'] = '';
    return '<input type="text" name="insertagram_settings[insertagram_text_instagram_user_id]" value="' . $options['insertagram_text_instagram_user_id'] . '">';

  }

  public function text_instagram_api_token_render( $options ) 
  { 

    if( !isset( $options['insertagram_text_instagram_api_token'] ) ) $options['insertagram_text_instagram_api_token'] = '';
    return '<input type="text" name="insertagram_settings[insertagram_text_instagram_api_token]" value="' . $options['insertagram_text_instagram_api_token'] . '">';

  }

  public function options_page() { 
    ?>

    <div class="wrap">
    <h1>Insertagram Settings</h1>
    <p>Click on the button below to get your Instagram API credentials. After that, copy and paste the credentials into the form below and submit.</p>
    <a href="https://hensonism-delegator.herokuapp.com/insertagram/code" target="_blank" class="button-primary">Get Credentials</a>
    <form action='options.php' method='post' class="wrap" id="insertagram-settings-form">
      
      <?php
      settings_fields( 'pluginPage' );
      do_settings_sections( 'pluginPage' );
      submit_button();
      ?>

    </form>
    </div>

    <?php
  }

}
