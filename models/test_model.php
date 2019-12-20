<?php
// namespace Model\Test;
require_once join_paths(path, "helpers", "db_connect.php");

class Test {
  
  public function __construct(){
    
  }

  public function add(){
    $db = new Conn();
    $params = [
      "nome_usuario" => "Dev",
      "password_usuario" => "1234",
      "email_usuario" => "as@a.com"
    ];

    $res = $db->query(
      "INSERT INTO `usuario` (`nome_usuario`, `senha_usuario`, `email_usuario`) VALUES ((?), (?), (?))",
      "Teste", "123", "g@g.com"
    );

    $res1 = $db->query("SELECT * FROM `usuario`");

    $res = array_merge($res, $res1);

    $db->close();

    return response()->json($res);

  }
}



















?>