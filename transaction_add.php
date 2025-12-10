<?php 
session_start();
if (!isset($_SESSION['user'])) header('location: login.php');

$_SESSION['table'] = 'transaksi';
$_SESSION['redirect_to'] = 'transaction_add.php';

include('koneksi.php');

$stmt = $conn->prepare("SELECT * FROM produk ORDER BY nama_produk ASC");
$stmt->execute();
$produk_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Transaksi</title>
    <?php include('app_header_script.php'); ?>
    <style>
        .page_title_bar {
            width: 100%;
            background: white;
            padding: 18px 25px;
            margin: 25px 0 25px 0;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .page_title_bar i {
            font-size: 28px;
            color: #1e40af;
        }

        .page_title_bar h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
        }

        .transaction_form_wrapper {
            width: 55%;
            margin: 30px auto;
            background: white;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.08);
        }

        .transaction_form_wrapper h1.section_header {
            margin-bottom: 20px;
            font-size: 25px !important;
        }

        .appFormInputContainer {
            margin-bottom: 20px;
        }

        .appFormInputContainer label {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        .appFormInput {
            width: 100%;
            padding: 12px;
            border: 1px solid #cacaca;
            border-radius: 8px;
            font-size: 15px;
        }

        .appBtn {
            width: 100%;
            padding: 12px;
            background: blue;
            border: none;
            outline: none;
            font-size: 17px;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }

        .appBtn:hover {
            background: #003adb;
            transition: 0.2s;
        }

        .responseMessage {
            margin-bottom: 22px;
            text-align: center;
        }
        .responseMessage__success {
            background: #d6ffd9;
            color: #0a7613;
            padding: 15px;
            border-radius: 8px;
            font-weight: bold;
            border-left: 5px solid #28c22f;
        }
        .responseMessage__error {
            background: #ffd6d6;
            color: #900000;
            padding: 15px;
            border-radius: 8px;
            font-weight: bold;
            border-left: 5px solid red;
        }

        @media (max-width: 768px) {
            .transaction_form_wrapper {
                width: 90%;
            }
        }
    </style>
</head>

<body>
<div id="dashboard_main_container">

    <?php include('sidebar.php') ?>

    <div class="dashboard_content_container">
        <?php include('topnav.php') ?>

        <div class="page_title_bar">
            <i class="fa fa-pencil"></i>
            <h1>Tambah Transaksi</h1>
        </div>

        <div class="dashboard_content">

            <div class="transaction_form_wrapper">

                <?php 
                if(isset($_SESSION['response'])) {
                    echo "<div class='responseMessage'>
                            <p class='".($_SESSION['response']['success']?'responseMessage__success':'responseMessage__error')."'>
                                ".$_SESSION['response']['message']."
                            </p>
                        </div>";
                    unset($_SESSION['response']);
                }
                ?>

                <h1 class="section_header">
                    <i class="fa fa-cash-register"></i> Tambah Data Transaksi
                </h1>

                <form action="add.php" method="POST" class="appForm">

                    <div class="appFormInputContainer">
                        <label>Produk</label>
                        <select name="produk_id" class="appFormInput" required>
                            <option value="">-- Pilih Produk --</option>
                            <?php foreach($produk_list as $prod): ?>
                                <option value="<?= $prod['id'] ?>">
                                    <?= $prod['nama_produk'] ?> - Rp <?= number_format($prod['harga']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="appFormInputContainer">
                        <label>Jumlah Barang Dibeli</label>
                        <input type="number" name="qty" class="appFormInput" min="1" required>
                    </div>

                    <input type="hidden" name="total_harga" id="total_harga">
                    <input type="hidden" name="waktu_transaksi" value="<?= date('Y-m-d H:i:s') ?>">

                    <button type="submit" class="appBtn">
                        <i class="fa fa-check"></i> Simpan Transaksi
                    </button>

                </form>

                <script>
                const produk = <?= json_encode($produk_list); ?>;
                const selectProduk = document.querySelector('select[name="produk_id"]');
                const qtyInput = document.querySelector('input[name="qty"]');
                const totalInput = document.getElementById('total_harga');

                function updateTotal() {
                    let pid = selectProduk.value;
                    let qty = qtyInput.value;

                    if (!pid || !qty) return;

                    let harga = produk.find(p => p.id == pid).harga;
                    totalInput.value = qty * harga;
                }

                selectProduk.addEventListener('change', updateTotal);
                qtyInput.addEventListener('input', updateTotal);
                </script>
            </div>
        </div>
    </div>
</div>
</body>
</html>
