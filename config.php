<?php

// Marque como DEV e preencha os dados de development
// Marque PROD e preencha os dados de produção  
$option = "DEV"; 

// nome da pasta no qual o projeto esta
// caso esteja na raiz, deixe em branco
// caso esteja em "/ika", escreve /ika
$dir_name = "";

//url dos sites que faram requisições
//para esse servidor. Ex: "*" todos
// Ex 2: "https://example.com"
$allow_origin_url = "*";

//Database name
$db_name = "mydb";

//Database user
$db_user = "root";

//Database user password
$db_password = "";

/*aqui são as urls de produção*/
$dir_name_prod = "ika";
$allow_origin_url_prod = "";
$db_name_prod = "";
$db_user_prod = "";
$db_password_prod = "";

if($option = "DEV"){
    define("DIRECTORY_NAME", $dir_name);
    define("ALLOW_ORIGIN", $allow_origin_url);
    define("DATABASE_NAME", $db_name);
    define("DATABASE_USER", $db_user);
    define("DATABASE_USER_PASSWORD", $db_password);
}
else{
    define("DIRECTORY_NAME", $dir_name_prod);
    define("ALLOW_ORIGIN", $allow_origin_url_prod);
    define("DATABASE_NAME", $db_name_prod);
    define("DATABASE_USER", $db_user_prod);
    define("DATABASE_USER_PASSWORD", $db_password_prod);
}