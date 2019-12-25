<?php
$config_files = file_get_contents(join_paths(path, "config.json"));
// Convert to array 

$db_options = json_decode($config_files, true);

if($db_options['mode'] == "dev"){
    $servername = $db_options["local_servername"];
    $username = $db_options["local_username"];
    $password = $db_options["local_password"];
    $dbname = $db_options["local_dbname"];
    
}
else{
    $servername = $db_options["server_servername"];
    $username = $db_options["server_username"];
    $password = $db_options["server_password"];
    $dbname = $db_options["server_dbname"];
}

define('servername', $servername);
define('username', $username);
define('password', $password);
define('dbname', $dbname);


?>