<?php

class CreateDb{
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $tablename;
    public $con;


    //class constructor
    public function __construct($dbname = "Newdb",$tablename = "Productdb",$servername = "localhost",$username = "root",$password = ""){
        $this->$dbname = $dbname;
        $this->tablename = $tablename;
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;


        //create connection
        $this->con = mysqli_connect($servername, $username, $password);

        //check connection
        if(!$this->con){
            die("Connection failed:" .mysqli_connect_error());

        }


        //query
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

        //execute query
        if(mysqli_query($this->con, $sql)){
            $this->con = mysqli_connect($servername, $username, $password, $dbname);
             
            //sql to create new table
            $sql = "CREATE TABLE IF NOT EXISTS $tablename
            (id INT(11)NOT NULL AUTO_INCREMENT PRIMARY KEY,
            product_name VARCHAR(35) NOT NULL,
            product_desc VARCHAR(120),
            product_price FLOAT,
            product_image VARCHAR(100),
            product_type VARCHAR(30)
            );";


            if(!mysqli_query($this->con, $sql)){
                echo "Error creating table:".mysqli_error($this->con);

            }
            else{
                return false;
            }
        }
      
}
  // get product from the database
  public function getData(){
    $sql = "SELECT * FROM $this->tablename";

    $result = mysqli_query($this->con, $sql);

    if(mysqli_num_rows($result) > 0){
        return $result;
    }
   
}

  public function getDataCupcake(){
    $sql = "SELECT * FROM $this->tablename where product_name like '%cupcake%'";

    $result = mysqli_query($this->con, $sql);

    if(mysqli_num_rows($result) > 0){
        return $result;
    }
   
}
public function getDataCookie(){
    $sql = "SELECT * FROM $this->tablename where product_name like '%cookie%'";

    $result = mysqli_query($this->con, $sql);

    if(mysqli_num_rows($result) > 0){
        return $result;
    }
}
    public function getDataTeacake(){
        $sql = "SELECT * FROM $this->tablename where product_name like '%Tea%'";
    
        $result = mysqli_query($this->con, $sql);
    
        if(mysqli_num_rows($result) > 0){
            return $result;
        }
    }
        public function getDataCheese(){
            $sql = "SELECT * FROM $this->tablename where product_name like '%Cheesecake%'";
        
            $result = mysqli_query($this->con, $sql);
        
            if(mysqli_num_rows($result) > 0){
                return $result;
            }
        }
}