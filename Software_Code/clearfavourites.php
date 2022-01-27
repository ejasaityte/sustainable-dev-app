<?php
session_start();
unset($_SESSION['favouriteslist']);
$_SESSION['favouriteslist'] = array();
header('location: https://sustainabledundeeapp.azurewebsites.net/favouriteslist');
?>