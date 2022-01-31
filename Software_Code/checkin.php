<?php
include("dbconnect.php");

$updateReq = "UPDATE users SET leaderboard = leaderboard + 1 WHERE userID = ".$params['userid'];
$updateRes =$db->query($updateReq);

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>