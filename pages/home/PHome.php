<?php
//
// PHome.php
//
// Introductory page for the Rate My Teacher application
// Text borrowed from Mikael Roos
//
//

// Page title
if (empty($indexVisited)) {
  die('Här får du inte vara');
}
$title = "Rincewind";

//
// Page specific code
//

$html = <<<EOD
  <h2>{$title}</h2>
  <p>Rincewind är en grund till ett innehållshanteringssystem. Det innehåller
  för närvarande en bloggmodul och en forummodul. Forummodulen innehåller en
  funktion för att automatiskt spara utkast när man skriver ett inlägg. Denna
  funktionalitet är dock inte implemenerad i bloggen ännu.<br>
  Rincewind är skrivet i PHP och MySQL, och sidorna följer utkasten till HTML5-
  och CSS3-standarderna. Vissa saker validerar dock inte, främst CSS-kod för
  runda hörn, men även för specialkod för att styla vissa länkar.<br>
  Sidan är främst utvecklad för Mozilla Firefox 4, och kan på grund av detta
  innehålla felaktigheter i andra versioner och program.</p>
  <p>Källkoden för Rincewind finns tillgänglig via <a href="http://www.student.bth.se/~frle09/dbwebb2/kmom08/rincewind.zip">
  min sida på BTH</a> eller <a href="https://github.com/sharpless/rincewind">
  på GitHub</a>
EOD;

$sidebar = <<< EOD
  <ul>
    <li><a href="?m=atuin">Visa forum</a></li>
    <li><a href="?m=blog">Visa blogg</a></li>
  </ul>
EOD;


//
// Create and print out the resulting page
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php');

$page = new CHTMLPage();

$page->printHTMLHeader($title);
$page->printPageHeader();
//include_once TP_PAGESPATH . 'atuin/PSideBar.php';
$page->setRightColumn($sidebar);
$page->printPageBody($html);
$page->printPageFooter();


?>
