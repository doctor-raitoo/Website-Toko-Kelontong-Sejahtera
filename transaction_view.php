<?php 
session_start();
if (!isset($_SESSION['user'])) header('location: login.php');

$_SESSION['table'] = 'transaksi';
$transaksi = include('show.php');

include('koneksi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
    <?php include('app_header_script.php'); ?>

    <style>
        .dashboard_content_main {
            background: white;
            min-height: 800px;
            padding-left: 20px;
            border: 1px solid lightgray;
        }

        .section_header {
            font-size: 25px;
            color: gray;
            border-bottom: 1px solid gray;
            padding: 10px 0;
            padding-left: 10px;
            border-left: 4px solid blue;
            margin-bottom: 20px;
        }

        .users table, th, td {
            border: 1px solid black;
            padding: 10px 8px;
            text-align: center;
            font-size: 14px;
        }

        .users table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            overflow: hidden;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
        }

        .users table th {
            background: lightgray;
            font-weight: bold;
        }

        .users table tr:nth-child(even) {
            background: #fafafa;
        }

        .users table tr:hover {
            background: #eef3ff;
            transition: 0.2s;
        }

        .deleteUser i {
            color: red;
        }

    </style>
</head>

<body>

<div id="dashboard_main_container">
    <?php include('sidebar.php') ?>

    <div class="dashboard_content_container">
        <?php include('topnav.php') ?>

        <div class="dashboard_content">
            <div class="dashboard_content_main">

                <h1 class="section_header">
                    <i class="fa fa-shopping-cart"></i> Data Transaksi Pembelian
                </h1>

                <div class="users">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Qty</th>
                                <th>Harga Satuan</th>
                                <th>Total Harga</th>
                                <th>Waktu Transaksi</th>
                                <th>Kasir / Admin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($transaksi as $index => $t): ?>

                            <?php
                                // ambil data produk
                                $stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
                                $stmt->execute([$t['produk_id']]);
                                $produk = $stmt->fetch(PDO::FETCH_ASSOC);

                                // ambil data user
                                $stmt2 = $conn->prepare("SELECT * FROM pengguna WHERE id = ?");
                                $stmt2->execute([$t['oleh']]);
                                $user = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $kasir = $user ? $user['nama_depan'] . ' ' . $user['nama_belakang'] : '-';
                            ?>

                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $produk['nama_produk'] ?></td>
                                <td><?= $t['qty'] ?></td>
                                <td>Rp <?= number_format($produk['harga']) ?></td>
                                <td><b>Rp <?= number_format($t['total_harga']) ?></b></td>
                                <td><?= date('d-m-Y H:i:s', strtotime($t['waktu_transaksi'])) ?></td>
                                <td><?= $kasir ?></td>

                                <td>
                                    <form action="delete.php" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">

                                        <input type="hidden" name="id" value="<?= $t['id'] ?>">
                                        <input type="hidden" name="table" value="transaksi">

                                        <button type="submit" 
                                            style="background:none; border:none; cursor:pointer; color:red;">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>

                            </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include('app_script.php'); ?>

</body>
</html>
