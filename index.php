<?php
require 'vendor/autoload.php';
use Pecee\SimpleRouter\SimpleRouter;

/* Load external routes file */
require_once 'helpers/path_helpers.php';
require_once join_paths(path, 'helpers', 'get_config.php');


require_once 'routes/routes.php';
require_once 'helpers/helpers.php';

/**
 * The default namespace for route-callbacks, so we don't have to specify it each time.
 * Can be overwritten by using the namespace config option on your routes.
 */

SimpleRouter::setDefaultNamespace('\Demo\Controllers');

// Start the routing
SimpleRouter::start();