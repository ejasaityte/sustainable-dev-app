<?php

define('INCLUDE_DIR', dirname(__FILE__) . '/Software_Code/');

$rules = array(
    //
    //API Routes
    'apiShowGoals' => "/api/allGoals",
    'apiShowSingleGoal' => "/api/singleGoal/(?'goalID'[\w\-]+)",
    'apiShowSingleEvent' => "/api/allEvents/(?'goalID'[\w\-]+)",
    'apiShowEventsFromGoal' => "/api/EventsFromGoal/(?'goalID'[\w\-]+)",
    'apiShowEvents' => "/api/allEvents",
    'apiShowEventsCoords' => "/api/allEventsCoords",
    'map' => "/map/(?'goalID'[\w\-]+)",



    //User Pages
    //
    'login' => "/login",
    'changepassword' => "/changepassword",
    'register' => "/register",
    'leaderboard' => "/leaderboard",
    'addfriend' => '/addfriend',
    'additem' => "/additem/(?'id'[\w\-]+)",
    'addevent' => '/addevent',
    'addtour' => '/addtour',
    'editlocation' => "/editlocation/(?'id'[\w\-]+)",
    'adduser' => "/adduser",
    'deleteitem' => "/deleteitem/(?'id'[\w\-]+)",
    'edititem' => "/edititem/(?'id'[\w\-]+)",
    'deleteevent' => "/deleteevent/(?'id'[\w\-]+)",
    'addeventtodatabase' => "/addeventtodatabase/(?'id'[\w\-]+)",
    'deleteeventfromholding' => "/deleteeventfromholding/(?'id'[\w\-]+)",
    'clearholdinglist' => "/clearholdinglist",
    'favouriteslist' => "/favouriteslist",
    'clearfavourites' => "/clearfavourites",
    'checkin' => "/checkin/(?'userid'[\w\-]+)",
    'logout' => "/logout",
    'tours' => "/tours",
    //
    // Home Page
    //
    'home' => "/",
    'goal' => "/goal/(?'goal'[\w\-]+)",
    'news' => "/news",
    'recycle' => "/recycle",
    'recycle_textile' => "/recycle/recycle_textile",
    'recycle_glass' => "/recycle/recycle_glass",
    'recycle_paper' => "/recycle/recycle_paper",
    'recycle_alum' => "/recycle/recycle_alum",
    'recycle_plastic' => "/recycle/recycle_plastic"


    //
    // Style
    //
);

$uri = rtrim(dirname($_SERVER["SCRIPT_NAME"]), '/');
$uri = '/' . trim(str_replace($uri, '', $_SERVER['REQUEST_URI']), '/');
$uri = urldecode($uri);

foreach ($rules as $action => $rule) {
    if (preg_match('~^' . $rule . '$~i', $uri, $params)) {
        include(INCLUDE_DIR . $action . '.php');
        exit();
    }
}

// nothing is found so handle the 404 error
include(INCLUDE_DIR . '404.php');

?>
