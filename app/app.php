<?php
use Slim\Factory\AppFactory;



//requires
require_once __DIR__ . "/helpers/path_helpers.php";
require_once __DIR__ . "/controllers/BotController.php";
require_once join_paths(path, "middlewares", "cors.php");
require_once join_paths(path, "../", "config.php");


$app = AppFactory::create();


$app->setBasePath(DIRECTORY_NAME);

//Add cors
$app->options('/{routes:.+}', $cors->options);
$app->add($cors->add);



$app->get('/hello/{name}', $controller->oi);
$app->post('/oi', $controller->tutorial_pt1);



/**
 * Retorna "Página não encontrada"
 */
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    echo "Pagina não encontrada";
    // Melhorar a resposta!
    return;
});


$app->run();