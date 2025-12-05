<?php
include('koneksi.php');

$data = $_POST;

$user_id = (int)$data['user_id'];
$nama_depan = $data['nama_depan'];
$nama_belakang = $data['nama_belakang'];

try {
    $query = "DELETE FROM pengguna WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    session_start();
    $_SESSION['response'] = [
        'success' => true,
        'message' => $nama_depan . ' ' . $nama_belakang . ' berhasil dihapus'
    ];

} catch (PDOException $e) {

    session_start();
    $_SESSION['response'] = [
        'success' => false,
        'message' => 'Gagal memproses permintaan anda'
    ];
}

header('Location: users_view.php');
exit;
?>
