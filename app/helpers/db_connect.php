<?php

class Conn {
    private $conn;

    public function __construct(){
        $this->conn = new mysqli(servername, username, password, dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    }

    /**
     * @param query Sql query, com ?
     * @param args Variaveis para substituir o ? em uma array
     * @return response return the sql response
     */
    public function query($query, ...$args){
        $all_input_types = "";

        foreach ($args as $key => $value) {
            $type = "";

            if(gettype($value) == "integer")
                $type = "i";
            if(gettype($value) == "string")
                $type = "s";
            if(gettype($value) == "double")
                $type = "d";

            $all_input_types = $all_input_types . $type;
        }

        $statement = $this->conn->prepare($query);

        if($all_input_types != ""){
            $statement->bind_param($all_input_types, ...$args);
        }
        
        $statement->execute();

        $res = $statement->get_result();

        if($res === false){
            $id = mysqli_insert_id($this->conn);
            $statement->close();
            return ["insertion_id" => $id];
        }

        $row = $res->fetch_assoc();
        $result = [];

        if ($res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {
                array_push($result, $row);
            }
        }

        $statement->close();

        return $result;
    }

    //Not working
    public function insert($table, $args){
        $sql = "INSERT INTO `$table` (";
        $values = "VALUES (";
        $a = [];
        
        foreach ($args as $key => $value){
            $sql = $sql . '`' . $key . '`, ';
            $values = $values . '(?), ';
            array_push($a, $value);
        }
        
        $sql = substr($sql, 0, -2) . ") ";
        $values = substr($values, 0, -2) . ")";

        $sql = $sql . $values;

        return $this->intern_query($sql, ...$a);
    }
    
    public function close(){
        $this->conn->close();
    }
}


?>