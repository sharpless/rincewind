<?php
// ---------------------------
//
// Show users
//
// Author: Fredrik Larsson
// Created: 2010
//
// ------------------------

// ------------------------
// Check if access allowed
//

if (empty ($indexVisited) || !isset ($_SESSION['userid']) || (array_search('adm', $_SESSION['groupid']) === FALSE)) {
  die('Här får du inte vara');
}

// -------------------------
// Setup db conn
//
$db = new CDatabaseController();

// ------------------------
// Prepare query, execute and create HTML
//

$html = <<<EOD
<table>
  <tr>
    <th>Id</th>
    <th>Kontonamn</th>
    <th>Användarnamn</th>
    <th>Gruppid</th>
    <th>Gruppbeskrivning</th>
  </tr>
EOD;

$query = <<<EOD
SELECT
  user_id,
  user_login,
  user_email
FROM {$tableUser}
EOD;
$res = $db->query($query);
//$res = $mysqli->query($query);

while ($row = $res->fetch_object()) {
  $grpQuery = <<<EOD
  SELECT
    group_id,
    group_name
  FROM {$tableGroupMember} AS GM
  INNER JOIN {$tableGroup} AS G
  ON GM.group_id = G.group_id
  WHERE GM.member_id = {$row->user_id}
EOD;

  $grpRes = $db->query($grpQuery);
  while ($grpRow = $grpRes->fetch_object()) {
    $grpId[] = $grpRow->group_id;
    $grpName[] = $grpRow->group_name;
  }
  $grpRes->close();
  
  $grpIdStr = implode(",<br />\n", $grpId);
  $grpNameStr = implode(",<br />\n", $grpName);
  $grpId = array ();
  $grpName = array ();
  
  $html .= <<<EOD
 <tr>
   <td>{$row->user_id}</td>
   <td>{$row->user_login}</td>
   <td>{$row->user_email}</td>
   <td>{$grpIdStr}</td>
   <td>{$grpNameStr}</td>
 </tr>
EOD;
}
$html .= "</table>";

//
// Create and print out the resulting page
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php');

$stylesheet = 'stylesheet.css';

$page = new CHTMLPage($stylesheet);

$page->printHTMLHeader("Användare");
$page->printPageHeader();
$page->printPageBody($html);
$page->printPageFooter();

?>
