<?php
session_start();
$_SESSION['favouriteslist']=array_diff($_SESSION['favouriteslist'],$params['id']);
header('location: https://sustainabledundeeapp.azurewebsites.net/favouriteslist');
?>