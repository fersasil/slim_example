<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

//requires
require_once __DIR__ . "/helpers/path_helpers.php";
require_once __DIR__ . "/controllers/BotController.php";


$app = AppFactory::create();

// TODO: Colocar um if se prod isso, e se não estiver na raiz
// $app->setBasePath('/my-slim-app');



$app->get('/hello/{name}', $controller->oi);

$app->run();