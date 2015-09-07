<?php

class InsertagramSettingsView
{

  public function text_instagram_userId( $options ) 
  {

    if( !isset( $options['insertagram_text_instagram_userId'] ) ) $options['insertagram_text_instagram_userId'] = '';
    return '<input type="text" name="insertagram_settings[insertagram_text_instagram_userId]" value="' . $options['insertagram_text_instagram_userId'] . '">';

  }

  public function text_instagram_api_token_render( $options ) 
  { 

    if( !isset( $options['insertagram_text_instagram_api_token'] ) ) $options['insertagram_text_instagram_api_token'] = '';
    return '<input type="text" name="insertagram_settings[insertagram_text_instagram_api_token]" value="' . $options['insertagram_text_instagram_api_token'] . '">';

  }

  public function options_page() { 
    ?>

    <form action='options.php' method='post' class="wrap" id="insertagram-settings-form">
      
      <h2>Insertagram Settings</h2>
      
      <?php
      settings_fields( 'pluginPage' );
      do_settings_sections( 'pluginPage' );
      submit_button();
      ?>

    </form>

    <a href="https://hensonism-delegator.herokuapp.com/insertagram/code" target="_blank">Get Credentials</a>

    <?php
  }

}
