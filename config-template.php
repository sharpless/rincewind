<?php
// ==================================================================
// User Settings -- CHANGE HERE
//
// On ssh.student.bth.se, protect the password in this file by
// executing the following command (in the same directory as the file)
//
//  sudo chgrp_www-data
//
// ----------------------
// Global db-config, rembember to change relative path
// Contains DB_USER, DB_PASSWORD, DB_DATABASE and DB_HOST
require_once 'src/CDatabaseController.php';

//
// The following supports having many databases in one database by using table/view prefix.
//
define('DB_HOST', 'server'); // The database host
define('DB_USER', 'username'); // The username of the database
define('DB_PASSWORD', 'password'); // The users password
define('DB_DATABASE', 'database'); // The name of the database to use
define('DB_PREFIX',     'prefix');        // Prefix to use infront of tablename and views

// -------------------------------------------------------------------------------------------
//
// Settings for this website (WS), used as default values in CHTMPLPage.php
//
define('WS_TITLE', 'Some page');    // The H1 label of this site.
define('WS_CSS', 'stylesheet/classic.css');            // Default stylesheet of the site.
define('WS_FOOTER', '<a href="http://validator.w3.org/check/referer">HTML</a> <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>');    // Footer at the end of the page.

//
// Dynamically create serverpath
//

$server = "http";
$server .= (@$_SERVER["HTTPS"] == "on") ? 's' : '';
$server .= "://{$_SERVER['SERVER_NAME']}";
$server .= ($_SERVER["SERVER_PORT"] == "80") ? '' : (($_SERVER["SERVER_PORT"] == 443 && @$_SERVER["HTTPS"] == "on") ? '' : ":{$_SERVER['SERVER_PORT']}");
$script = explode("/", $_SERVER['SCRIPT_NAME']);
array_pop($script);
$path = implode("/", $script);
$server .= $path;
define('WS_SITELINK', $server);

//
// Define the menu-array, slight workaround using serialize.
//
$meny = array (
        'Hem' => '?p=home',
        'Källa' => '?p=source',
        'Forum' => '?m=atuin',
        'Blog' => '?m=blog');
define('WS_MENU', serialize($meny));
// ------------------------------------------------------------------------
//
// Settings for the template (TP) structure, where are everything?
//

// Classes, functions, code
define('TP_SOURCEPATH',   dirname(__FILE__) . '/src/');

// Pagecontrollers and modules
define('TP_PAGESPATH',    dirname(__FILE__) . '/pages/');

$tableUsers = DB_PREFIX . 'users';
$tableThreadPosts = DB_PREFIX . 'thread_posts';
$tableGroups = DB_PREFIX . 'groups';
$tableGroupMember = DB_PREFIX . 'group_member';
$tableThreads = DB_PREFIX . 'threads';
$tableBlogPosts = DB_PREFIX . 'blog_posts';
$tableBlogComments = DB_PREFIX . 'blog_comments';
$SPInsertOrUpdateUser = DB_PREFIX . 'SPInsertOrUpdateUser';
$SPInsertOrUpdatePost = DB_PREFIX . 'SPInsertOrUpdatePost';
$SPDisplayThreadsList = DB_PREFIX . 'SPDisplayThreadsList';
$SPDisplayThreadPost = DB_PREFIX . 'SPDisplayPost';
$SPDisplayPostsList = DB_PREFIX . 'SPDisplayPostsList';
$SPDisplayThread = DB_PREFIX . 'SPDisplayThread';
$SPDisplayDrafts = DB_PREFIX . 'SPDisplayDrafts';
$FCheckAuthorOrAdmin = DB_PREFIX . 'FCheckAuthorOrAdmin';