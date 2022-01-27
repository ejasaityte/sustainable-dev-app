<?php
session_start();
session_unset();
session_destroy();
header('Location: https://sustainabledundeeapp.azurewebsites.net');
exit;
?>