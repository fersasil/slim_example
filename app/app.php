<?php
use Slim\Factory\AppFactory;

//requires
require_once __DIR__ . "/helpers/path_helpers.php";
require_once __DIR__ . "/controllers/BotController.php";
require_once join_paths(path, "middlewares", "cors.php");


$app = AppFactory::create();

// TODO: Colocar um if se prod isso, e se não estiver na raiz
// $app->setBasePath('/my-slim-app');

//Add cors
$app->options('/{routes:.+}', $cors->options);
$app->add($cors->add);



$app->get('/hello/{name}', $controller->oi);



/**
 * Retorna "Página não encontrada"
 */
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    echo "Pagina não encontrada";
    // Melhorar a resposta!
    return;
});


$app->run();