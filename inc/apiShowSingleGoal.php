<?php
include("dbconnect.php");

$goalID = $params['goalID'];

$sql = "SELECT * FROM sustainablegoals WHERE goalID='". $goalID ."'";

$rows = array();
$result = $db->query($sql);
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

  header('Content-type: application/json');
  echo json_encode($rows, true);


php?>