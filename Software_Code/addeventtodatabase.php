<?php
include("dbconnect.php");

$updateReq = "INSERT INTO events (name, description, postcode, goalID, website, contacts) SELECT name, description, postcode, goalID, website, contacts FROM eventsholding WHERE id=".$params['id'];
$updateRes =$db->query($updateReq);

$updateReq = "DELETE FROM eventsholding WHERE id=".$params['id'];
$updateRes =$db->query($updateReq);
header('location: https://sustainabledundeeapp.azurewebsites.net/addevent');
?>