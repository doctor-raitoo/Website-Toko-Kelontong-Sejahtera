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

        <div class="dashboard_content">

            <div class="transaction_form_wrapper">

                <h1 class="section_header"><i class="fa fa-cash-register"></i> Tambah Data Transaksi</h1>

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

            </div><!-- end wrapper -->

        </div>
    </div>
</div>
</body>
</html>
