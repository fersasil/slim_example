<?php

$app->get('/', function($req, $res){
    $res->getBody()->write("<h1>Hello</h1>");

    return $res;
});