<?php
//
// PRestore.php
//
// Install database
// 
//
//

// Page title

$title = 'Installera databas';

//
// Page specific code
//

$html = <<<EOD
<article>
  <header>
    <h2>{$title}</h2>
  </header>
  <section>
    <h3>Val av installationstyp</h3>
    <p>Vill du att testdata ska installeras?</p>
    <form action="?p=installp" method="post">
      <label for="yes">Ja</label><input type="radio" value="yes" id="yes" name="data"><br>
      <label for="no">Nej</label><input type="radio" value="no" id="no" name="data" checked="checked"><br><br>
      <label for="submit">&nbsp;</label><input type="submit" id="submit" value="Installera">
    </form>
  </section>
</article>
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