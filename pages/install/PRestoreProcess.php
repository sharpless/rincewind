<?php
// -------------------------------------------------------------------------------------------
//
// PRestore.php
// Restore/install data
// Code by mos, heavily modified by Fredrik Larsson
//


// -------------------------------------------------------------------------------------------
//
// Page specific code
//


// -------------------------------------------------------------------------------------------
//
// Create a new database object.
//

if (empty($indexVisited)) {
  die('Här får du inte vara');
}
require_once('./config.php');

$data = (!empty ($_POST['data']) && $_POST['data'] == 'yes') ? 'yes' : 'no';


$db = new CDatabaseController();

// -------------------------------------------------------------------------------------------
//
// Prepare and perform a SQL query.
//
$mysqli = $db->connect();

require_once 'sql/SQLTables.php';
$db->mquery($queryTables);

require_once 'sql/SQLProcedures.php';
$db->mquery($queryProcedures);

if ($data == 'yes') {
  require_once 'sql/SQLData.php';
  $db->mquery($queryData);
}

header("Location: " . WS_SITELINK);
echo "<pre>$queryTables</pre>";
echo "<pre>$queryProcedures</pre>";
echo "<pre>$queryData</pre>";
?>
