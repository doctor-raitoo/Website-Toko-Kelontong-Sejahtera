<?php
include('koneksi.php');

session_start();

$id = (int)$_POST['id'];
$table = $_POST['table'];

try {
    $query = "DELETE FROM $table WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $_SESSION['response'] = [
        'success' => true,
        'message' => 'Data berhasil dihapus'
    ];

} catch (PDOException $e) {

    $_SESSION['response'] = [
        'success' => false,
        'message' => 'Gagal memproses permintaan anda'
    ];
}

$redirect = 'dashboard.php'; 

if ($table === 'produk') {
    $redirect = 'product_view.php';
} elseif ($table === 'pengguna') {
    $redirect = 'users_view.php';
} elseif ($table === 'transaksi') {
    $redirect = 'transaction_view.php';
}

header("Location: $redirect");
exit;

