<?php
session_start();
if (!isset($_SESSION['user']))
    header('location: login.php');

$_SESSION['table'] = 'pengguna';
$_SESSION['redirect_to'] = 'users_add.php';
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
        .formCard {
            width: 50%;
            margin: 0 auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #dfdfdf;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.08);
        }

        .formCard h2 {
            font-size: 22px;
            font-weight: bold;
            color: #444;
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 2px solid #2e6cff;
        }

        .appFormInputContainer {
            margin-bottom: 15px;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
            color: #333;
            font-size: 14px;
            text-transform: uppercase;
        }

        .appFormInput {
            width: 100%;
            height: 38px;
            border: 1px solid #9c9c9c;
            border-radius: 6px;
            padding: 5px 10px;
            font-size: 14px;
        }

        .buttonContainer {
            text-align: center;
            width: 100%;
            margin-top: 20px;
        }

        .appBtn {
            display: inline-block;
            width: 70%;             
            padding: 12px 0;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            background: #4CAF50;   
            color: #fff;
            border: none;
            cursor: pointer;
            transition: 0.25s;
        }
        
        .appBtn:hover {
            background: #45a049;
            transform: translateY(-2px);
        }

        .appBtn:active {
            transform: scale(0.97);
        }


        .responseMessage {
            margin-top: 25px;
            padding: 18px;
            text-align: center;
            font-size: 17px;
            font-weight: 600;
            border-radius: 6px;
        }

        .responseMessage__success {
            background: #d6ffd6;
            border: 1px solid #4caf50;
        }

        .responseMessage__error {
            background: #ffd6d6;
            border: 1px solid #e53935;
        }

        .section_header {
            font-size: 30px;
            font-weight: bold;
            color: #4a4a4a;
            border-left: 7px solid #2e6cff;
            padding-left: 20px;
            margin-bottom: 30px;
        }

        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 10;
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 480px;
            margin: 10% auto;
            padding: 20px;
            border-radius: 12px;
        }

        .close {
            float: right;
            font-size: 28px;
            cursor: pointer;
            color: #777;
        }

        .close:hover {
            color: black;
        }

        .modal-form input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .modal-form button {
            background: #4CAF50;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            color: white;
            cursor: pointer;
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

                    <h1 class="section_header"><i class="fa fa-user-plus"></i> Tambah Data Pengguna</h1>

                    <div class="formCard">
                    <h2>Tambahkan Akun Pengguna</h2>

                    <form action="add.php" method="POST">
                        <div class="appFormInputContainer">
                            <label>Nama Depan</label>
                            <input type="text" name="nama_depan" class="appFormInput" required>
                        </div>

                        <div class="appFormInputContainer">
                            <label>Nama Belakang</label>
                            <input type="text" name="nama_belakang" class="appFormInput" required>
                        </div>

                        <div class="appFormInputContainer">
                            <label>Email</label>
                            <input type="email" name="email" class="appFormInput" required>
                        </div>

                        <div class="appFormInputContainer">
                            <label>Password</label>
                            <input type="password" name="password" class="appFormInput" required>
                        </div>
                        <div class="buttonContainer">
                            <button type="submit" class="appBtn">
                                <i class="fa fa-plus"></i> Tambah Data
                            </button>
                        </div>
                    </form>
                </div>
                <?php if (isset($_SESSION['response'])) { 
                    $msg = $_SESSION['response']['message'];
                    $success = $_SESSION['response']['success'];  
                ?>
                <div class="responseMessage <?= $success ? 'responseMessage__success' : 'responseMessage__error' ?>">
                    <?= $msg ?>
                </div>
                <?php unset($_SESSION['response']); } ?>
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
                <label>Nama Depan</label>
                <input type="text" name="nama_depan" id="edit_nama_depan">

                <label>Nama Belakang</label>
                <input type="text" name="nama_belakang" id="edit_nama_belakang">

                <label>Email</label>
                <input type="email" name="email" id="edit_email">

                <button type="submit">Simpan</button>
            </form>
        </div>
    </div>

    <?php include('app_script.php'); ?>

</body>

</html>