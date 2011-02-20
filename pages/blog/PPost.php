<?php
//
// PPost.php
//
// Show one post
//
//

// Check if access is allowed

if (!isset ($indexVisited)) {
  die('Access not allowed');
}


//
// Create a new database object, we are using the db-extension.
//

$db = new CDatabaseController();
$mysqli = $db->connect();

// Make sure to get the right post

if (isset ($_GET['id']) && is_numeric($_GET['id']) && $_GET['p'] == 'post') {
  $id = $_GET['id'];
  $queryPost = <<<EOD
SELECT post_id,
  post_content,
  post_title,
  post_date,
  user_id,
  user_name,
  user_email,
  COUNT(comment_id) AS count_comment
FROM {$tableBlogPosts}
  INNER JOIN {$tableUsers}
    ON post_author = user_id
  LEFT JOIN {$tableBlogComments}
    ON post_id = comment_post_id
WHERE post_id = {$id} GROUP BY post_id
EOD;
} else {
  header("Location: ?m=blog&amp;p=home");
  exit;
}

// Make the page

$resPost = $db->query($queryPost);

$rowPost = $resPost->fetch_object();

  if (isset ($_SESSION['userid']) && ($_SESSION['userid'] == $rowPost->user_id)) {
    $edit = " | <a href='?m=blog&amp;p=edit&amp;id={$rowPost->post_id}'>Redigera</a> | <a href='?m=blog&amp;p=delete&amp;id={$rowPost->post_id}'>Ta bort</a>";
  } else {
    $edit = '';
  }
if ($rowPost->count_comment > 1 ) {
  $comments = "{$rowPost->count_comment} kommentarer";
} else if ($rowPost->count_comment == 1) {
  $comments = "1 kommentar";
} else {
  $comments = "Bli den första att skriva en kommentar";
}
$date = new DateTime($rowPost->post_date);
$postDate = $date->format('Y-m-d');
require_once TP_SOURCEPATH . 'FGravatar.php';
$gravatarPost = getGravatar($rowPost->user_email, true);
$htmlLeft = <<<EOD
    <section class="post">
      <header>
        <p><span class="h2"><a href="?m=blog&amp;p=post&amp;id={$rowPost->post_id}">{$rowPost->post_title}</a></span><span class="alignright">{$comments}</span></p>
      </header>
      <div class="content">
        {$rowPost->post_content}
      </div>
      <aside class="gravatar">{$gravatarPost}</aside>
      <footer>
        <p>Postat {$postDate} av {$rowPost->user_name}{$edit}</p>
      </footer>
    </section>
EOD;

// Add anchor
  $htmlLeft .= "<div id='comments'>\n";
// Comments (if any)
if ($rowPost->count_comment > 0) {
  $queryComment = <<<EOD
  SELECT comment_author,
    comment_content,
    comment_title,
    comment_email,
    comment_date
  FROM {$tableBlogComments}
  WHERE comment_post_id = {$id}
EOD;
  $resComment = $db->query($queryComment);
  while ($rowComment = $resComment->fetch_object()) {
    $gravatarComment = getGravatar($rowComment->comment_email, true);
    $htmlLeft .= <<<EOD
      <div class="comment">
        <p class="commentator">Kommentar av {$rowComment->comment_author} den {$rowComment->comment_date}</p>
        <h3>{$rowComment->comment_title}<span class="alignright">{$gravatarComment}</span></h3>
        <p>{$rowComment->comment_content}</p>
      </div>
EOD;
  }
}
$htmlLeft .= "</div>";
// Comment form

$htmlLeft .= <<<EOD
<div class="commentform">
  <form action="?m=blog&amp;p=comment" method="post" onsubmit="return validateForm();">
    <p>
      <label for="title">Rubrik:</label><input type="text" name="title" id="title" required ><br>
      <label for="content">Kommentar:</label><textarea name="content" id="content" rows="3" cols="40" required></textarea><br>
      <label for="author">Namn:</label><input type="text" name="author" id="author" required><br>
      <label for="email">E-post:</label><input type="email" name="email" id="email" required><br>
      <input type="hidden" name="id" value="{$id}">
      <input type="hidden" name="redirect" value="post&amp;id={$id}">
      <label for="submit">&nbsp;</label><input type="submit" value="Kommentera" name="submit" id="submit">
    </p>
  </form>
</div>
EOD;
// Page title

$title = $rowPost->post_title;

//
// Create and print out the resulting page
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php');

$page = new CHTMLPage();

$page->printHTMLHeader($title, 'yes');
$page->printPageHeader();
//$page->setLeftColumn($htmlLeft);
include_once 'PSideBar.php';
$page->setRightColumn($sidebar);
$page->printPageBody($htmlLeft);
$page->printPageFooter();


?>