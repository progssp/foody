<?php
/*
Project : Foodshala
Author : Shantanu Singh Parmar
*/

/*
This is database controller file to handle all the queries.
*/
class DatabaseControls {
    // variables for database
    private $host;
    private $user;
    private $password;
    private $database_name;
    private $connection;
    private $rset;

    public function __construct(){
        $this->host = "localhost";
        $this->user = "root";
        $this->password = "";
        $this->database_name = "foodshala_base";
        $this->connection = "";
        $this->rset = "";
    }

    // connect to database
    public function connect_to_database(){
        $this->connection = mysqli_connect(
            $this->host,
            $this->user,
            $this->password,
            $this->database_name
        );
    }

    
    // return the last id according to table and colun given
    public function getLastId($table_name, $col_name) : int {
        $lastid = 0;
        $this->connect_to_database();
        $this->rset = mysqli_query($this->connection,"select ".$col_name." from ".$table_name." order by ".$col_name);
        while($res = mysqli_fetch_assoc($this->rset)){
            $lastid = $res[$col_name];
        }
        $this->close_database_connection();
        return $lastid;
    }

    // dynamic insert query method
    public function run_insert_qry($qry) : Array{
        $ret_arr = [];
        $this->connect_to_database();
        $this->rset = mysqli_query($this->connection, $qry);
        
        if($this->rset){
            $ret_arr = array(
                "status"=>true,
                "msg"=>"success"
            );
        }
        else{
            $ret_arr = array(
                "status"=>false,
                "msg"=>"error"
            );
        }
        $this->close_database_connection();
        return $ret_arr;
    }

    // dynamic update query method
    public function run_update_qry($qry) : Array{
        $ret_arr = [];
        $this->connect_to_database();
        $this->rset = mysqli_query($this->connection, $qry);
        
        if($this->rset){
            $ret_arr = array(
                "status"=>true,
                "msg"=>"success"
            );
        }
        else{
            $ret_arr = array(
                "status"=>false,
                "msg"=>"error"
            );
        }
        $this->close_database_connection();
        return $ret_arr;
    }

    // dynamic select query for sinle row data return
    public function run_select_qry($qry) : Array{
        $ret_arr = [];
        $this->connect_to_database();
        $this->rset = mysqli_query($this->connection, $qry);
        $ret_data_arr = mysqli_fetch_assoc($this->rset);
        
        if(!empty($ret_data_arr)){
            $ret_arr = array(
                "status"=>true,
                "msg"=>"success",
                "extra_data"=>$ret_data_arr
            );
        }
        else{
            $ret_arr = array(
                "status"=>false,
                "msg"=>"Data not found"
            );
        }
        $this->close_database_connection();
        return $ret_arr;
    }

    // dynamic select query for multiple data return
    public function run_multi_data_select_qry($qry) : Array{
        $ret_arr = [];
        $this->connect_to_database();
        $this->rset = mysqli_query($this->connection, $qry);
        while($return_data = mysqli_fetch_assoc($this->rset)){
            $ret_data_arr[] = $return_data;
        }
        
        if(!empty($ret_data_arr)){
            $ret_arr = array(
                "status"=>true,
                "msg"=>"success",
                "extra_data"=>$ret_data_arr
            );
        }
        else{
            $ret_arr = array(
                "status"=>false,
                "msg"=>"no data found"
            );
        }
        $this->close_database_connection();
        return $ret_arr;
    }

    // closing connection to database to prevent connection pool
    public function close_database_connection(){
        if($this->connection){
            mysqli_close($this->connection);
        }
        else{
            return false;
        }
    }

    public function __destruct(){}
}
?>