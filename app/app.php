<?php
use Slim\Factory\AppFactory;



//requires
require_once __DIR__ . "/helpers/path_helpers.php";
// require_once __DIR__ . "/controllers/BotController.php";
require_once join_paths(path, "middlewares", "cors.php");
require_once join_paths(path, "../", "config.php");
// requires routes 
$add_routes = require_once(join_paths("routes", "routes.php"));

$app = AppFactory::create();


$app->setBasePath(DIRECTORY_NAME);

//Add cors
$app->options('/{routes:.+}', $cors->options);
$app->add($cors->add);


// requires routes 
$add_routes($app);


//Retorna "Página não encontrada"
//TODO move it to a controller
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    echo "Pagina não encontrada";
    // TODO Melhorar a resposta!
    return;
});


$app->run();