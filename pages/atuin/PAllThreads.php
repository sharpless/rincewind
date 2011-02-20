<?php
//
// PAllThreads.php
//
// Show the topic of and a link to all threads
//
//

// Check if access is allowed

if (empty ($indexVisited)) {
  die('Här får du inte vara');
}


//
// Create a new database object.
//

$db = new CDatabaseController();

// Make sure to get the right post

/*if ($_GET['p'] != 'allthreads') {
  header("Location: ?m=atuin&amp;p=home");
  exit;
}*/
$mysqli = $db->connect();
$resThreads = $db->call($SPDisplayThreadsList);
$html = "<section class=\"threads\">\n";
if ($resThreads->num_rows == 0) {
  $html = "<p>Här var det tomt, var den första som skriver något</p>\n";
} else {
  $html .= <<< EOD
  <table class='tThreads'>
    <tr>
      <th class="threadcolumn">Tråd /<br> Skapare</th>
      <th class="postcolumn">Senaste inlägg</th>
    </tr>
EOD;
  while ($rowThread = $resThreads->fetch_object()) {
    $html .= <<<EOD
    <tr>
      <td class="threadcolumn">
        <a href='?m=atuin&amp;p=showthread&amp;tid={$rowThread->thread_id}'>{$rowThread->thread_topic}</a><br>
        <span class='author'>{$rowThread->user_name}</span>
      </td>
      <td class="postcolumn">
        
        <span class='time'>{$rowThread->latest}</span>
      </td>
    </tr>

EOD;
  }
  $html .= "  </table>\n";
}
$html .= "</section>\n";
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