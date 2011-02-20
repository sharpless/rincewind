<?php
//
// PAllPosts.php
//
// Show all posts
// 
//
//

if (!isset ($indexVisited)) {
  die('Access not allowed');
}

//
// Create a new database object, we are using the CDatabaseController class.
//

$db = new CDatabaseController();
$mysqli = $db->connect();
// Page title

$title = 'Fooglerblogg';

// Stylesheet

$css = isset ($_SESSION['css']) ? $_SESSION['css'] : WS_CSS;

//
// Create queries
//
$queryPosts = <<<EOD
SELECT post_id,
  post_content,
  post_title,
  post_date,
  user_id,
  user_name,
  user_email,
  (SELECT COUNT(comment_post_id)) AS count_comment
FROM {$tableBlogPosts}
  INNER JOIN {$tableUsers}
    ON post_author = user_id
  LEFT JOIN {$tableBlogComments}
    ON post_id = comment_post_id
GROUP BY post_id
ORDER BY post_date DESC
EOD;


// Main content

$resPosts = $db->query($queryPosts);
if (!$resPosts->num_rows) {
  $htmlLeft = "<p>Inga poster alls :(</p>";
} else {
  $htmlLeft = "";
  while ($rowPosts = $resPosts->fetch_object()) {
    if (isset ($_SESSION['userid']) && ($_SESSION['userid'] == $rowPosts->user_id)) {
      $edit = " | <a href='?m=blog&amp;p=edit&amp;id={$rowPosts->post_id}'>Redigera</a> | <a href='?m=blog&amp;p=delete&amp;id={$rowPosts->post_id}'>Ta bort</a>";
    } else {
      $edit = '';
    }
    if ($rowPosts->count_comment > 1 ) {
      $comments = "<a href='?m=blog&amp;p=post&amp;id={$rowPosts->post_id}#comments'>{$rowPosts->count_comment} kommentarer</a>";
    } else if ($rowPosts->count_comment == 1) {
      $comments = "<a href='?m=blog&amp;p=post&amp;id={$rowPosts->post_id}#comments'>1 kommentar</a>";
    } else {
      $comments = "<a href='?m=blog&amp;p=post&amp;id={$rowPosts->post_id}#comments'>inga kommentarer</a>";
    }
    $date = new DateTime($rowPosts->post_date);
    require_once TP_SOURCEPATH . 'FGravatar.php';
    $gravatarPost = getGravatar($rowPosts->user_email, true);
    $postDate = $date->format('Y-m-d');
    $htmlLeft .= <<<EOD
      <section class="post">
        <header>
          <p><span class="h2"><a href="?m=blog&amp;p=post&amp;id={$rowPosts->post_id}">{$rowPosts->post_title}</a></span> <span class="alignright">Det finns {$comments}</span></p>
        </header>
        <div class="content clear">
          {$rowPosts->post_content}
        </div>
        <aside class="gravatar">{$gravatarPost}</aside>
        <footer>
          <p>Skrivet {$postDate} av {$rowPosts->user_name}{$edit}</p>
        </footer>
      </section>
EOD;
  }
}
// Sidebar
// First the user part

//
// Create and print out the resulting page
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php');

$page = new CHTMLPage();
//$page->setLeftColumn($htmlLeft);
include_once 'PSideBar.php';
$page->setRightColumn($sidebar);
$page->printHTMLHeader($title);
$page->printPageHeader();
$page->printPageBody($htmlLeft);
$page->printPageFooter();


?>