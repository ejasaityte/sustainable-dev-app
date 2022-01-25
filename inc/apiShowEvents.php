<?php
include("dbconnect.php");

$sql = "SELECT * FROM dundee";

$rows = array();
$result = $db->query($sql);
while ($row = $result->fetch_array()) {
    $rows[] = $row;
    echo $rows;
}

  header('Content-type: application/json');
  echo json_encode($rows, true);

php?>