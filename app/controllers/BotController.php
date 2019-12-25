<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once join_paths(path, "helpers", "Bot.php");


$controller = new stdClass;

$controller->oi = function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
};

$controller->tutorial_pt1 = function (){
    $email = input('email', null, 'post');
    $password = input('password', null, 'post');
    $server_number = input('server_number', null, 'post');
    $proxy = input('proxy', null, 'post');

    try {
        $bot = new Bot($email, $password, $server_number);

        $bot->build_barrack();
        $bot->assign_saw_mill_workers();
        $bot->build_academy();
        $bot->build_wareahouse();
        $bot->build_wall();
        $bot->build_port();

        return response()->json([
            'ok' => "Tutorial was made",
            'code'  => "TEST",
        ]);
    } catch (\Throwable $th) {
        return response()->json([
            'ok' => "ERROR",
            'code'  => "TEST",
            'error' => $th
        ]);
    }
};

$controller->tutorial_pt2 = function (){
    $email = input('email', null, 'post');
    $password = input('password', null, 'post');
    $server_number = input('server_number', null, 'post');
    $proxy = input('proxy', null, 'post');

    try {
        $bot = new Bot($email, $password, $server_number);
        $bot->build_boat();
        $bot->upgrade_wareahouse();
        $bot->attack_barbarians_and_plus();

        return response()->json([
            'ok' => "Tutorial was made",
            'code'  => "TEST",
        ]);
    } catch (\Throwable $th) {
        return response()->json([
            'ok' => "ERROR",
            'code'  => "TEST",
            'error' => $th
        ]);
    }
};


return $controller;
