<?php
//
// PSideBar.php
//
// Create sidebar menu
//
//
//

if (empty ($db)) {
  $db = new CDatabaseController();
$mysqli = $db->connect();
}
$newThreadLink = '';
$drafts = "";
if (isset ($_SESSION['username'])) {
  $newThreadLink =  "    <li><a href=\"?m=atuin&amp;p=post\">Skapa ny tråd</a></li>\n";
  $resDrafts = $db->call("{$SPDisplayDrafts}", $_SESSION['userid']);
  if ($resDrafts->num_rows > 0) {
    $drafts = <<<EOD
  <h3>Utkast</h3>
    <ul>

EOD;
    while ($row = $resDrafts->fetch_object()) {
      $drafts .= "      <li><a href='?m=atuin&amp;p=post&amp;pid={$row->post_id}'>{$row->post_topic}</a></li>\n";
    }
    $drafts .= "    </ul>\n";
  }
}
$sidebar = <<<EOD
  <h3>Administration</h3>
    <ul>
      {$newThreadLink}
      <li><a href="?m=atuin&amp;p=allthreads">Alla trådar</a></li>
    </ul>
  {$drafts}
  <h3>Senaste posterna</h3>
    <ul>
EOD;
$resPostList = $db->call("{$SPDisplayPostsList}", "");
if ($resPostList->num_rows > 0) {
  while ($row = $resPostList->fetch_object()) {
    $sidebar .= "      <li><a href='?m=atuin&amp;p=showthread&amp;tid={$row->post_thread_id}#pid{$row->post_id}'>{$row->post_topic}</a></li>\n";
  }
} else {
  $sidebar .= "      <li>Inga poster</li>\n";
}
$sidebar .= "    </ul>\n"
?>
