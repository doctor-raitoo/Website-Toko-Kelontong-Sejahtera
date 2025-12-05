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
    <title>Tambah Data Pengguna</title>
    <?php include('app_header_script.php'); ?>

    <style>
        .appForm {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid lightblue;
            border-radius: 10px;
            background: whitesmoke;
        }

        .appFormInputContainer {
            margin-bottom: 15px;
        }

        .appFormInput {
            width: 100%;
            height: 33px;
            border: 1px solid black;
            border-radius: 5px;
            margin-top: 5px;
        }

        form::after {
            content: '';
            clear: both;
            display: block;
        }

        label {
            font-weight: bold;
            text-transform: uppercase;
        }

        .appBtn {
            background: blue;
            border: 2px solid blue;
            border-radius: 5px;
            color: white;
            padding: 10px;
            margin-top: 10px;
            float: right;
            cursor: pointer;
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

        .userAddFormContainer {
            padding-top: 30px;
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

        .productTextAreaInput {
            width: 100%;
            height: 75px;
            border-radius: 5px;
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
                                    <textarea class="appFormInput productTextAreaInput" name="deskripsi" placeholder="Masukkan deskripsi produk...." id="deskripsi">
                                    </textarea>
                                </div>
                                <div class="appFormInputContainer">
                                    <label for="nama_produk">Gambar Produk</label>
                                    <input type="file" name="img" />
                                </div>
                                <button type="submit" class="appBtn">
                                    <i class="fa fa-plus"></i> Tambah Produk
                                </button>
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
                            <?php
                                unset($_SESSION['response']);
                            } 
                            ?>
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
        <h2>Edit Data Pengguna</h2>
        <form action="update_users.php" method="POST" class="modal-form">
            <input type="hidden" id="edit_user_id" name="user_id">
            <label for="edit_nama_produk">Nama Depan</label>
            <input type="text" id="edit_nama_produk" name="nama_produk" required>
            
            <label for="edit_deskripsi">Nama Belakang</label>
            <input type="text" id="edit_deskripsi" name="deskripsi" required>
            
            <label for="edit_email">Email</label>
            <input type="email" id="edit_email" name="email" required>
            
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php include('app_script.php'); ?>

</body>
</html>