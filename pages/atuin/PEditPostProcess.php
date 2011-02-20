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
//echo "hej";
if (empty($indexVisited) || !isset ($_SESSION['userid'])) {
  die('Här får du inte vara');
}
$db = new CDatabaseController();

// ------------------------
//
//
if(!(empty ($_POST['topic']) || empty ($_POST['content']))) {
  // Save everything in $_POST as separate variables
  foreach ($_POST as $key => $value) {
    $$key = $value;
  }
  $_POST = array ();
$mysqli = $db->connect();
  $reason = (empty ($reason)) ? "null" : "'{$db->real_escape_string($reason)}'";
  // strip_tags has a whitelist, entered as a string
  $allowedTags = "<h1>,<h2>,<h3>,<p>,<div>,<section>,<header>,<br>,<em>,<strong>,<span>,<ul>,<ol>,<li>,<blockquote>,<del>";
  $topic = $db->real_escape_string(strip_tags($topic, $allowedTags));
  $content = strip_tags($content, $allowedTags);
  $content = $db->real_escape_string($content);
  $pid = (is_numeric($pid)) ? $pid : 0; // If $pid is not a number, set $pid to 0 to create new page
  $tid = (is_numeric($tid)) ? $tid : 0; // If $tid is not a number, set $tid to 0 to create new thread
  $isdraft = (!isset ($publish)) ? 1 : 0;
  $res = $db->call($SPInsertOrUpdatePost, "{$pid}, {$_SESSION['userid']}, {$tid}, '{$topic}', '{$content}', {$isdraft}, {$reason} ");
  $row = $res->fetch_object();
  $pid = $row->aPostId;
  $tid = $row->aThreadId;
}
$redirect = empty($redirect) ? 'home' : $redirect.$tid;
//header("Location: ". WS_SITELINK . "?m=atuin&amp;p={$redirect}");
if ($isdraft) {
echo <<<EOD
{
  "tid": {$tid},
  "pid": {$pid}
}
EOD;
}
?>
