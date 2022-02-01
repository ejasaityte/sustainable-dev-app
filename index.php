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
    'register' => "/register",
    'leaderboard' => "/leaderboard",
    'addfriend' => '/addfriend',
    'additem' => "/additem/(?'id'[\w\-]+)",
    'addevent' => '/addevent',
    'adduser' => "/adduser",
    'deleteitem' => "/deleteitem/(?'id'[\w\-]+)",
    'edititem' => "/edititem/(?'id'[\w\-]+)",
    'editlocation' => "/editlocation/(?'id'[\w\-]+)",
    'deleteevent' => "/deleteevent/(?'id'[\w\-]+)",
    'addeventtodatabase' => "/addeventtodatabase/(?'id'[\w\-]+)",
    'deleteeventfromholding' => "/deleteeventfromholding/(?'id'[\w\-]+)",
    'clearholdinglist' => "/clearholdinglist",
    'favouriteslist' => "/favouriteslist",
    'clearfavourites' => "/clearfavourites",
    'checkin' => "/checkin/(?'userid'[\w\-]+)",
    'logout' => "/logout",
    //
    // Home Page
    //
    'home' => "/",
    'goal' => "/goal/(?'goal'[\w\-]+)",
    'news' => "/news"
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
