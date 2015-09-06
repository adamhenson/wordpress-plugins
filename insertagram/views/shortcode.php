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

}
