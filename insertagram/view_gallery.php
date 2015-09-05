<?php
function insertagram_view_gallery_image( $elId, $item, $info ) {

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

function insertagram_view_template_gallery_figure () {

  $figureHtml = '<script id="insertagram-template-gallery-figure" type="text/template">'
    . '<figure class="insertagram<%= infoClass %>" id="insertagram-<%= userId %>">'
    . '<a href="<%= mediaLink %>" target="_blank"><%= overlay %><img src="<%= imageStandardUrl %>" /></a>'
    . '</figure>'
    . '</script>';

  return $figureHtml;

}

function insertagram_view_template_gallery_figure_overlay () {

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

function insertagram_view_template_admin_gallery_figure () {

  $adminFigureHtml = '<script id="insertagram-template-admin-gallery-figure" type="text/template">'
    . '<figure data-index="<%= index %>" data-instagram_id="<%= instagramId %>">'
    . '<span class="ss-check"></span>'
    . '<img src="<%= imageLowUrl %>" />'
    . '</figure>'
    . '</script>';

  return $adminFigureHtml;

}

function insertagram_view_template_admin_gallery_inputs () {

  $inputHtml = '<script id="insertagram-template-admin-gallery-inputs" type="text/template">'
    . '<div id="insertagram-form-node-<%= index %>">'
    . '<input type="hidden" name="instagram_id<%= index %>" value="<%= instagramId %>" />'
    . '</div>'
    . '</script>';

  return $inputHtml;

}
