<?php

namespace models\auth {
  import('/', 'helpers/db_connect');

  use database\newDb\Conn as Conn;

  class Model {
    private $conn;

    function __construct(){
      $this->conn = new Conn();
    }

    public function signIn(\stdClass $args){
      $res = $this->conn->query("SELECT * FROM mydb.user WHERE email = ? AND password = ? ", $args->email, $args->password);
      
      /**Do the logic here */
      return $res;
    }
  };
}
