<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


$controller = new stdClass;

$controller->oi = function ($request, $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
};


$controller->tutorial_pt1 = function (Request $request, Response $response): Response{
    // Retrieve the JSON data
    $parameters = (array) $request->getParsedBody();
    
    $email = $parameters['email'];
    $password = $parameters['password'];
    $server_number = $parameters['server_number'];
    $proxy = $parameters['proxy'];

    if($email == NULL || $password == NULL || $server_number == NULL || $proxy == NULL){
        $response->withStatus(400)
            ->getBody()
            ->write("Input faltando");
        return $response;
    }
    // BAD REQUEST 400
    // ou 418 tea coffe

    try {
        $bot = new Bot($email, $password, $server_number);

        $bot->build_barrack();
        $bot->assign_saw_mill_workers();
        $bot->build_academy();
        $bot->build_wareahouse();
        $bot->build_wall();
        $bot->build_port();

        $response->getBody()->write(json_encode($parameters));
        return $response;        
    } catch (\Throwable $th) {
        $response->withStatus(500)
            ->getBody()
            ->write("Algum erro deve ter ocorrido");
        return $response;
    }

};

$controller->tutorial_pt2 = function (Request $request, Response $response): Response{
    // Retrieve the JSON data
    $parameters = (array) $request->getParsedBody();
    
    $email = $parameters['email'];
    $password = $parameters['password'];
    $server_number = $parameters['server_number'];
    $proxy = $parameters['proxy'];

    if($email == NULL || $password == NULL || $server_number == NULL || $proxy == NULL){
        $response->withStatus(400)
            ->getBody()
            ->write("Input faltando");
        return $response;
    }

    try {
        $bot = new Bot($email, $password, $server_number);
        $bot->build_boat();
        $bot->upgrade_wareahouse();
        $bot->attack_barbarians_and_plus();

        $response->getBody()->write(json_encode($parameters));
        return $response;

    } catch (\Throwable $th) {
        $response->withStatus(500)
            ->getBody()
            ->write("Algum erro deve ter ocorrido");
        return $response;
    }
};


return $controller;
