<?php
class Database{
 
    // postavljanje podataka svoje baze
    private $host = "localhost";
    private $db_name = "id7830618_planiranjevjencanja";
    private $username = "id7830618_grupa10";
    private $password = "15261526";
    public $conn;
 
    // dobij vezu sa bazom
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>