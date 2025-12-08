<?php 
session_start();
date_default_timezone_set('Asia/Jakarta');
if (!isset($_SESSION['user'])) header('location: login.php');

$_SESSION['table'] = 'transaksi';
$transaksi = include('show.php');

include('koneksi.php');

$grouped = [];
foreach ($transaksi as $t) {
    $tgl = date('d/m/Y', strtotime($t['waktu_transaksi']));
    $grouped[$tgl][] = $t;
}
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
            height: 100%;
            border: 1px solid lightgray;
            padding: 20px;
        }

        .section_header {
            font-size: 25px;
            color: gray;
            border-bottom: 1px solid gray;
            padding-bottom: 11px;
            padding: 10px;
            border-left: 4px solid blue;
            margin-bottom: 20px;
        }

        .tanggal_title {
            font-size: 15px;
            font-weight: bold;
            padding: 12px 10px;
            color: #333;
            border-left: 5px solid #007bff;
            margin-top: 35px;
            margin-bottom: 15px;
            background: #eef6ff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .users table {
            width: 98%;
            border-collapse: collapse;
            margin-bottom: 25px;
            background: white;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .users table th {
            background: #f1f1f1;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .users table td {
            padding: 10px;
            font-size: 13px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .users table tr:nth-child(even) {
            background: #fafafa;
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
                    <i class="fa fa-shopping-cart"></i> Data Transaksi Penjualan
                </h1>

                <div class="users">

                    <?php foreach ($grouped as $tanggal => $items): ?>

                        <div class="tanggal_title">
                            Transaksi Tanggal: <?= $tanggal ?>
                            <a href="print_report.php?tanggal=<?= $tanggal ?>" 
                            style="font-size:14px; padding:6px 10px; background:#007bff; 
                            color:white; border-radius:4px; text-decoration:none; display:inline-block;">
                            Cetak Laporan
                            </a>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Total Harga</th>
                                    <th>Waktu Transaksi</th>
                                    <th>Kasir/Admin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php foreach ($items as $index => $t): ?>

                                <?php  
                                    $stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
                                    $stmt->execute([$t['produk_id']]);
                                    $produk = $stmt->fetch(PDO::FETCH_ASSOC);

                                    $stmt2 = $conn->prepare("SELECT * FROM pengguna WHERE id = ?");
                                    $stmt2->execute([$t['oleh']]);
                                    $user = $stmt2->fetch(PDO::FETCH_ASSOC);
                                    $kasir = $user ? $user['nama_depan'].' '.$user['nama_belakang'] : '-';
                                ?>

                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $produk['nama_produk'] ?></td>
                                    <td><?= $t['qty'] ?></td>   
                                    <td>Rp <?= number_format($produk['harga']) ?></td>
                                    <td><b>Rp <?= number_format($t['total_harga']) ?></b></td>
                                    <td><?= date('H:i:s', strtotime($t['waktu_transaksi'])) ?></td>
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

                            <?php  
                                $total_qty = array_sum(array_column($items, 'qty'));
                                $total_pendapatan = array_sum(array_column($items, 'total_harga'));
                            ?>
                            <tr style="background:#e8f3ff; font-weight:bold;">
                                <td colspan="2">Total Barang Terjual</td>
                                <td><?= $total_qty ?></td>
                                <td colspan="2">Total Pendapatan</td>
                                <td colspan="3">Rp <?= number_format($total_pendapatan) ?></td>
                            </tr>
                        </table>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('app_script.php'); ?>

</body>
</html>
