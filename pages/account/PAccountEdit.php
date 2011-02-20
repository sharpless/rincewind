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
$title = "Ändra kontouppgifter";
$queryUser = <<<EOD
SELECT
  user_name,
  user_login,
  user_email
FROM {$tableUsers}
WHERE user_id = {$_SESSION['userid']};

EOD;


$resUser = $db->query($queryUser);

$rowUser = $resUser->fetch_object();
require_once TP_SOURCEPATH . 'FGravatar.php';
$gravatarUser = getGravatar($rowUser->user_email, true);
$html = <<<EOD
  <h2>{$title}</h2>
  <fieldset>
    <h3>Uppdatera namn</h3>
    <form action="?p=accounteditp" method="post">
      <label for="login">Användarnamn:</label><input type="text" readonly="readonly" value="{$rowUser->user_login}" id="login"><br>
      <label for="name">Namn:</label><input type="text" value="{$rowUser->user_name}" id="name" name="name" required placeholder="Ditt namn"><br>
      <label for="namesubmit">&nbsp;</label><input type="submit" value="Uppdatera namn" name="namesubmit" id="namesubmit">
    </form>
  </fieldset><br>
  <fieldset>
    <h3>Uppdatera lösenord</h3>
    <form action="?p=accounteditp" method="post">
      <label for="password">Lösenord:</label><input type="password" required id="password" name="password" required placeholder="Ditt lösenord"><br>
      <label for="password2">Lösenord igen:</label><input type="password" required id="password2" name="password2" required placeholder="Ditt lösenord igen"><br>
      <label for="passwordsubmit">&nbsp;</label><input type="submit" value="Uppdatera lösenord" name="passwordsubmit" id="passwordsubmit">
    </form>
  </fieldset><br>
  <fieldset>
    <h3>Uppdatera e-postadress</h3>
    <form action="?p=accounteditp" method="post">
      <label for="email">E-postadress:</label><input type="email" value="{$rowUser->user_email}" id="email" name="email" required placeholder="Din e-postadress"><br />
      <label for="emailsubmit">&nbsp;</label><input type="submit" value="Uppdatera e-post" name="emailsubmit" id="emailsubmit">
    </form>
  </fieldset><br>
  <fieldset>
   <h3>Gravatar<span class="alignright">{$gravatarUser}</span></h3>
    <p>Den här sidan använder Avatarer från <a href="http://www.gravatar.com">Gravatar</a>
    Vill du ha en egen bild, istället för den till höger, gå då till <a href="http://www.gravatar.com">Gravatar</a>
    och skapa ett konto.</p>
  </fieldset>
EOD;


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
