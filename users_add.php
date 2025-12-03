<?php 
session_start();
if (!isset($_SESSION['user'])) header('location: login.php');

$_SESSION['table'] = 'pengguna';
$user = $_SESSION['user'];
$users = include('show_users.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css" integrity="sha512-PvZCtvQ6xGBLWHcXnyHD67NTP+a+bNrToMsIdX/NUqhw+npjLDhlMZ/PhSHZN4s9NdmuumcxKHQqbHlGVqc8ow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://use.fontawesome.com/0c7a3095b5.js"></script>
    <style>
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
                    <div class="column column-5">
                        <h1 class="section_header"><i class="fa fa-plus"></i> Tambahkan Pengguna</h1>
                        <div class="userAddFormContainer">
                            <form action="add.php" method="POST" class="appForm">
                                <div class="appFormInputContainer">
                                    <label for="nama_depan">Nama Depan</label>
                                    <input type="text" class="appFormInput" id="nama_depan" name="nama_depan" required />
                                </div>
                                <div class="appFormInputContainer">
                                    <label for="nama_belakang">Nama Belakang</label>
                                    <input type="text" class="appFormInput" id="nama_belakang" name="nama_belakang" required />
                                </div>
                                <div class="appFormInputContainer">
                                    <label for="email">Email</label>
                                    <input type="email" class="appFormInput" id="email" name="email" required />
                                </div>
                                <div class="appFormInputContainer">
                                    <label for="password">Password</label>
                                    <input type="password" class="appFormInput" id="password" name="password" required />
                                </div>
                                <button type="submit" class="appBtn">
                                    <i class="fa fa-plus"></i> Tambah
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
                    <div class="column column-7">
                        <h1 class="section_header"><i class="fa fa-users"></i> Daftar Pengguna</h1>

                        <div class="section_content">
                            <div class="users">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Depan</th>
                                            <th>Nama Belakang</th>
                                            <th>Email</th>
                                            <th>Dibuat</th>
                                            <th>Diperbarui</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($users as $index => $u){ ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td class="namaDepan"><?= $u['nama_depan'] ?></td>
                                            <td class="namaBelakang"><?= $u['nama_belakang'] ?></td>
                                            <td class="email"><?= $u['email'] ?></td>
                                            <td><?= date('d-M-Y', strtotime($u['dibuat'])) ?></td>
                                            <td><?= date('d-M-Y', strtotime($u['diperbarui'])) ?></td>
                                            <td>
                                                <a href="#" class="updateUser" data-id="<?= $u['id'] ?>"><i class="fa fa-pencil"></i> Edit</a>
                                                <form action="delete_users.php" method="POST" style="display:inline;">
                                                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                                    <input type="hidden" name="nama_depan" value="<?= $u['nama_depan'] ?>">
                                                    <input type="hidden" name="nama_belakang" value="<?= $u['nama_belakang'] ?>">
                                                    <button type="submit" class="deleteUser"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus <?= $u['nama_depan'] . ' ' . $u['nama_belakang'] ?>?')"
                                                        style=
                                                        "background:none;
                                                        border:none;
                                                        color:red;
                                                        cursor:pointer;">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <p class="jumlah_user"><?= count($users) ?> Pengguna</p>
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
        <h2>Edit Data Pengguna</h2>
        <form action="update_users.php" method="POST" class="modal-form">
            <input type="hidden" id="edit_user_id" name="user_id">
            <label for="edit_nama_depan">Nama Depan</label>
            <input type="text" id="edit_nama_depan" name="nama_depan" required>
            
            <label for="edit_nama_belakang">Nama Belakang</label>
            <input type="text" id="edit_nama_belakang" name="nama_belakang" required>
            
            <label for="edit_email">Email</label>
            <input type="email" id="edit_email" name="email" required>
            
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</div>

<script src="script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.js" integrity="sha512-AZ+KX5NScHcQKWBfRXlCtb+ckjKYLO1i10faHLPXtGacz34rhXU8KM4t77XXG/Oy9961AeLqB/5o0KTJfy2WiA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script>
    function script(){ 

        this.initialize = function(){
            this.registerEvents();
        };

        this.registerEvents = function(){
            document.addEventListener('click', function(e){
                const targetElement = e.target;
                const classList = targetElement.classList;

                if(classList.contains('deleteUser')){
                }

                if(classList.contains('updateUser')){
                    e.preventDefault();
                    
                    const row = targetElement.closest('tr');
                    const namaDepan = row.querySelector('td.namaDepan').innerHTML;
                    const namaBelakang = row.querySelector('td.namaBelakang').innerHTML;
                    const email = row.querySelector('td.email').innerHTML;
                    const userId = targetElement.getAttribute('data-id');
                    
                    document.getElementById('edit_user_id').value = userId;
                    document.getElementById('edit_nama_depan').value = namaDepan;
                    document.getElementById('edit_nama_belakang').value = namaBelakang;
                    document.getElementById('edit_email').value = email;
                    
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

</html>