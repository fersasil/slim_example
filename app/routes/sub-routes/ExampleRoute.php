<?php

$controller = import_controller("Example");


$app->get('/hello/{name}', $controller->hello);
$app->post('/example-json', $controller->example_json);
