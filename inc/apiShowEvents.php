<?php
include("dbconnect.php");

$goalID = $params['goalID'];

$sql = "SELECT * FROM events WHERE goalID='". $goalID ."'";

$rows = array();
$result = $db->query($sql);
while ($row = $result->fetch_array()) {
    $rows[] = $row;
}
  foreach($rows as $row){
        echo $row;
  }
  
  header('Content-type: application/json');
  echo json_encode($rows);

php?>