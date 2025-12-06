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

header('Location: product_view.php');
exit;
