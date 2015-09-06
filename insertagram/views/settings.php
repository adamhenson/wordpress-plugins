<?php

class InsertagramSettingsView
{

  public function text_license_render( $options ) 
  { 

    return '<input type="text" name="insertagram_settings[insertagram_text_license]" value="' . $options['insertagram_text_license'] . '">';

  }

  public function text_instagram_username_render( $options ) 
  { 

    return '<input type="text" name="insertagram_settings[insertagram_text_instagram_username]" value="' . $options['insertagram_text_instagram_username'] . '">';

  }

  public function text_instagram_userId( $options ) 
  { 

    return '<input type="text" name="insertagram_settings[insertagram_text_instagram_userId]" value="' . $options['insertagram_text_instagram_userId'] . '">';

  }

  public function text_instagram_api_token_render( $options ) 
  { 

    return '<input type="text" name="insertagram_settings[insertagram_text_instagram_api_token]" value="' . $options['insertagram_text_instagram_api_token'] . '">';

  }

  public function options_page() { 
    ?>

    <form action='options.php' method='post' class="wrap">
      
      <h2>Insertagram Settings</h2>
      
      <?php
      settings_fields( 'pluginPage' );
      do_settings_sections( 'pluginPage' );
      submit_button();
      ?>
      
      <?php
      global $wp;
      $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
      $current_url = 'http://garzadam.hensonism.com';
      ?>
      <a href="#" id="insertagram-btn-auth">Authenticate</a>

    </form>

    <?php
  }

}
