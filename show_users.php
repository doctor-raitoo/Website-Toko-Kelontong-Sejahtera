<?php
    include('koneksi.php');

    $stmt = $conn->prepare("SELECT * FROM pengguna ORDER BY dibuat DESC");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    return $stmt->fetchAll();
?>