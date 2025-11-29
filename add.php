<?php
session_start();

$table_name = $_SESSION['table'];
$nama_depan = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$email = $_POST['email'];
$password = $_POST['password'];
$encrypted = password_hash($password, PASSWORD_DEFAULT);

include('koneksi.php'); 

try {
    $query = "INSERT INTO $table_name 
    (nama_depan, nama_belakang, email, password, dibuat, diperbarui)
    VALUES (?, ?, ?, ?, NOW(), NOW())";

    $stmt = $conn->prepare($query);
    $stmt->execute([$nama_depan, $nama_belakang, $email, $encrypted]);

    $response = [
        'success' => true,
        'message' => "$nama_depan $nama_belakang Berhasil ditambahkan."
    ];

} catch (PDOException $e) {
    $response = [
        'success' => false,
        'message' => "Gagal menambahkan pengguna: " . $e->getMessage()
    ];
}

$_SESSION['response'] = $response;
header('location: users_add.php');
