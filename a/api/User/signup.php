<?php
 
// konekcija s bazom
include_once '../config/database.php';
 
// instanciraj objekt user
include_once '../objects/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
// postavi korisnicke vrijednosti
$user->username = $_POST['username'];
$user->password = $_POST['password'];
$user->created = date('Y-m-d H:i:s');
 
// stvri korisnika
if($user->signup()){
    $user_arr=array(
        "status" => true,
        "message" => "Uspjesno ste se registirali!",
        "id" => $user->id,
        "username" => $user->username
    );
}
else{
    $user_arr=array(
        "status" => false,
        "message" => "Korisnicko ime vec postoji!"
    );
}
print_r(json_encode($user_arr));
?>