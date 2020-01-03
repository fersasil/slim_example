<?php
use Slim\Factory\AppFactory;

require_once __DIR__ . "/helpers/path_helpers.php";
require_once join_paths(path, "middlewares", "cors.php");
require_once join_paths(path, "../", "config.php");

$add_routes = require_once(join_paths("routes", "routes.php"));

$app = AppFactory::create();


$app->setBasePath(DIRECTORY_NAME);

//Add cors
$app->options('/{routes:.+}', $cors->options);
$app->add($cors->add);

// requires routes 
$add_routes($app);


//TODO move it to a controller
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    echo "Pagina não encontrada";
    // TODO Melhorar a resposta!
    $response->withStatus(404);
    return $response;
});


$app->run();