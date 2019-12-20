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
