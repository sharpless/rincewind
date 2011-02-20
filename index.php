<?php
// ---------------------------------
//
// index.php
//
// Frontpage controller
//
// Author: Fredrik Larsson
//


// Start session
session_name('sharpless');
session_start();

// Include file with common content

if (file_exists('./config.php')) {
  require_once './config.php';
} else if (file_exists('./config-template.php')) {
  require_once './config-template.php';
  $_GET['p'] = 'firstrun';
}



// Stylesheet

$_SESSION['css'] = (isset ($_SESSION['css'])) ? $_SESSION['css'] : WS_CSS;

// Set page
$indexVisited = TRUE;

// Save module info to simplify switch

$module = empty ($_GET['m']) ? '' : $_GET['m'];

// Save page info for various reasons

$_SESSION['page'] = empty ($_GET['p']) ? 'home' : $_GET['p'];

// Check which module to load

switch ($module) {
  case 'atuin':
    require_once './atuinPages.php';
    break;
  case 'blog':
    require_once './blogPages.php';
    break;
  default:
    require_once './commonPages.php';
    break;
}

?>
