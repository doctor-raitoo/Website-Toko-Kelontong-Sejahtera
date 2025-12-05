<?php

session_start();

include('table_column.php');

$table_name = $_SESSION['table'];
$columns = $table_columns_mapping[$table_name];

$db_arr = [];
$user = $_SESSION['user'];
foreach($columns as $column){
    if (in_array($column, ['dibuat', 'diperbarui'])) $value = date('Y-m-d H:i:s');
    else if ($column == 'oleh') $value = $user['id'];
    else if ($column == 'password') $value = password_hash($_POST[$column], PASSWORD_DEFAULT);
    else if ($column == 'gambar'){
        $target_dir = "image/";
        $file_data = $_FILES[$column];
        $check = getimagesize($file_data['tmp_name']);
    }
    else $value = isset($_POST[$column]) ? $_POST[$column] : '';

    $db_arr[$column] = $value;
}

$table_properties = implode(", ", array_keys($db_arr));
$table_placeholders = ':' . implode(", :", array_keys($db_arr));

//$nama_depan = $_POST['nama_depan'];
//$nama_belakang = $_POST['nama_belakang'];
//$email = $_POST['email'];
//$password = $_POST['password'];
//$encrypted = password_hash($password, PASSWORD_DEFAULT);

include('koneksi.php'); 

try {
    $sql = "INSERT INTO $table_name 
    ($table_properties)
    VALUES ($table_placeholders)";

    $stmt = $conn->prepare($sql);
    $stmt->execute($db_arr);

    $response = [
        'success' => true,
        'message' => " Berhasil ditambahkan."
    ];

} catch (PDOException $e) {
    $response = [
        'success' => false,
        'message' => "Gagal menambahkan pengguna: " . $e->getMessage()
    ];
}

$_SESSION['response'] = $response;
header('location: ' . $_SESSION['redirect_to']);
