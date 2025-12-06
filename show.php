<?php
    include('koneksi.php');

    $table_name = $_SESSION['table'];

    $stmt = $conn->prepare("SELECT * FROM $table_name ORDER BY dibuat DESC");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    return $stmt->fetchAll();
?>