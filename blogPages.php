<?php
switch ($_SESSION['page']) {
  case 'post':
    include_once TP_PAGESPATH . 'blog/PPost.php';
    break;
  case 'author':
    include_once TP_PAGESPATH . 'blog/PAuthor.php';
    break;
  case 'comment':
    include_once TP_PAGESPATH . 'blog/PCommentProcess.php';
    break;
  case 'edit':
    include_once TP_PAGESPATH . 'blog/PEditPost.php';
    break;
  case 'editp':
    include_once TP_PAGESPATH . 'blog/PEditPostProcess.php';
    break;
  case 'new':
    include_once TP_PAGESPATH . 'blog/PNewPost.php';
    break;
  case 'newp':
    include_once TP_PAGESPATH . 'blog/PNewPostProcess.php';
    break;
  case 'delete':
    include_once TP_PAGESPATH . 'blog/PDeletePostProcess.php';
    break;
  default:
  case 'home':
    include_once TP_PAGESPATH . 'blog/PAllPosts.php';
    $_SESSION['page'] = 'home';
    break;
}
?>
