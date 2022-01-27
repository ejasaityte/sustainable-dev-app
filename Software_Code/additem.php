<?php
session_start();

if(!in_array($params['id'], $_SESSION['favouriteslist'])){
    array_push($_SESSION['favouriteslist'], $params['id']);
}
header('location: https://sustainabledundeeapp.azurewebsites.net/');
?>