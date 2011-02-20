<?php
// ----------------------------- 
//
// Class CHTMLPage
// Print predefined elements and output
//
// ------------------------------

class CHTMLPage {
  protected $meny;
  protected $css;
  protected $leftColumn;
  protected $rightColumn;
  protected $mainColumn;
// -----------------------------
//
// Constructor, destructor
	
  public function  __construct() {
    $this->css = $_SESSION['css'];
    $this->meny = unserialize(WS_MENU);
    $this->leftColumn = '';
    $this->rightColumn = '';
  }

  public function  __destruct() {
    ;
  }

// ---------------------------
//
// Create HTML header
//

  public function printHTMLHeader($title, $js = 'no', $autosave = 'no') {
    $site = WS_SITELINK;
    $HTMLHeader = <<< EOD
<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>{$title}</title>
  <link rel="stylesheet" href="{$this->css}" type="text/css" />
  <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
EOD;
    if ($js == 'yes') {
// This part is disabled due to incompability with autosave-script
/*    $HTMLHeader .= <<<EOD
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/loadeditor.js"></script>

EOD;
*/
    $HTMLHeader .= <<<EOD
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery.form-2.4.3.js"></script>

EOD;
    }
    if ($autosave == 'yes') {
      $HTMLHeader .= "<script type='text/javascript' src='js/autosave.js'></script>";
    }
    $HTMLHeader .= "</head>";
    echo $HTMLHeader;
  }

// -----------------------
//
// Create page header
//

  public function printPageHeader($header = WS_TITLE) {
    $htmlLoginMenu = $this->getLoginoutMenu();
    $meny = "";
    foreach ($this->meny as $text => $link) {
      $meny .= "<li><a href='{$link}'>{$text}</a></li>";
    }
    echo <<< EOD
<body>
{$htmlLoginMenu}
<header>
    <h1>{$header}</h1>
    <nav><ul>{$meny}</ul></nav>
</header>
EOD;

  }

// --------------------------------
//
// Create page footer and terminate HTML
//

  public function printPageFooter($footer = WS_FOOTER) {
    echo <<< EOD
  <footer>
    <p>{$footer}</p>
  </footer>
</body>
</html>
EOD;
  }

// ------------------------------
//
// Print page body
//

  public function printPageBody($aBody) {
    $html = "<div class='container'>\n";
    if (!empty ($this->leftColumn) || !empty ($this->rightColumn) ) {
      $colNr = 1;
      $colNr += empty ($this->leftColumn) ? 0 : 2;
      $colNr += empty ($this->rightColumn) ? 0 : 4;
      $colNr = ($colNr == 7) ? '' : $colNr;
      $html .= $this->leftColumn;
      $html .= "<article class='mainCol{$colNr}'>{$aBody}</article>\n";
      $html .= $this->rightColumn;
      
    } else {
      $html .= <<<EOD
        <article>
          {$aBody}
        </article>
        
EOD;
    }
    $html .= "</div>\n";
    $errorMessage = $this->getErrorMessage();
    echo <<< EOD
      {$errorMessage}
      {$html}
EOD;
  }

  public function getLoginoutMenu() {
    $html = "<nav class='login'>\n";
    if (empty ($_SESSION['username'])) {
      $html .= "  <div class='alignleft'><a href='?p=login'>Logga in</a></div>\n";
    } else {
      $html .= <<<EOD
      <div class='alignleft'>Du är inloggad som: <a href='?p=account'>{$_SESSION['username']}</a>
      | <a href='?p=logout'>Logga ut</a></div>
EOD;
    }
    $html .= "<div class='alignright'>" . $this->setCss() . "</div>";
    $html .= "</nav>\n";
    return $html;
  }

  public function getErrorMessage() {
    $html = '';
    if (isset ($_SESSION['errorMessage'])) {
      $html = "<article class='error'>\n  <p>{$_SESSION['errorMessage']}</p>\n</article>\n";
      unset ($_SESSION['errorMessage']);
    }
    return $html;
  }

  public function setLeftColumn($leftSide) {
    $this->leftColumn = <<<EOD
      <aside class='leftCol'>
        {$leftSide}
      </aside>

EOD;
  }

  public function setRightColumn($rightColumn) {
    $this->rightColumn = <<<EOD
      <aside class='rightCol'>
        {$rightColumn}
      </aside>

EOD;
  }

  public function setCss() {
    $site = WS_SITELINK;
    $classic = '';
    $modern = '';
    $id = isset ($_GET['id']) ? "&amp;id={$_GET['id']}" : '';
    if ($_SESSION['css'] == 'stylesheet/classic.css') {
      $classic = " selected='selected' ";
    } else {
      $modern = " selected='selected' ";
    }
      $html = <<<EOD
  <form action='?p=cssp' method='post'>
    <div>
      Stilmall:
      <select name='css'>
        <option value='classic'{$classic}>Klassisk</option>
        <option value='modern' {$modern}>Modern</option>
      </select>
      <input type='submit' name='submit' value='OK' />
      <input type='hidden' name='redirect' value='{$_SESSION['page']}{$id}' />
    </div>
  </form>
EOD;
    return $html;
  }
  public function setSideBar() {
    ;
  }
}
?>
