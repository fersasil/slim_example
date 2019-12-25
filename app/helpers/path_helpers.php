<?php

// namespace helper\path_helper;

define('path', realpath(__DIR__ . "/.."));

function join_paths(... $paths){
    return preg_replace('~[/\\\\]+~', DIRECTORY_SEPARATOR, implode(DIRECTORY_SEPARATOR, $paths));
}

/**
 * @param receives an onject
 * @return vardump it and die 
 */
function dd($obj){
    var_dump($obj);
    die();
}
/**
 * @param folder_name String it can be the folder name ex: controller  
 * @param file_name String name of the file ex: testController
 * @return include_once include - return an include
 */
function import($folder_name, $file_name){
    // dd(join_paths(path, "../", "app", $folder_name, $file_name . "Controller.php"));
    return require_once(join_paths(path, "../", "app", $folder_name, $file_name . ".php"));
}

/**
 * @param $controller_name String name of the file ex: test
 * @return return an include controller
 */
function import_controller($controller){
    return import("controllers", $controller . "Controller");
}

/**
 * @param $route name of route
 * @return return an include model
 */
function import_route($app, $route_name){
    require_once path . "/routes/sub-routes/" . $route_name . "Route.php";
}

/**
 * @param $model_name String name of the file ex: test
 * @return return an include model
 */
function import_model($model_name){
    return import("models", $model_name . "Model");
}

/**
 * @param $helper_name String name of the file ex: test
 * @return return an include helper
 */
function import_helper($helper_name){
    return import("helpers", $helper_name . "Helper");
}