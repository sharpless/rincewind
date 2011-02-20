<?php
//
// PNewPostProcess.php
//
// Process data from PNewPost.php
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
if(!(empty ($_POST['title']) || empty ($_POST['content']))) {
  foreach ($_POST as $key => $value) {
    $$key = $value;
  }
  $_POST = array ();
  $id = NULL;
  $query = "INSERT INTO {$tableBlogPosts}( post_title, post_content, post_author, post_date, post_modified_date)  VALUES (?, ?, {$_SESSION['userid']}, NOW(), NOW())";
  $db->stmt_input($query, array("ss", $title, $content));
  $queryid = "SELECT MAX(post_id) AS p_id FROM {$tableBlogPosts} WHERE post_author = {$_SESSION['userid']}";
  $id = $mysqli->insert_id;
}
$redirect = empty($redirect) ? 'home' : $redirect;
header("Location: ". WS_SITELINK . "?m=blog&p={$redirect}{$id}");

?>
