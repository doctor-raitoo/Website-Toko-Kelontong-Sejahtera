<?php 
$server = "localhost";
$user = "root";
$pass = "";
$db = "stoks"; 

try {
    $conn = new PDO("mysql:host=$server;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SET timezone MySQL ke WIB
    $conn->exec("SET time_zone = '+07:00'");

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
