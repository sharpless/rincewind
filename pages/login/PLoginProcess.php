<?php
// ---------------------------
//
// Page to check credentials
//
// Author: Fredrik Larsson
// Created: 2010
//
// ------------------------

// ------------------------
// ---------------------------------------------------------------------
//
// Destroy the current session (logout user), if it exists, review the manual
// http://se.php.net/manual/en/function.session-destroy.php
//
if (empty($indexVisited)) {
  die('Här får du inte vara');
}
// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (isset($_COOKIE[session_name()])) {
  setcookie(session_name(), '', time()-42000, '/');
}

// Finally, destroy the session.
session_destroy();

session_start(); // Must call it since we destroyed it above.
session_regenerate_id(); // To avoid problems

$login = empty ($_POST['login']) ? '' : $_POST['login'];
$password = empty ($_POST['password']) ? '' : $_POST['password'];

$db = new CDatabaseController();
$mysqli = $db->connect();

$login = $db->real_escape_string($login);
$password = $db->real_escape_string($password);

$query = <<<EOD
SELECT user_id, user_login
FROM {$tableUsers}
WHERE user_login = '{$login}'
AND user_password = md5('{$password}');
EOD;

$resLogin = $db->query($query);
if ($resLogin->num_rows === 1) {
    $rowLogin = $resLogin->fetch_object();
    $_SESSION['userid'] = $rowLogin->user_id;
    $_SESSION['username'] = $rowLogin->user_login;
  } else {

    $_SESSION['errorMessage']    = "Inloggningen misslyckades";
    $_POST['redirect']           = 'login';
  }

$redirect = empty ($_POST['redirect']) ? 'home' : $_POST['redirect'];

header('Location: ' . WS_SITELINK . "?p={$redirect}");

?>
