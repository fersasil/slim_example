<?php
import_model("auth");

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use models\auth as t;

$authModel = new models\auth\Model();



function getDataFromReq(Request $req){
  $json = $req->getBody();

  return (object) json_decode($json, true);
};

$controller = new stdClass;

$controller->signIn = function(Request $req, Response $res) use ($authModel){
  $data = getDataFromReq($req);
  
  $result = $authModel->signIn($data);



  $res->withStatus(400)
        ->getBody()
        ->write(json_encode($result));

  return $res;
};

$controller->signUp = function(Request $req, Response $res){

};


return $controller;
