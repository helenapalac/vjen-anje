<?php
// nadodaj objekte i datoteke baze podataka


include_once '../config/database.php';
include_once '../objects/user.php';
 
// dobij vezu sa bazom podataka
$database = new Database();
$db = $database->getConnection();
 
// spremi objekt User
$user = new User($db);
// dopustanje korisniku da izabere svoje ime
$user->username = isset($_GET['username']) ? $_GET['username'] : die();
$user->password = isset($_GET['password']) ? $_GET['password'] : die();
// procitaj detalje korisnika koji se uredjuje
$stmt = $user->login();
if($stmt->rowCount() > 0){
    // dobij vraceni red
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // stvori niz
    $user_arr=array(
        "status" => true,
        "message" => "Uspjesno ste se ulogirali",
        "id" => $row['id'],
        "username" => $row['username']
    );
}
else{
    $user_arr=array(
        "status" => false,
        "message" => "Netocno korisnicko ime ili lozinka",
    );
}
// pravimo json format
print_r(json_encode($user_arr));
?>