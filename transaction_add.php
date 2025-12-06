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
</head>
<body>
<div id="dashboard_main_container">
    <?php include('sidebar.php') ?>
    <div class="dashboard_content_container">
        <?php include('topnav.php') ?>

        <div class="dashboard_content">
            <h1 class="section_header"><i class="fa fa-cash-register"></i> Tambah Transaksi</h1>

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
        </div>
    </div>
</div>
</body>
</html>
