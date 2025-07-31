<?php

class CreateDb{
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $tablename;
    public $con;

    // Class constructor with your InfinityFree details
    public function __construct($dbname = "if0_39606139_sugah", $tablename = "Products", $servername = "sql210.infinityfree.com", $username = "if0_39606139", $password = "Edith283"){
        $this->dbname = $dbname;
        $this->tablename = $tablename;
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;

        // Create connection
        $this->con = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if(!$this->con){
            die("Connection failed: " . mysqli_connect_error());
        }

        // Set charset to utf8mb4 for better character support
        mysqli_set_charset($this->con, "utf8mb4");

        // Create Products table if it doesn't exist
        $sql = "CREATE TABLE IF NOT EXISTS $tablename (
            id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            product_name VARCHAR(100) NOT NULL,
            product_desc VARCHAR(200),
            product_price DECIMAL(10,2) NOT NULL,
            product_image VARCHAR(150),
            product_type VARCHAR(50),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        if(!mysqli_query($this->con, $sql)){
            echo "Error creating Products table: " . mysqli_error($this->con);
        }

        // Create other necessary tables
        $this->createOtherTables();
    }

    // Create additional tables needed by your application
    private function createOtherTables() {
        // Create signup table with secure password storage
        $signup_sql = "CREATE TABLE IF NOT EXISTS signup (
            id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(150) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            phone VARCHAR(20),
            address TEXT,
            custid INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        mysqli_query($this->con, $signup_sql);

        // Create cart table
        $cart_sql = "CREATE TABLE IF NOT EXISTS cart (
            id INT(11) NOT NULL PRIMARY KEY,
            cart_name VARCHAR(100) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            qty INT DEFAULT 1,
            session_id VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        mysqli_query($this->con, $cart_sql);

        // Create orders table
        $orders_sql = "CREATE TABLE IF NOT EXISTS orders (
            id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            item VARCHAR(100) NOT NULL,
            qty INT NOT NULL,
            custid INT,
            total_cost DECIMAL(10,2),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        mysqli_query($this->con, $orders_sql);
    }

    // Get all products
    public function getData(){
        $sql = "SELECT * FROM $this->tablename ORDER BY created_at DESC";
        $result = mysqli_query($this->con, $sql);
        
        if(mysqli_num_rows($result) > 0){
            return $result;
        }
        return false;
    }

    // Get cupcakes
    public function getDataCupcake(){
        $sql = "SELECT * FROM $this->tablename WHERE product_name LIKE '%cupcake%' OR product_type LIKE '%cupcake%' ORDER BY created_at DESC";
        $result = mysqli_query($this->con, $sql);
        
        if(mysqli_num_rows($result) > 0){
            return $result;
        }
        return false;
    }

    // Get cookies
    public function getDataCookie(){
        $sql = "SELECT * FROM $this->tablename WHERE product_name LIKE '%cookie%' OR product_type LIKE '%cookie%' ORDER BY created_at DESC";
        $result = mysqli_query($this->con, $sql);
        
        if(mysqli_num_rows($result) > 0){
            return $result;
        }
        return false;
    }

    // Get tea cakes
    public function getDataTeacake(){
        $sql = "SELECT * FROM $this->tablename WHERE product_name LIKE '%Tea%' OR product_type LIKE '%tea%' ORDER BY created_at DESC";
        $result = mysqli_query($this->con, $sql);
        
        if(mysqli_num_rows($result) > 0){
            return $result;
        }
        return false;
    }

    // Get cheesecakes
    public function getDataCheese(){
        $sql = "SELECT * FROM $this->tablename WHERE product_name LIKE '%Cheesecake%' OR product_type LIKE '%cheese%' ORDER BY created_at DESC";
        $result = mysqli_query($this->con, $sql);
        
        if(mysqli_num_rows($result) > 0){
            return $result;
        }
        return false;
    }

    // Helper method to escape strings (prevent SQL injection)
    public function escape($string) {
        return mysqli_real_escape_string($this->con, $string);
    }

    // Close connection
    public function closeConnection() {
        if($this->con) {
            mysqli_close($this->con);
        }
    }
}
?>