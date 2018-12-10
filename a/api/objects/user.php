<?php
class User{
 
    // konekcija s bazom podataka i ime tablice
    private $conn;
    private $table_name = "users";
 
    // svojstva objekta
    public $id;
    public $username;
    public $password;
    public $created;
 
    // konstruktor sa $db kao konekcija s bazom
    public function __construct($db){
        $this->conn = $db;
    }
    // registracija korisnika
    function signup(){
    
        if($this->isAlreadyExist()){
            return false;
        }
        // upit za unos podataka
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    username=:username, password=:password, created=:created";
    
        // spremi upit
        $stmt = $this->conn->prepare($query);
    
        // sklanjanje svih nedopustenih znakova
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // spajanje vrijednosti
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":created", $this->created);
    
        // izvrsi upit
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }
    
        return false;
        
    }
    // prijavi korisnika
    function login(){
        // izaberi sva polja
        $query = "SELECT
                    `id`, `username`, `password`, `created`
                FROM
                    " . $this->table_name . " 
                WHERE
                    username='".$this->username."' AND password='".$this->password."'";
        // pripremi upit
        $stmt = $this->conn->prepare($query);
        // izvrsi upit
        $stmt->execute();
        return $stmt;
    }
    function isAlreadyExist(){
        $query = "SELECT *
            FROM
                " . $this->table_name . " 
            WHERE
                username='".$this->username."'";
        // pripremi upit
        $stmt = $this->conn->prepare($query);
        // izvrsi upit
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}