<?php

session_start();

// SET TIMEZONE PHP
date_default_timezone_set('Asia/Jakarta');

include('table_column.php');

$table_name = $_SESSION['table'];
$columns = $table_columns_mapping[$table_name];

$db_arr = [];
$user = $_SESSION['user'];

foreach($columns as $column){

    if (in_array($column, ['dibuat', 'diperbarui'])) {
        $value = date('Y-m-d H:i:s'); 
    }
    else if ($column == 'oleh') {
        $value = $user['id'];
    }
    else if ($column == 'password') {
        $value = password_hash($_POST[$column], PASSWORD_DEFAULT);
    }
    else if ($column == 'gambar'){
        $value = ""; 
        if (isset($_FILES[$column]) && $_FILES[$column]['error'] === UPLOAD_ERR_OK) {
            $file_data = $_FILES[$column];
            $tmp = $file_data['tmp_name'];
            $file_name = basename($file_data['name']);
            $target_dir = "image/";
            $target_file = $target_dir . $file_name;
            
            $check = @getimagesize($tmp);
            if ($check !== false) {
                if (move_uploaded_file($tmp, $target_file)) {
                    $value = $file_name;
                }
            }
        }
    }
    else if ($column == 'waktu_transaksi') {
        $value = date('Y-m-d H:i:s'); 
        }
        else {
            $value = isset($_POST[$column]) ? $_POST[$column] : '';
        }

        $db_arr[$column] = $value;
    }

$table_properties = implode(", ", array_keys($db_arr));
$table_placeholders = ':' . implode(", :", array_keys($db_arr));

include('koneksi.php');

// Set MySQL timezone WIB
$conn->exec("SET time_zone = '+07:00'");

try {
    $sql = "INSERT INTO $table_name ($table_properties) VALUES ($table_placeholders)";
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
