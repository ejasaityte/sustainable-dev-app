<?php
session_start();
echo "one";
$_SESSION['favouriteslist']=array_diff($_SESSION['favouriteslist'],$params['id']);
echo "one";
header('location: https://sustainabledundeeapp.azurewebsites.net/favouriteslist');
?>