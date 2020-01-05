<?php

namespace models\auth {
  import('/', 'helpers/db_connect');

  use database\newDb\Conn as Conn;
    use stdClass;

class Model {
    private $conn;

    function __construct(){
      $this->conn = new Conn();
    }

    public function signIn(\stdClass $args){
      $dbResult = $this->conn->query("SELECT * FROM user WHERE email = ? AND password = ? ", $args->email, $args->password);
      

      if(!is_array($dbResult))
        return $dbResult;
      else if(count($dbResult) == 0){
        $res = new stdClass;
        $res->success = false;
        return $res; 
      }

      // dd($res);
      
      $res = new stdClass;
      $res->success = true;
      $res->data = $dbResult[0];
      /**Do the logic here */
      return $res;
    }

    public function signUp(\stdClass $args){
      $dbResult = $this->conn->query("INSERT INTO user (`email`, `password`) VALUES (?, ?)", $args->email, $args->password);
      
      if(!is_array($dbResult))
        return $dbResult;
      else if(count($dbResult) == 0){
        $res = new stdClass;
        $res->success = false;
        return $res; 
      }
      
      $res = new stdClass;
      $res->success = true;
      $res->data = new stdClass;
      $res->data->userId = $dbResult[0]->insertion_id;

    
      /**Do the logic here */
      return $res;
    }

  };
}
