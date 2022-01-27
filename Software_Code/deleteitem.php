<?php
session_start();

$key=array_search($_GET['id'],$_SESSION['favouriteslist']);
if($key!==false)
    unset($_SESSION['favouriteslist'][$key]);
$_SESSION["favouriteslist"] = array_values($_SESSION["favouriteslist"]);

header('location: https://sustainabledundeeapp.azurewebsites.net/favouriteslist');
?>