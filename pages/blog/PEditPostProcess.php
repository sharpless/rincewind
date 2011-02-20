<?php
//
// PEditPostProcess.php
//
// Process data from EditPost.php
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
  $query = "UPDATE {$tableBlogPosts} SET post_title = ?, post_content = ?, post_modified_date = NOW() WHERE post_id = ? AND post_author = {$_SESSION['userid']}";
  $stmt = $db->stmt_input($query, array("ssi", htmlentities($title), htmlentities($content), $id));
}
$redirect = empty($redirect) ? 'home' : $redirect;
header("Location: ". WS_SITELINK . "?m=blog&p={$redirect}{$id}");
?>
