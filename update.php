<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}

require_once('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_id     = $_POST['product_id'];
    $nama_produk    = $_POST['nama_produk'];
    $deskripsi      = $_POST['deskripsi'];
    $harga          = $_POST['harga'];
    $stok           = $_POST['stok'];

    $stmt_old = $conn->prepare("SELECT gambar FROM produk WHERE id = ?");
    $stmt_old->execute([$product_id]);
    $oldData  = $stmt_old->fetch(PDO::FETCH_ASSOC);
    $oldImage = $oldData['gambar'];

    if (!empty($_FILES['gambar']['name'])) {
        $newImage = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];

        move_uploaded_file($tmp, "image/" . $newImage);

        if (!empty($oldImage) && file_exists("image/" . $oldImage)) {
            unlink("image/" . $oldImage);
        }

    } else {
        $newImage = $oldImage;
    }

    $stmt = $conn->prepare("
        UPDATE produk 
        SET 
            nama_produk = ?, 
            deskripsi = ?, 
            harga = ?, 
            stok = ?, 
            gambar = ?, 
            diperbarui = NOW()
        WHERE id = ?
    ");

    if ($stmt->execute([$nama_produk, $deskripsi, $harga, $stok, $newImage, $product_id])) {
        $_SESSION['response'] = [
            'message' => 'Produk berhasil diperbarui!',
            'success' => true
        ];
    } else {
        $_SESSION['response'] = [
            'message' => 'Gagal memperbarui produk!',
            'success' => false
        ];
    }

    header('location: product_view.php');
    exit();
}
?>
