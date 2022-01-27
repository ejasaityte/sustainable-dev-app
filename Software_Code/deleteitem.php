<?php
session_start();

unset($_SESSION['favouriteslist'][$params['index']]);

header('location: https://sustainabledundeeapp.azurewebsites.net/favouriteslist');
?>