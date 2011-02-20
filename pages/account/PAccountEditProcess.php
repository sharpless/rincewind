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
$redirect = 'account';
if (isset($_SESSION['userid'])) {
  if (isset($namesubmit) && isset ($name)) {
    $name = $db->real_escape_string($name);
    $db->updateData($tableUsers, 'user_name', $name, "user_id = {$_SESSION['userid']}");
  }
  if (isset ($emailsubmit) && isset ($email)) {
    $email = $db->real_escape_string($email);
    $db->updateData($tableUsers, 'user_email', $email, "user_id = {$_SESSION['userid']}");
  }
  if (isset($passwordsubmit) && isset ($password) && $password == $password2) {
    $password = $db->real_escape_string($password);
    $db->updateData($tableUsers, 'user_password', md5($password), "user_id = {$_SESSION['userid']}");
  }
} else {
  $redirect = 'home';
}
header("Location: " . WS_SITELINK . "?p={$redirect}");
