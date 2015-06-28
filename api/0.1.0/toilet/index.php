<?php
require_once('../../../db/config.php');
require_once('../../../db/db.php');

mb_language('uni');
mb_internal_encoding('utf-8');
mb_http_input('auto');
mb_http_output('utf-8');

$type = "";
if(isset($_GET["type"])) {
  $type = $_GET["type"];
}

$dbh = connectDB();
$stmt = $dbh -> query("SET NAMES utf8;");
if ($type==="") {
   echo "null";
   $stmt = $dbh->prepare("SELECT * FROM hostdataes");
 } else if ($type==="all") {
   $stmt = $dbh->prepare("SELECT * FROM hostdataes left join users on hostdataes.user_id = users.user_id;");
} else {
  echo "asdkvlkalfas;";
}


$stmt->execute();
$toiletList = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  array_push($toiletList, array(
    'user_id' => $row['user_id'],
    'lati' => $row['lati'],
    'long' => $row['long'],
    'image_path' => $row['image_path'],
    'host_comment' => $row['host_comment'],
    'is_washlet' => $row['is_washlet'],
    'is_european' => $row['is_european'],
    'is_paper' => $row['is_paper'],
    'toilet_sex' => $row['toilet_sex'],
    'first_name' => $row['first_name'],
    'family_name' => $row['family_name'],
    'sex' => $row['sex']
  ));
}
$dbh = null;
header('Content_type: application/json');
echo json_encode($toiletList);
?>
