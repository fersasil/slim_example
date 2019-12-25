<?php
use Pecee\SimpleRouter\SimpleRouter as Router;



// Dev route
// $route = '/ika_bot/api';

// Prod route
$route = "/api";

Router::group(['prefix' => $route], function () {
    $controller = require join_paths(path, "controllers","BotController.php");

    Router::post('/tutorial_pt1', $controller->tutorial_pt1);
    Router::post('/tutorial_pt2', $controller->tutorial_pt2);

    Router::get("/", function(){
        echo "Ola mundo";
    });
});