<?php
//
// PHome.php
//
// Introductory page for the Rate My Teacher application
// Text borrowed from Mikael Roos
//
//

// Page title

$title = 'Skapa ett konto';

//
// Page specific code
//
$message = '';
if (isset ($_SESSION['accountMessage'])) {
  $message = "  <h3>Fel!</h3>\n  <p>{$_SESSION['accountMessage']}</p>\n";
  unset ($_SESSION['accountMessage']);
}
$html = <<<EOD
  <header>
    <h2>{$title}</h2>
  </header>
  <section>
    {$message}
    <h3>Kontouppgifter</h3>
    <fieldset>
      <form action="?p=createaccountp" method="post">
          <label for="name">Namn:</label><input type="text" name="name" id="name" required placeholder="Namn"><br>
          <label for="login">Användarnamn:</label><input type="text" name="login" id="login" required placeholder="Användarnamn"><br>
          <label for="email">E-postadress:</label><input type="email" name="email" id="email" required placeholder="email@example.com"><br>
          <label for="password">Lösenord:</label><input type="password" name="password" id="password" required placeholder="Lösenord"><br>
          <label for="password">Upprepa lösenord:</label><input type="password" name="password2" id="password2" required placeholder="Lösenordet igen"><br>
          <input type="submit" value="Skapa konto"> <button onclick="history.go(-1)">Avbryt</button>
      </form>
    </fieldset>
  </section>
EOD;


//
// Create and print out the resulting page
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php');

$page = new CHTMLPage();

$page->printHTMLHeader($title);
$sidebar = "<h2>Skapa konto</h2><p>Till vänster</p>";
$page->setRightColumn($sidebar);
$page->printPageHeader();
$page->printPageBody($html);
$page->printPageFooter();


?>