<?php
session_start();
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
$conn->exec("SET time_zone = '+07:00'");

try {

    if ($table_name == 'transaksi') {

        $produk_id = $_POST['produk_id'];
        $qty = $_POST['qty'];

        $stmt = $conn->prepare("SELECT stok FROM produk WHERE id = ?");
        $stmt->execute([$produk_id]);
        $produk = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produk) {
            throw new PDOException("Produk tidak ditemukan.");
        }

        $stok_sekarang = $produk['stok'];

        if ($stok_sekarang < $qty) {
            $_SESSION['response'] = [
                'success' => false,
                'message' => "Stok tidak cukup! Sisa stok: $stok_sekarang"
            ];
            header('location: ' . $_SESSION['redirect_to']);
            exit;
        }

        $stok_baru = $stok_sekarang - $qty;

        $stmtUpdate = $conn->prepare("UPDATE produk SET stok = ?, diperbarui = NOW() WHERE id = ?");
        $stmtUpdate->execute([$stok_baru, $produk_id]);
    }

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
        'message' => "Gagal menambahkan data: " . $e->getMessage()
    ];

}

$_SESSION['response'] = $response;
header('location: ' . $_SESSION['redirect_to']);
