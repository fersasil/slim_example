<?php

$controller = new stdClass;

$controller->hello = function ($request, $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
};


$controller->example_json = function (Request $request, Response $response): Response{
    // Retrieve the JSON data
    $parameters = (array) $request->getParsedBody();
    
    $response->withStatus(400)
        ->getBody()
        ->write("Input faltando");
    
    return $response;

};

return $controller;
