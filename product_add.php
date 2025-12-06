<?php 
session_start();
if (!isset($_SESSION['user'])) header('location: login.php');

$_SESSION['table'] = 'produk';
$_SESSION['redirect_to'] = 'product_add.php';
$user = $_SESSION['user'];
$users = include('show_users.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Produk</title>
    <?php include('app_header_script.php'); ?>

    <style>
        .appForm {
            width: 70%;
            margin: 0 auto;
            padding: 30px 35px;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #d5e0ff;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .appFormInputContainer {
            margin-bottom: 22px;
        }

        label {
            font-weight: 600;
            font-size: 13px;
            color: #333;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 6px;
        }

        .appFormInput {
            width: 100%;
            height: 40px;
            border: 1px solid #bfc7d1;
            border-radius: 7px;
            padding: 0 10px;
            font-size: 14px;
            transition: 0.2s;
        }

        .appFormInput:focus,
        .productTextAreaInput:focus {
            border-color: #4a7dff;
            box-shadow: 0 0 4px rgba(74,125,255,0.4);
            outline: none;
        }

        .productTextAreaInput {
            width: 100%;
            height: 90px;
            border: 1px solid #bfc7d1;
            border-radius: 7px;
            padding: 10px;
            font-size: 14px;
        }

        input[type="file"] {
            margin-top: 6px;
        }

        .buttonContainer {
            text-align: center;
            margin-top: 25px;
        }

        .appBtn {
            width: 60%;
            padding: 12px 0;
            background: #006eff;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            font-size: 15px;
            cursor: pointer;
            transition: 0.25s;
        }

        .appBtn:hover {
            background: #0057d4;
            transform: translateY(-2px);
        }

        .appBtn:active {
            transform: scale(0.97);
        }

        .responseMessage {
            margin-top: 28px;
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

        .row {
            width: 100%;
        }

        .column {
            width: 100%;
            padding: 0px 10px;
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
                        <h1 class="section_header"><i class="fa fa-plus"></i> Tambah Data Produk</h1>

                        <div class="userAddFormContainer">
                            
                            <form action="add.php" method="POST" class="appForm" enctype="multipart/form-data">

                                <div class="appFormInputContainer">
                                    <label for="nama_produk">Nama Produk</label>
                                    <input type="text" class="appFormInput" id="nama_produk" placeholder="Masukkan nama produk...." name="nama_produk" required />
                                </div>

                                <div class="appFormInputContainer">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="appFormInput productTextAreaInput" name="deskripsi" placeholder="Masukkan deskripsi produk...." id="deskripsi"></textarea>
                                </div>

                                <div class="appFormInputContainer">
                                    <label for="harga">Harga</label>
                                    <input type="text" class="appFormInput" id="harga" placeholder="Masukkan harga...." name="harga" required />
                                </div>

                                <div class="appFormInputContainer">
                                    <label for="gambar_produk">Gambar Produk</label>
                                    <input type="file" name="gambar" />
                                </div>

                                <div class="buttonContainer">
                                    <button type="submit" class="appBtn">
                                        <i class="fa fa-plus"></i> Tambah Produk
                                    </button>
                                </div>

                            </form>

                            <?php 
                            if(isset($_SESSION['response'])) {
                                $response_message = $_SESSION['response']['message'];
                                $is_success = $_SESSION['response']['success'];
                            ?>
                                <div class="responseMessage">
                                    <p class="<?= $is_success ? 'responseMessage__success' : 'responseMessage__error' ?>">
                                        <?= $response_message ?>
                                    </p>
                                </div>
                            <?php unset($_SESSION['response']); } ?>

                        </div>
                    </div>
                </div> 
            </div> 
        </div> 
    </div> 
</div>

<?php include('app_script.php'); ?>
</body>
</html>
