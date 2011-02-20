<?php
// -----------------------------
//
// Class CDatabaseController
// Handle database connections
//
// ------------------------------
/**
* Code from http://www.aplweb.co.uk/blog/php/mysqli-wrapper-class/
* Make an array of references to the values of another array
* Note: useful when references rather than values are required
* @param {array} array of values
* @return {array} references array
*/
function makeRefArr(&$arr) {
  $refs = array();
  foreach($arr as $key => &$val) {
    $refs[$key] = &$val;
  }
  return $refs;
}
class CDatabaseController {

  private $iMysqli;


  public function __construct($db = DB_DATABASE) {
    $this->iMysqli = FALSE;
  }

  public function __destruct() {
    ;
  }
  
  public function connect($db = DB_DATABASE) {
    $this->iMysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, $db);
    $this->iMysqli->set_charset('utf8');
    if (mysqli_connect_error()) {
      echo "Connect failed: ".mysqli_connect_error()."<br>";
      exit();
    }
    return $this->iMysqli;
  }

  public function real_escape_string($aString) {
    return $this->iMysqli->real_escape_string($aString);
  }


  public function query($aQuery) {
    $res = $this->iMysqli->query($aQuery) or die("<pre>Query failed:\n{$aQuery}\n gave the following error {$this->iMysqli->error}</pre>");
    return $res;
  }

  public function mquery($aMQuery) {
    if ($this->iMysqli->multi_query($aMQuery)) {
      if ($this->iMysqli->more_results())
      do {
        $res[] = $this->iMysqli->store_result();
        !$this->iMysqli->errno or die("<p>Failed retrieving resultsets.</p><p>Query =<br/><pre>{$aMQuery}</pre><br/>Error code: {$this->iMysqli->errno} ({$this->iMysqli->error})</p>");
        if (!$this->iMysqli->more_results()) break; //Fulhack
      } while ($this->iMysqli->next_result());
    } else {
      die("<p>Error: </p><p>Query =<br/><pre>{$aMQuery}</pre><br/>Error code: {$this->iMysqli->errno} ({$this->iMysqli->error})</p>");
    }
    return $res;
  }
  public function call($aStoredProcedure, $aParamsString = null) {
    $query = "CALL {$aStoredProcedure}({$aParamsString});";
    //var_dump($query);
    $res = $this->mquery($query);
    //var_dump($res); die;
    return $res[0];
  }
  public function checkAccess($aCheckFunction, $aPostId, $aUserId) {
    return $this->query("SELECT {$aCheckFunction}({$aPostId},{$aUserId}) AS c")->fetch_object()->c;
  }

  public function stmt_input($aQuery, $aStmtParam) {
    $stmt = $this->iMysqli->prepare($aQuery);
    $params = makeRefArr($aStmtParam);
    call_user_func_array(array($stmt, 'bind_param'), $params);
    if (!$stmt->execute()) {
      return null;
    } else {
      $stmt->store_result();
      return $stmt;
    }
  }

  public function updateData($aTable, $aColumn, $aData, $aConditions = 1) {
    $query = "UPDATE {$aTable} SET {$aColumn} = '{$aData}' WHERE {$aConditions}";
    $this->query($query);
  }
}

?>
