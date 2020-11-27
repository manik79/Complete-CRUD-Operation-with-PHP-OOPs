<?php

class Database {
    private $db_host = "localhost";
    private $db_username = "root";
    private $db_password = "";
    private $db_name = "students";
    public $result = array();
    public  $mysqli = "";
    private $conn = false;

    public function __construct(){
        if(!$this->conn){
            $this->mysqli = new mysqli($this->db_host,$this->db_username,$this->db_password,$this->db_name);
            $this->conn = true;
        }
        if($this->mysqli->connect_error){
            $this->result = array_push($this->result, $this->mysqli->connect_error);
            return false;
        }else{
            return true;
        }
    }

    #Function to select value from Database
    public function select($table, $rows="*", $join=null, $where=null, $order=null, $limit=null){
        if($this->TableExists($table)){

            $sql = "SELECT $rows FROM $table";

            if($join != null){
                $sql .= " JOIN $join";
            }
            if($where != null){
                $sql .= " WHERE $where";
            }
            if($order != null){
                $sql .= " ORDER BY $order";
            }
            
            if($limit != null){
                $sql .= " LIMIT 0, $limit";
            }

            echo $sql;
            $query = $this->mysqli->query($sql);

            if($query){
                $this->result = $query->fetch_all(MYSQLI_ASSOC);
                return true;
            }else{
                array_push($this->result, $this->mysqli->error);
                return false;
            }

        }else{
            return false;
        }
    }

    public function sql($sql){
        $query = $this->mysqli->query($sql);

        if($query){
            $this->result = $query->fetch_all(MYSQLI_ASSOC);
            return true;
        }else{
            array_push($this->result, $this->mysqli->error);
            return false;
        }
    }
    #Function for insert value to Database
    public function insert($table, $val=array()){
        if($this->TableExists($table)){        
            $table_columns = implode(", ", array_keys($val));
            $table_values = implode("', '", $val);
            
            $sql = "INSERT INTO $table ($table_columns) VALUES ('$table_values')";
            if($this->mysqli->query($sql)){
                array_push($this->result, $this->mysqli->insert_id);
                return true;
            }else{
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        }else{
           return false; 
        }
    }

    #Function for update value to Database
    public function update($table, $val=array(), $where= null){
        if($this->TableExists($table)){

            $args = array();
            foreach($val as $key => $value){
                $args[] = "$key = '$value'";
            }

            $sql = "UPDATE $table SET " . implode(", ", $args);

            if($where != null){
                $sql .= " WHERE $where";
            }

            if($this->mysqli->query($sql)){
                array_push($this->result, $this->mysqli->affected_rows);
                return true;
            }else{
                array_push($this->result, $this->mysqli->error);
                return false;
            }

        }else{
            return false;
        }
    }

    #Function for delete value from Database
    public function delete($table, $where = null){
        if($this->TableExists($table)){
            $sql = "DELETE FROM $table ";

            if($where != null){
                $sql .= "WHERE $where";
            }
            if($this->mysqli->query($sql)){
                array_push($this->result, $this->mysqli->affected_rows);
                return true;
            }else{
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        }else{
            return false;
        }
    }

    // check table
    private function TableExists($table){
        $sql = "SHOW TABLES FROM $this->db_name LIKE '$table'";
        $tableInDb = $this->mysqli->query($sql);
        if($tableInDb->num_rows == 1){
            return true;
        }else{
            array_push($this->result, $table ." does not exists in this database ($this->db_name)");
            return false;
        }
    }

        // Get Result
        public function getResult(){
            $value = $this->result;
            $this->result = array();
            return $value;
        }

    public function __destruct(){
        if($this->conn){
            if($this->mysqli->close()){
                $this->conn = false;
                return true;
            }
        }else{
            return false;
        }
    }

}




 ?>