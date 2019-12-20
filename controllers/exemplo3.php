<?php

require_once join_paths(path, "models", "test_model.php");
// use Model\Test\ as Test;


$controller = new stdClass;


$controller->teste = function (){
    $testModel = new Test();
    $testModel::add();

    join_paths("oi", "oi");
};

return $controller;
