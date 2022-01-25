<?php
session_start();

if(!in_array($_GET['id'], $_SESSION['favouriteslist'])){
    array_push($_SESSION['favouriteslist'], $_GET['id']);
}
?>