<?php
include("dbconnect.php");

$updateReq = "DELETE FROM events WHERE id=".$params['id'];
$updateRes =$db->query($updateReq);

header('location: https://sustainabledundeeapp.azurewebsites.net/addevent');
?>