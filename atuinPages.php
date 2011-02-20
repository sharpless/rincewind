<?php
switch ($_SESSION['page']) {
  case 'post':
    include_once TP_PAGESPATH . 'atuin/PEditPost.php';
    break;
  case 'postp':
    include_once TP_PAGESPATH . 'atuin/PEditPostProcess.php';
    break;
  case 'showpost':
    include_once TP_PAGESPATH . 'atuin/PShowPost.php';
    break;
  case 'showthread':
    include_once TP_PAGESPATH . 'atuin/PShowThread.php';
    break;
  case 'allthreads':
  default:
    include_once TP_PAGESPATH . 'atuin/PAllThreads.php';
    break;
}
?>
