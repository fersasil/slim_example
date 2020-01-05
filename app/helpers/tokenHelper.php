<?php

namespace helpers\token {
  require_once 'vendor/autoload.php';

  use ReallySimpleJWT\Token as Token_JWT;


  //Examplo de payload; Precisa passar os parametros com o nome abaixo
  //expirationTime é obrigatório
  // $payload = [
  //     'createdAt' => time(),
  //     'userId' => 1,
  //     'expirationTime' => time() + 1,
  //     'iss' => 'localhost'
  // ];

  class Token{

    public static function createCustomToken($payload){
      return Token_JWT::customPayload($payload, SECRET_JWT);
    }

    public static function getCustomTokenData($token){
      function customTokenValidation($token){
        return Token_JWT::validate($token, SECRET_JWT);
      }

      function getPayload($token){
        if (!customTokenValidation($token))
          return false;

        return (object) Token_JWT::getPayload($token, SECRET_JWT);
      }

      $payload = getPayload($token);

      if (!$payload) return false;

      $time = time();

      if ($time >= $payload->expirationTime)
        return false;

      return $payload;
    }


    public static function createToken($userId){
      return Token_JWT::create($userId, SECRET_JWT, time() + DEFAULT_EXPIRATION_JWT, DEFAULT_ISSUER_JWT);
    }

    public static function getData($token){
      $result = Token_JWT::validate($token, SECRET_JWT);

      if (!$result) return false;

      $payload = Token_JWT::getPayload($token, SECRET_JWT);

      $return = new \stdClass;

      $return->userId = $payload["user_id"];
      return $return;
    }
  }
}
