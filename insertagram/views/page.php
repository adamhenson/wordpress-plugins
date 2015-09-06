<?php

class InsertagramPageView
{

  public function wp_head( $options ) 
  {
  ?>

  <script>
    window.insertagramConfig = {
      'instagram' : {
        'userId' : '<?php echo $options["insertagram_text_instagram_userId"]; ?>',
        'token' : '<?php echo $options["insertagram_text_instagram_api_token"]; ?>'
      },
      'instances' : [],
      'feeds' : []
    }
  </script>

  <?php
  }

  public function gallery_figure () 
  {

    $figureHtml = '<script id="insertagram-template-gallery-figure" type="text/template">'
      . '<figure class="insertagram<%= infoClass %>" id="insertagram-<%= userId %>">'
      . '<a href="<%= mediaLink %>" target="_blank"><%= overlay %><img src="<%= imageStandardUrl %>" /></a>'
      . '</figure>'
      . '</script>';

    return $figureHtml;

  }

  public function gallery_figure_overlay () 
  {

    $figureOverlayHtml = '<script id="insertagram-template-gallery-figure-overlay" type="text/template">'
      . '<div class="insertagram__overlay">'
      . '<figcaption>'
      . '<h2><span class="insertagram__face" style="background-image:url(<%= profilePicture %>);"></span><span class="insertagram__username">@<%= username %></span></h2>'
      . '<% if(caption) { %>'
      . '<p class="insertagram__caption"><%= caption %></p>'
      . '<% } %>'
      . '<h3>'
      . '<span class="insertagram__icon insertagram__icon--likes ss-heart"></span><span><%= likesCount %></span>'
      . '<span class="insertagram__icon insertagram__icon--comments ss-chat"></span><span><%= commentsCount %></span>'
      . '</h3>'
      . '</figcaption>'
      . '</div>'
      . '</script>';

    return $figureOverlayHtml;

  }

  public function admin_gallery_figure () 
  {

    $adminFigureHtml = '<script id="insertagram-template-admin-gallery-figure" type="text/template">'
      . '<figure data-index="<%= index %>" data-instagram_id="<%= instagramId %>">'
      . '<span class="ss-check"></span>'
      . '<img src="<%= imageLowUrl %>" />'
      . '</figure>'
      . '</script>';

    return $adminFigureHtml;

  }

  public function admin_gallery_inputs () 
  {

    $inputHtml = '<script id="insertagram-template-admin-gallery-inputs" type="text/template">'
      . '<div id="insertagram-form-node-<%= index %>">'
      . '<input type="hidden" name="instagram_id<%= index %>" value="<%= instagramId %>" />'
      . '</div>'
      . '</script>';

    return $inputHtml;

  }

}
