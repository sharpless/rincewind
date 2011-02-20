<?php
//----------------------------
//
// Page to process account creation
//
// Author: Fredrik Larsson
// Created: 2011-02-13
//
//----------------------------

// Set up database connection:

$db = new CDatabaseController();
$mysqli = $db->connect();

foreach ($_POST as $key => $value) {
  $$key = $value;
}
$redirect = 'createaccount';
if ($name && $login && $email && ($password == $password2) && $password) {
  $name = $db->real_escape_string($name);
  $login = $db->real_escape_string($login);
  $password = $db->real_escape_string($password);
  $email = $db->real_escape_string(trim(strtolower($email)));
  $queryCheckUsername = <<<EOD
  SELECT *
  FROM {$tableUsers}
  WHERE user_login = '{$login}'
EOD;
  $resCheckUsername = $db->query($queryCheckUsername);
  if ($resCheckUsername->num_rows == 0) {
    $res = $db->call($SPInsertOrUpdateUser, "0, '{$login}', '{$email}', '{$name}', '{$password}'");
    if ($res->num_rows == 1) {
      $_SESSION['accountMessage'] = 'Kontot har skapats, du kan nu logga in';
      $redirect = 'login';
    } else {
      $_SESSION['accountMessage'] = 'Ett okänt fel har uppstått, vänligen försök igen';
    }
  } else {
    $_SESSION['accountMessage'] = 'Användarnamnet finns redan';
  }
} else {
  $_SESSION['accountMessage'] = 'Nu blev nåt fel';
}
header("Location: " . WS_SITELINK . "?p={$redirect}");
