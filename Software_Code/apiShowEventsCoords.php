<?php
include("dbconnect.php");

$sql = "SELECT * FROM events INNER JOIN coord ON events.postcode = coord.postcode;";

$rows = array();
$result = $db->query($sql);
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

  header('Content-type: application/json');
  echo json_encode($rows, true);

php?>