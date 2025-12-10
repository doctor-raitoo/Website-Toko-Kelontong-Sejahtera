<style>
    .dashboard_summary {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }

    .dashboard_summary .box {
        flex: 1;
        background: #fff;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.08);
        text-align: center;
        transition: 0.3s;
    }

    .dashboard_summary .box:hover {
        transform: translateY(-3px);
        box-shadow: 0px 6px 16px rgba(0,0,0,0.12);
    }

    .dashboard_summary .box h3 {
        font-size: 28px;
        color: #222;
        margin-bottom: 5px;
    }

    .dashboard_summary .box p {
        font-size: 14px;
        color: #666;
    }

    .section_header {
        font-size: 26px;
        margin-bottom: 25px;
        font-weight: bold;
        color: #333;
    }

    .sub_header {
        font-size: 20px;
        margin: 30px 0 10px 0;
        font-weight: 600;
        color: #444;
    }

    .info_table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        margin-bottom: 30px;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.08);
        border-radius: 8px;
        overflow: hidden;
    }

    .info_table thead {
        background: #444;
        color: white;
    }

    .info_table th, 
    .info_table td {
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
    }

    .info_table tbody tr:hover {
        background: #f5f5f5;
    }

    canvas {
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.08);
        margin-bottom: 40px;
    }

    .dashboard_content_main {
        padding: 25px;
    }

    .dashboard_content_main > * {
        margin-bottom: 20px;
    }
</style>

<?php 
session_start();
if (!isset($_SESSION['user'])) header('location: login.php');

include('koneksi.php');
date_default_timezone_set('Asia/Jakarta');
$user = $_SESSION['user'];

$today = date("Y-m-d");

$stmt = $conn->prepare("
    SELECT SUM(total_harga) AS pendapatan,
    SUM(qty) AS total_qty,
    COUNT(*) AS jumlah_transaksi
    FROM transaksi
    WHERE DATE(waktu_transaksi)=?
");
$stmt->execute([$today]);
$todayData = $stmt->fetch(PDO::FETCH_ASSOC);


$chart = $conn->query("
    SELECT DATE(waktu_transaksi) AS tgl,
    SUM(qty) AS total_qty,
    SUM(total_harga) AS total_harga
    FROM transaksi
    GROUP BY DATE(waktu_transaksi)
    ORDER BY DATE(waktu_transaksi) DESC
    LIMIT 7
")->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$chart_qty = [];
$chart_income = [];

foreach (array_reverse($chart) as $row) {
    $labels[] = date('d/m', strtotime($row['tgl']));
    $chart_qty[] = $row['total_qty'];
    $chart_income[] = $row['total_harga'];
}

$latest = $conn->query("
    SELECT transaksi.*, produk.nama_produk
    FROM transaksi
    JOIN produk ON produk.id = transaksi.produk_id
    ORDER BY transaksi.id DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://use.fontawesome.com/0c7a3095b5.js"></script>
</head>

<body>
<div id="dashboard_main_container">
    <?php include('sidebar.php') ?>

    <div class="dashboard_content_container" id="dashboard_content_container">
        <?php include('topnav.php') ?>

        <div class="dashboard_content">
            <div class="dashboard_content_main">

                <h1 class="section_header"><i class="fa fa-dashboard"></i> Dashboard</h1>

                <div class="dashboard_summary">
                    <div class="box">
                        <h3>Rp <?= number_format($todayData['pendapatan'] ?? 0) ?></h3>
                        <p>Pendapatan Hari Ini</p>
                    </div>

                    <div class="box">
                        <h3><?= $todayData['jumlah_transaksi'] ?? 0 ?></h3>
                        <p>Total Transaksi Hari Ini</p>
                    </div>

                    <div class="box">
                        <h3><?= $todayData['total_qty'] ?? 0 ?></h3>
                        <p>Barang Terjual Hari Ini</p>
                    </div>
                </div>


                <h2 class="sub_header">Grafik Penjualan 7 Hari Terakhir</h2>
                <canvas id="chartQty" style="width:100%; height:250px;"></canvas>

                <h2 class="sub_header">Grafik Pendapatan 7 Hari Terakhir</h2>
                <canvas id="chartIncome" style="width:100%; height:250px;"></canvas>


                <h2 class="sub_header">Transaksi Terbaru</h2>
                <table class="info_table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Qty</th>
                            <th>Total Harga</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($latest as $l): ?>
                        <tr>
                            <td><?= $l['nama_produk'] ?></td>
                            <td><?= $l['qty'] ?></td>
                            <td>Rp <?= number_format($l['total_harga']) ?></td>
                            <td><?= date('d/m H:i', strtotime($l['waktu_transaksi'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<script src="script.js"></script>

<script>
    const labels = <?= json_encode($labels) ?>;

    new Chart(document.getElementById('chartQty'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah barang terjual',
                data: <?= json_encode($chart_qty) ?>,
                borderWidth: 2,
                tension: 0.3
            }]
        }
    });

    new Chart(document.getElementById('chartIncome'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: <?= json_encode($chart_income) ?>,
                borderWidth: 2
            }]
        }
    });
</script>

</body>
</html>
