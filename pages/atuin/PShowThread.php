<?php
//
// PShowThread.php
//
// Show the content of one thread
//
//

// Check if access is allowed

if (empty ($indexVisited)) {
  die('Här får du inte vara');
}

//
// If not logged in, don't show reply-links
//

$hideReply = (!empty ($_SESSION['username'])) ? '' : " style='display: none;'";

//
// Create a new database object.
//

$db = new CDatabaseController();

// Make sure to get the right thread

if (($_GET['p'] != 'thread') && empty ($_GET['tid'])) {
  header("Location: ?m=atuin&amp;p=allthreads");
  exit;
}
$tid = (is_numeric($_GET['tid'])) ? $_GET['tid'] : 0;
$mysqli = $db->connect();
$resThread = $db->call($SPDisplayThread, $tid);
if ($resThread->num_rows == 0) {
  header("Location: ?m=atuin&amp;p=allthreads");
} else {
  $html = '';
  while ($rowThread = $resThread->fetch_object()) {
    $date = new DateTime($rowThread->post_created_date);
    $postDate = $date->format('Y-m-d H:m:s');
    if (!empty ($rowThread->post_modified_date)) {
      $moddate = new DateTime($rowThread->post_modified_date);
      $modifiedDate = $moddate->format('Y-m-d H:m:s');
      $modReason = empty ($rowThread->post_modified_reason) ? '' : " : {$rowThread->post_modified_reason}";
      $modHtml = "<footer><p>Ändrat {$modifiedDate}{$modReason}</p></footer>";
    } else {
      $modHtml = "";
    }
    $edit = (isset ($_SESSION['userid']) && $db->checkAccess($FCheckAuthorOrAdmin, $rowThread->post_id, $_SESSION['userid'])) ? " | <a href='?m=atuin&amp;p=post&amp;pid={$rowThread->post_id}&amp;tid={$tid}'>Redigera</a>" : "";
    $content = nl2br($rowThread->post_content);
    require_once TP_SOURCEPATH . 'FGravatar.php';
    $gravatarPoster = getGravatar($rowThread->user_email, true);
    $html .= <<<EOD
    <section class="post" id="pid{$rowThread->post_id}">
      <header>
        <p><span class="h2">{$rowThread->post_topic}</span>
          <span class="alignright">Skrivet {$postDate} av {$rowThread->user_name}{$edit}</span></p>
      </header>
      <div class="content">
        {$content}
      </div>
      <aside class="gravatar">{$gravatarPoster}</aside>
      {$modHtml}
      <p class="reply"{$hideReply}><a href="?m=atuin&amp;p=post&amp;tid={$tid}&amp;rid={$rowThread->post_id}">Svara på detta</a></p>
    </section>
EOD;
  }
  $html .= <<< EOD
    <p class="reply"{$hideReply}><a href="?m=atuin&amp;p=post&amp;tid={$tid}">Svara</a></p>
EOD;
}
$title = "A'Tuin";

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