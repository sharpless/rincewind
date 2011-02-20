<?php
//
// PSideBar.php
//
// Create sidebar menu
//
//
//

$sidebar = '';

if (isset($_SESSION['userid'])) {
  $sidebar .= <<<EOD
  <h3>Administration</h3>
  <ul><li><a href="?m=blog&amp;p=new">Nytt inlägg</a></li></ul>
EOD;
}

// Then the post part


if (empty ($db)) {
  $db = new CDatabaseController();
$mysqli = $db->connect();
}

$queryTitles = <<<EOD
SELECT post_id,
  post_title
FROM {$tableBlogPosts}
ORDER BY post_date DESC
LIMIT 10
EOD;

$resTitles = $db->query($queryTitles);
$sidebar .= <<<EOD
    <h3>Senaste inläggen</h3>
    <ul>
EOD;
while ($rowTitles = $resTitles->fetch_object()) {
  $sidebar .= "      <li><a href='?m=blog&amp;p=post&amp;id={$rowTitles->post_id}'>{$rowTitles->post_title}</a></li>\n";
}
$sidebar .= <<<EOD
    </ul>
EOD;
?>