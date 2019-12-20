<?php
require __DIR__ . "/../" . "controllers/" . "teste.php";
require __DIR__ . "/../" . "controllers/" . "exemplo2.php";


use Pecee\SimpleRouter\SimpleRouter as Router;
use gui\oi\oi as oi;

//Exemplo 3
$controller = require __DIR__ . "/../" . "controllers/" . "exemplo3.php";

Router::get('/', $controller->teste);

// Example of a group
Router::group(['prefix' => '/api'], function () {
    Router::resource('/', 'ApiController');
});