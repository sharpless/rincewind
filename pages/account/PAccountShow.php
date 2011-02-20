<?php
// ---------------------------
//
// Show user info
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
$mysqli = $db->connect();

// ------------------------
// Prepare query, execute and create HTML
//
$title = "Kontouppgifter";
$queryUser = <<<EOD
SELECT
  user_name,
  user_login,
  user_email
FROM {$tableUsers}
WHERE user_id = {$_SESSION['userid']};

EOD;

$queryGroup = <<<EOD
SELECT
  G.group_id,
  G.group_name
FROM {$tableGroupMember} AS GM
INNER JOIN {$tableGroups} AS G
ON GM.group_id = G.group_id
WHERE GM.member_id = {$_SESSION['userid']}
EOD;

$resUser = $db->query($queryUser);

$rowUser = $resUser->fetch_object();
$html = <<<EOD
  <h3>{$title}</h3>
  <form>
    <label for="name">Namn:</label><input type="text" readonly="readonly" value="{$rowUser->user_name}" id="name" /><br />
    <label for="login">Användarnamn:</label><input type="text" readonly="readonly" value="{$rowUser->user_login}" id="login" /><br />
    <label for="email">E-postadress:</label><input type="text" readonly="readonly" value="{$rowUser->user_email}" id="email" /><br />
EOD;
$resGroup = $db->query($queryGroup);
$i = 0;
while ($rowGroup = $resGroup->fetch_object()) {
  $i++;
  if ($resGroup->num_rows == 1) $i = '';
  $html .= <<<EOD
    <label for="idGroup{$i}">Grupp {$i}:</label><input type="text" readonly="readonly" value="{$rowGroup->group_id}" id="idGroup{$i}" /><br />
    <label for="nameGroup{$i}">Gruppbeskrivning {$i}:</label><input type="text" readonly="readonly" value="{$rowGroup->group_name}" id="nameGroup{$i}" /><br />
EOD;
}
$html .= "</form>\n";

//
// Create and print out the resulting page
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php');

$stylesheet = 'stylesheet.css';

$page = new CHTMLPage($stylesheet);

$page->printHTMLHeader($title);
$page->printPageHeader();
$sidebar = "<h2>Kontoinfo</h2><p>Här visas lite kontoinformation</p>";
$page->setRightColumn($sidebar);
$page->printPageBody($html);
$page->printPageFooter();
?>
