<?php
include("dbconnect.php");

$sql = "SELECT * FROM events";

$rows = array();
$result = $db->query($sql);
while ($row = $result->fetch_array()) {
    $rows[] = $row;
}
  foreach($rows as $row){
      if($row['goalID'] == '5'){
        echo $row;
    }
  }

  

  header('Content-type: application/json');
  echo json_encode($rows, true);

php?>