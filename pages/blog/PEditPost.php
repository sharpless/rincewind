<?php
// ---------------------------
//
// Edit a post
//
// Author: Fredrik Larsson
// Created: 2010
//
// ------------------------

// ------------------------
// Check if access allowed
//


if (!$indexVisited) {
  die('Access not allowed');
}
if(!isset ($_SESSION['userid'])) {
  header("Location: ?m=blog&amp;p=home");
}

$title = "Uppdatera post";
// -------------------------
// Setup db conn
//
$db = new CDatabaseController();
$mysqli = $db->connect();

// Handle $_GET

if ($_GET['p'] == 'edit' && isset ($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT post_title, post_content FROM {$tableBlogPosts} WHERE post_id = {$id} AND post_author = {$_SESSION['userid']}";
  $res = $db->query($query);
  if ($res->num_rows === 1) {
    $row = $res->fetch_object();
    $title = $row->post_title;
    $content = $row->post_content;
  }
} else {
  header('Location: ?m=blog&amp;p=home');
  exit;
}


$content = htmlspecialchars($content);
$html = <<<EOD
  <h2>{$title}</h2>
  <form action="?m=blog&amp;p=editp" method="post" onsubmit="return validateForm();">
    <p><label for="title">Rubrik</label><input type="text" value="{$title}" name="title" id="title" /></p>
    <p><label for="content">Text</label><textarea rows="8" cols="60" name="content" id="content">{$content}</textarea></p>
    <p><input type="hidden" value="{$id}" name="id" />
      <input type="hidden" value="post&amp;id=" name="redirect" />
      <input type="submit" value="Uppdatera" name="submit" /></p>
  </form>
EOD;

//
// Create and print out the resulting page
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php');


$page = new CHTMLPage();

$page->printHTMLHeader($title, 'yes');
$page->printPageHeader();
$page->printPageBody($html);
$page->printPageFooter();
?>
