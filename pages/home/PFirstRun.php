<?php
//
// PFirstInstall.php
//
// Page for the first installation of the database
//
//
//

$title = 'Välkommen till Rincewind';

$html = <<< EOD
  <h2>{$title}</h2>
  <p>
    Detta meddelande visas endast om du inte har skapat filen config.php.<br>
    Denna måste skapas och konfigureras för att du ska kunna använda Rincewind.
    Gör du inte detta kommer inte Rincewind att fungera, och du kommer att få
    diverse felmeddelanden och konstiga beteenden.<br>
    För närvarande finns det tyvärr ingen funktion för att konfigurera och testa
    inställningarna via webbgränssnitt.<br>
    Följande steg rekommenderas för att få Rincewind att fungera:
    <ol>
      <li>Kopiera config-template.php till config.php</li>
      <li>Skapa databasen som du tänker använda, om den inte existerar</li>
      <li>Ändra DB_* till de inställningar som gäller för din installation</li>
      <li>Ändra WS_TITLE till vad du önskar</li>
      <li>När detta är klart, klicka <a href="?p=install">här</a> för att skapa
      tabeller och liknande</li>
  </p>
EOD;

//
// Create and print out the resulting page
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php');

$page = new CHTMLPage();

$page->printHTMLHeader($title);
$page->printPageHeader();
$page->printPageBody($html);
$page->printPageFooter();

?>
