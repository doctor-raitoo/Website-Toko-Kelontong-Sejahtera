<?php 
session_start();
if (!isset($_SESSION['user'])) header('location: login.php');

$_SESSION['table'] = 'produk';
$products = include('show.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>
    <?php include('app_header_script.php'); ?>
    <style>
        .dashboard_content_main {
            background: white;
            min-height: 800px;
            height: 100%;
            border: 1px solid lightgray;
            padding-left: 20px;
        }

        .appForm {
            width: 90%;
            margin: 0 auto;
            padding: 10px;
            border: 1px solid darkgray;
            border-radius: 10px;
            background: #f4f6f9;
        }
        .responseMessage {
            font-size: 20px;
            text-align: center;
            margin-top: 30px;
            padding: 25px;
        }
        .responseMessage__success {
            background: lightgreen;
        }
        .responseMessage__error {
            background: red;
        }

        /* form edit */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 2px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .modal-form label {
            display: block;
            margin-bottom: 5px;
        }
        .modal-form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .modal-form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .modal-form button:hover {
            background-color: #45a049;
        }

        /* table */
        .row {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            width: 100%;
        }
        .column {
            width: 100%;
            padding: 0px 10px;
        }

        .column-5 {
            width: 41.67%;
        }

        .column-7 {
            width: 58.33%;
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

        .users table, th, td {
            border: 1px solid black;
            padding: 10px 8px;
            text-align: center;
            font-size: 14px;
        }

        .users table {
            width: 100%;
            border-collapse: collapse;
            font-family: "Roboto" sans-serif;
            background: white;
            border-radius: 0px;
            overflow: hidden;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }

        .users table th {
            background: lightgray;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.5px;
            color: #333;
            text-align: center;
        }

        .users table tbody tr:nth-child(even){
            background: #fafafa;
        }

        .users table tbody tr:hover {
            background: #eef3ff;
            transition: 0.2s;
        }

        .users a.updateUser,
        .users .deleteUser {
            font-size: 13px;
        }

        .users .deleteUser i {
            color: red;
        }

        .users .updateUser i {
            color: #007bff;
        }

        .users table td {
            font-size: 13px;
            text-align: center;
            padding: 5px;
        }

        .jumlah_user {
            margin-top: 20px;
            text-align: right;
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            color: lightskyblue;
        }

        .productImage {
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>
<div id="dashboard_main_container">
    <?php include('sidebar.php') ?> 
    <div class="dashboard_content_container" id="dashboard_content_container">
        <?php include('topnav.php') ?>
        <div class="dashboard_content">
            <div class="dashboard_content_main">
                <div class="row">
                    <div class="column column-12">
                        <h1 class="section_header"><i class="fa fa-list"></i> Daftar Barang/Produk</h1>

                        <div class="section_content">
                            <div class="users">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Gambar</th>
                                            <th>Nama Produk</th>
                                            <th>Deskripsi</th>
                                            <th>Harga</th>
                                            <th>Ditambahkan oleh</th>
                                            <th>Ditambahkan</th>
                                            <th>Diperbarui</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($products as $index => $product){ ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td class="gambar">
                                                <img class="productImage" src="image/<?= $product['gambar']?>" alt="" />
                                            </td>
                                            <td class="namaProduk"><?= $product['nama_produk'] ?></td>
                                            <td class="deskripsiProduk"><?= $product['deskripsi'] ?></td>
                                            <td class="harga"><?= $product['harga'] ?></td>
                                            <td>
                                                <?php
                                                    $pid = $product['oleh'];
                                                    $stmt = $conn->prepare("SELECT * FROM pengguna WHERE id=$pid");
                                                    $stmt->execute();
                                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                    $created_by_name = $row['nama_depan'] . ' ' . $row['nama_belakang'];
                                                    echo $created_by_name;
                                                ?>
                                            </td>
                                            <td><?= date('d-M-Y', strtotime($product['dibuat'])) ?></td>
                                            <td><?= date('d-M-Y', strtotime($product['diperbarui'])) ?></td>
                                            <td>
                                                <a href="#" class="updateProduct" data-pid="<?= $product['id'] ?>">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                                <form method="POST" action="delete.php" style="display:inline;">
                                                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                                    <input type="hidden" name="table" value="produk">

                                                    <button type="submit"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus?')"
                                                        style="
                                                            background:none;
                                                            border:none;
                                                            color:red;
                                                            cursor:pointer;
                                                        ">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> 
            </div> 
        </div> 
    </div> 
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Data produk</h2>
        <form action="update.php" method="POST" class="modal-form">
            <input type="hidden" id="edit_product_id" name="product_id">
            <label for="edit_nama_produk">Nama Produk</label>
            <input type="text" id="edit_nama_produk" name="nama_produk" required>
            
            <label for="edit_deskripsi">Deskripsi</label>
            <input type="text" id="edit_deskripsi" name="deskripsi" required>

            <label for="edit_harga">Harga</label>
            <input type="text" id="edit_harga" name="harga" required>
            
            <label for="edit_gambar">Gambar</label>
            <input type="file" id="edit_gambar" name="gambar">

            <label>Gambar Saat Ini:</label>
            <img id="preview_gambar" src="" style="width:100px;height:100px;margin-bottom:10px;border:1px solid #ccc;">

            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php include('app_script.php'); ?>

<script>
    function script(){ 

        this.initialize = function(){
            this.registerEvents();
        };

        this.registerEvents = function(){
            document.addEventListener('click', function(e){
                const targetElement = e.target;
                const classList = targetElement.classList;

                if(classList.contains('deleteProduct')){
                }
                if (classList.contains('updateProduct')) {
                    e.preventDefault();

                    const row = targetElement.closest('tr');

                    const namaProduk = row.querySelector('.namaProduk').textContent;
                    const deskripsiProduk = row.querySelector('.deskripsiProduk').textContent;
                    const harga = row.querySelector('.harga').textContent;
                    const gambarFullPath = row.querySelector('.productImage').getAttribute('src');

                    const productId = targetElement.getAttribute('data-pid');

                    document.getElementById('edit_product_id').value = productId;
                    document.getElementById('edit_nama_produk').value = namaProduk;
                    document.getElementById('edit_deskripsi').value = deskripsiProduk;
                    document.getElementById('edit_harga').value = harga;

                    document.getElementById('preview_gambar').src = gambarFullPath;

                    document.getElementById('editModal').style.display = 'block';
                }
            });

            document.querySelector('.close').addEventListener('click', function(){
                document.getElementById('editModal').style.display = 'none';
            });

            window.addEventListener('click', function(e){
                const modal = document.getElementById('editModal');
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }
    }
    var script = new script();
    script.initialize();
</script>

</script>

</html>