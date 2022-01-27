<?php
include("dbconnect.php");

$sql = "TRUNCATE TABLE eventsholding";

$result = $db->query($sql);
header('location: https://sustainabledundeeapp.azurewebsites.net/addevent');
?>