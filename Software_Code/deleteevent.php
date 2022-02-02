<?php
include("dbconnect.php");

$updateReq = "SELECT postcode FROM events WHERE id=".$params['id'];

$rows = array();
$result = $db->query($updateReq);
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

foreach ($rows as $row)
{
    $updateReq = "DELETE FROM coord WHERE postcode='".$row['postcode']."'";
    $updateRes =$db->query($updateReq);
}

$updateReq = "DELETE FROM events WHERE id=".$params['id'];
$updateRes =$db->query($updateReq);

header('location: https://sustainabledundeeapp.azurewebsites.net');
?>