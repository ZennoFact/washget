<?php
require_once('../../../db/config.php');
require_once('../../../db/db.php');

$id = 0;
if(isset($_GET['id'])) {
  $id = $_GET['id'];
}

mb_language('uni');
mb_internal_encoding('utf-8');
mb_http_input('auto');
mb_http_output('utf-8');

$dbh = connectDB();
$stmt = $dbh -> query("SET NAMES utf8;");

if ($id === 0) {
  $stmt = $dbh->prepare("SELECT * FROM users");
} else {
  $stmt = $dbh->prepare("SELECT * FROM users where user_id = $id");
}
$stmt->execute();
$toiletList = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $toiletList[] = array(
    'user_id' => $row['user_id'],
    'first_name' => $row['first_name'],
    'family_name' => $row['family_name'],
    'sex' => $row['sex']
    );
}
$dbh = null;
header('Content_type: application/json');
echo json_encode($toiletList);
?>
