<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}

require_once('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $nama_depan = $_POST['nama_depan'];
    $nama_belakang = $_POST['nama_belakang'];
    $email = $_POST['email'];

    if (empty($nama_depan) || empty($nama_belakang) || empty($email)) {
        $_SESSION['response'] = [
            'message' => 'Semua field harus diisi!',
            'success' => false
        ];
        header('location: users_view.php');
        exit();
    }

    $stmt = $conn->prepare("UPDATE pengguna SET nama_depan = ?, nama_belakang = ?, email = ?, diperbarui = NOW() WHERE id = ?");
    $stmt->bindParam(1, $nama_depan, PDO::PARAM_STR);
    $stmt->bindParam(2, $nama_belakang, PDO::PARAM_STR);
    $stmt->bindParam(3, $email, PDO::PARAM_STR);
    $stmt->bindParam(4, $user_id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        $_SESSION['response'] = [
            'message' => 'Pengguna berhasil diperbarui!',
            'success' => true
        ];
    } else {
        $_SESSION['response'] = [
            'message' => 'Gagal memperbarui data',
            'success' => false
        ];
    }

    $conn = null;
    
    header('location: users_view.php');
    exit();
}
?>