<?php
// ---------------------------
//
// Write a new post
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
$title = 'Nytt inlägg';
// -------------------------
// Setup db conn
//
//$db = new CDatabaseController();
//$db->connect();

//Create the form

$html = <<<EOD
  <h2>{$title}</h2>
  <form action="?m=blog&amp;p=newp" method="post" onsubmit="return validateForm();">
    <p><label for="title">Rubrik</label><input type="text" name="title" id="title" /></p>
    <p><label for="content">Text</label><textarea rows="8" cols="60" name="content" id="content"></textarea></p>
    <p><input type="hidden" value="post&amp;id=" name="redirect" />
    <input type="submit" value="Publicera" name="submit" /></p>
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
