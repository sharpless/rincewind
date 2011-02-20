<?php
//
// PLogin.php
//
// Log in
//
//
if (empty ($indexVisited)) {
  die('Här får du inte vara');
}
if (empty($_SESSION['username'])) {

// Page title

  $title = 'Logga in';

//
// Page specific code
//
$message = '';
if (isset ($_SESSION['accountMessage'])) {
  $message = "  <h3>Konto skapat</h3>\n  <p>{$_SESSION['accountMessage']}</p>\n";
  unset ($_SESSION['accountMessage']);
}
if (isset ($_SESSION['errorMessage'])) {
  $message = "  <h3>Felaktig inloggning</h3>\n  <p>{$_SESSION['errorMessage']}</p>\n";
  unset ($_SESSION['errorMessage']);
}
  $html = <<<EOD
  <h2>Logga in</h2>
  {$message}
  <p>Ange användarnamn och lösenord:</p>
  <fieldset>
    <legend>Logga in</legend>
    <form action="?p=loginp" method="post">
      <div>
        <label for="login">Användarnamn:</label><input type="text" name="login" id="login" required placeholder="Användarnamn"><br>
        <label for="password">Lösenord:</label><input type="password" name="password" id="password" required placeholder="Lösenord"><br>
        <input type="submit" value="Logga in"> <button onclick="history.go(-1)">Avbryt</button>
      </div>
    </form>
  </fieldset>
  <p>Har du inget konto? Skapa ett nu.<br>
  <a href="?p=createaccount">Klicka här för att skapa ett konto</a></p>
EOD;
} else {
  $title = 'Logga in?';
  $html = <<<EOD
  <h2>Logga in?</h2>
  <p>Du är redan inloggad. Vill du logga in som någon annan? <a href="?p=logout">Logga ut</a> först!</p>
EOD;
}

//
// Create and print out the resulting page
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php');

$page = new CHTMLPage();

$page->printHTMLHeader($title);
$page->printPageHeader();
$sidebar = "<h2>Logga in</h2><p>Till vänster</p>";
$page->setRightColumn($sidebar);
$page->printPageBody($html);
$page->printPageFooter();


?>