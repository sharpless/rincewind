<?php
//
// PShowPost.php
//
// Show one post
//
//

// Check if access is allowed

if (empty ($indexVisited)) {
  die('Här får du inte vara');
}


//
// Create a new database object, we are using the MySQLi-extension.
//

$db = new CDatabaseController();

// Make sure to get the right post

if (isset ($_GET['id']) && is_numeric($_GET['id']) && $_GET['p'] == 'showpost') {
  $id = $_GET['id'];
  /*$queryPost = <<<EOD
SELECT post_id,
  post_content,
  post_topic,
  post_created_date,
  user_name
FROM {$tableThreadPosts}
  INNER JOIN {$tableUsers}
    ON post_author_id = user_id
WHERE post_id = {$id}
EOD; */
} else {
  header("Location: ?m=atuin&amp;p=home");
  exit;
}
$userid = empty ($_SESSION['userid']) ? 0 : $_SESSION['userid'];
$mysqli = $db->connect();
$resPost = $db->call($SPDisplayThreadPost, "$id, $userid");
if ($resPost->num_rows == 0) {
  header("Location: ?m=atuin&amp;p=home");
  exit;
}
$rowPost = $resPost->fetch_object();

  if (isset ($_SESSION['userid']) && ($rowPost->user_check)) {
    //$edit = " | <a href='?m=atuin&amp;p=editpost&amp;id={$id}'>Redigera</a> | <a href='?m=atuin&amp;p=delete&amp;id={$id}'>Ta bort</a>";
    $edit = " | <a href='?m=atuin&amp;p=editpost&amp;id={$id}'>Redigera</a>";
  } else {
    $edit = '';
  }
$date = new DateTime($rowPost->post_created_date);
$postDate = $date->format('Y-m-d');
if (!empty ($rowPost->post_modified_date)) {
  $moddate = new DateTime($rowPost->post_modified_date);
  $modifiedDate = $moddate->format('Y-m-d H:m:s');
  $modReason = empty ($rowPost->post_modified_reason) ? '' : " : {$rowPost->post_modified_reason}";
  $modHtml = "<p class='mod'>Ändrat {$modifiedDate}{$modReason}</a></p>";
} else {
  $modHtml = "";
}
$reply = 
$content = nl2br($rowPost->post_content);
$html = <<<EOD
    <section>
      <p class="small">Skrivet {$postDate} av {$rowPost->user_name}{$edit}</p>
      <h2>{$rowPost->post_topic}</h2>
      <div class="content">
        {$content}
        {$modHtml}
      </div>
      {$modHtml}
    </section>
EOD;


$title = $rowPost->post_topic;

//
// Create and print out the resulting page
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php');

$page = new CHTMLPage();

$page->printHTMLHeader($title);
$page->printPageHeader();
include_once 'PSideBar.php';
$page->setRightColumn($sidebar);
$page->printPageBody($html);
$page->printPageFooter();


?>