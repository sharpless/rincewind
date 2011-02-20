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
if(!(empty ($_GET['id']) || empty ($_SESSION['userid']))) {
  $id = $_GET['id'];
  $queryPost = "DELETE FROM {$tableBlogPosts} WHERE post_id = {$id} AND post_author = {$_SESSION['userid']}";
  $queryComment = "DELETE FROM {$tableBlogComments} WHERE comment_post_id = {$id}";
  $db->query($queryComment);
  $db->query($queryPost);



  }

header("Location: ". WS_SITELINK);
?>
