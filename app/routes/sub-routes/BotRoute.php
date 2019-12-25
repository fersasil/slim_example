<?php

$controller = import_controller("Bot");


$app->get('/hello/{name}', $controller->oi);
$app->post('/oi', $controller->tutorial_pt1);