<?php
// ---------------------------
//
// Page to insert comments into database
//
// Author: Fredrik Larsson
// Created: 2010
//
// ------------------------

// ------------------------
// Create database connection
//

$db = new CDatabaseController();
$mysqli = $db->connect();

// ------------------------
//
//
if(!(empty ($_POST['title']) || empty ($_POST['content']) || empty ($_POST['author']))) {
  foreach ($_POST as $key => $value) {
    $$key = $value;
  }
  $_POST = array();
  $query = "INSERT INTO {$tableBlogComments}(comment_post_id, comment_title, comment_content, comment_author, comment_email, comment_date)  VALUES (?, ?, ?, ?, ?, NOW())";
  $db->stmt_input($query, array("issss", $id, htmlspecialchars($title), nl2br(htmlspecialchars($content)), htmlspecialchars($author), htmlspecialchars($email)));

}
$redirect = empty($redirect) ? 'home' : $redirect;
header("Location: ". WS_SITELINK . "?m=blog&p={$redirect}");
?>
