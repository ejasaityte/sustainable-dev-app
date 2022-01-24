<?php
include("dbconnect.php");

$dogID = $params['goalID'];

$sql = "SELECT * FROM sustainablegoals WHERE goalID='". $goalID ."'";

$rows = array();
$result = $db->query($sql);
while ($row = $result->fetch_array()) {
    $rows[] = $row;
}

  header('Content-type: application/json');
  echo json_encode($rows);


php?>