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



    //Admin Pages
    //
    'login' => "/login",
    'additem' => "/additem/(?'id'[\w\-]+)",
    'addevent' => '/addevent',
    'adduser' => "/adduser",
    'deleteitem' => "/deleteitem",
    'favouriteslist' => "/favouriteslist",
    'logout' => "/logout",
    //
    // Home Page
    //
    'home' => "/",
    'goal' => "/goal/(?'goal'[\w\-]+)"
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
