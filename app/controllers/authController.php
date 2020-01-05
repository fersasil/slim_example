<?php
import_model("auth");
import_helper("token");

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use models\auth as t;
use helpers\token\Token as Token;

$authModel = new models\auth\Model();



function getDataFromReq(Request $req){
  $json = $req->getBody();

  return (object) json_decode($json, true);
};

$controller = new stdClass;

$controller->signIn = function(Request $req, Response $res) use ($authModel){
  $data = getDataFromReq($req);
  
  //TODO: Verificar campos!


  $dbResult = $authModel->signIn($data);

  if($dbResult->success == false) {
    //return erro
    $res->withStatus(401)
        ->getBody()
        ->write(json_encode($dbResult));

    return $res;
  }

  $user = $dbResult->data;
  //Create JWT TOKEN AND RETURN SOME USER INFO
  $token = Token::createToken($user->userId);

  $user->token = $token;
  // unset($user->password);

  $res->withStatus(200)
        ->getBody()
        ->write(json_encode($user));

  return $res;
};

$controller->signUp = function(Request $req, Response $res) use ($authModel){
  $data = getDataFromReq($req);
  
  //TODO: Verificar campos!
  $dbResult = $authModel->signUp($data);

  if($dbResult->success == false) {
    //return erro
    $res->withStatus(401)
        ->getBody()
        ->write(json_encode($dbResult));

    return $res;
  }

  $user = $dbResult->data;

  //Create JWT TOKEN AND RETURN SOME USER INFO
  $token = Token::createToken($user->userId);

  $user->token = $token;
  $user->email = $data->email;

  // unset($user->password);

  $res->withStatus(200)
        ->getBody()
        ->write(json_encode($user));

  return $res;
};


return $controller;
