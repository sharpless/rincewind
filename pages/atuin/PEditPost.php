<?php
// ---------------------------
//
// Create a thread, post a reply or edit a post
//
// Author: Fredrik Larsson
// Created: 2010
//
// ------------------------

// ------------------------
// Check if access allowed
//


if (empty($indexVisited) || !isset ($_SESSION['userid'])) {
  die('Här får du inte vara');
}

// -------------------------
// Setup db conn
//
$db = new CDatabaseController();


// Declare some variables

$topic = "";
$content = "<p></p>";
$reason = "";

// Handle $_GET
$pid = (empty ($_GET['pid'])) ? 0 : (is_numeric($_GET['pid'])) ? $_GET['pid'] : 0; //post_id
$tid = (empty ($_GET['tid'])) ? 0 : (is_numeric($_GET['tid'])) ? $_GET['tid'] : 0; //thread_id
$rid = (empty ($_GET['rid'])) ? 0 : (is_numeric($_GET['rid'])) ? $_GET['rid'] : 0; //Reply to post_id
$mysqli = $db->connect();
if ($_GET['p'] == 'post' && ($pid || $rid)) {
  $res = $db->call("{$SPDisplayThreadPost}", "{$pid}");
  $allowEdit = $db->checkAccess($FCheckAuthorOrAdmin, $pid, $_SESSION['userid']);
  if ($res->num_rows == 1 && $allowEdit ) {
    $row = $res->fetch_object();
    $topic = $row->post_topic;
    $content = $row->post_content;
    $reason = $row->post_modified_reason;
    $tid = $row->post_thread_id;
  } elseif ($rid) {
    $resReply = $db->call("$SPDisplayThreadPost", "$rid");
     if ($resReply->num_rows == 1) {
       $rowReply = $resReply->fetch_object();
       $topic = (substr($rowReply->post_topic, 0, 3) == 'Sv:') ? $rowReply->post_topic : "Sv: " . $rowReply->post_topic;
       $content = "<blockquote>{$rowReply->post_content}</blockquote>";
     }
  }
} elseif ($tid) {
  $res = $db->query("SELECT thread_topic FROM {$tableThreads} WHERE thread_id = {$tid}");
  if ($res->num_rows == 1) {
    $topic = $res->fetch_object()->thread_topic;
  }
}


$content = htmlspecialchars($content);
$html = <<<EOD
  <form action='?m=atuin&amp;p=postp' method='post' id="postform" name="postform">
    <p><label for='topic'>Rubrik:</label><input type="text" value="{$topic}" name="topic" id="topic"></p>
    <p><label for="content">Text:</label><textarea rows="8" cols="50" name="content" id="content">{$content}</textarea></p>
EOD;
$html .= ($pid == 0) ? "\n" : "    <p><label for='reason'>Orsak till ändring:</label><input type='text' value='{$reason}' name='reason' id='reason'></p>\n";
$html .= <<<EOD
    <p><input type="hidden" value="{$pid}" name="pid" id="pid">
    <input type="hidden" value="{$tid}" name="tid" id="tid">
    <input type="hidden" value="0" name="isdraft" id="isdraft">
    <input type="hidden" value="showthread&amp;tid=" name="redirect" id="redirect">
    <button type="submit" name="publish" id="publish">Publicera</button><button type="submit" name="save" id="save">Spara</button></p>
    <p><a id="published" href="?m=atuin&amp;p=showthread&amp;tid={$tid}#pid{$pid}">Gå till publiserad post</a></p>
  </form>
EOD;

//
// Include the rightside menu
//
include_once 'PSideBar.php';

//
// Create and print out the resulting page
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php');


$page = new CHTMLPage();

$page->printHTMLHeader("Uppdatera post", "yes", "yes");
$page->printPageHeader();
$page->setRightColumn($sidebar);
$page->printPageBody($html);
$page->printPageFooter();
?>