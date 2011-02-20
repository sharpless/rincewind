<?php
  function getGravatar($aEmail, $aImage = false, $aSize = 60, $aDefault = 'monsterid') {
    // Inspired by example code from Gravatar
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5(trim(strtolower($aEmail)));
    $url .= "?s={$aSize}&amp;d={$aDefault}";
    if ($aImage) {
      $url = "<img src='{$url}' alt='Gravatar'>";
    }
    return $url;
  }
?>
