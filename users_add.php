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
    <script src="https://use.fontawesome.com/0c7a3095b5.js"></script>
    <style>
        .appForm {
            width: 90%;
            margin: 0 auto;
            padding: 10px;
            border: 3px solid black;
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
                                        <input type="text" class="appFormInput" id="nama_depan" name="nama_depan"/>
                                    </div>

                                    <div class="appFormInputContainer">
                                        <label for="nama_belakang">Nama Belakang</label>
                                        <input type="text" class="appFormInput" id="nama_belakang" name="nama_belakang"/>
                                    </div>

                                    <div class="appFormInputContainer">
                                        <label for="email">Email</label>
                                        <input type="email" class="appFormInput" id="email" name="email"/>
                                    </div>

                                    <div class="appFormInputContainer">
                                        <label for="password">Password</label>
                                        <input type="password" class="appFormInput" id="password" name="password"/>
                                    </div>

                                    <button type="submit" class="appBtn"><i class="fa fa-plus"></i> Tambah</button>
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
                                                <th>Tanggal dibuat</th>
                                                <th>Tanggal diperbarui</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($users as $index => $user){ ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= $user['nama_depan'] ?></td>
                                                <td><?= $user['nama_belakang'] ?></td>
                                                <td><?= $user['email'] ?></td>
                                                <td><?= date('d-M-Y', strtotime($user['dibuat'])) ?></td>
                                                <td><?= date('d-M-Y', strtotime($user['diperbarui'])) ?></td>
                                                <td>
                                                    <a href="" class=""><i class="fa fa-pencil"></i> Edit</a>
                                                    <a href="" class="deleteUser" 
                                                    data-userid="<? $user('id') ?>" 
                                                    data-firstname="<?= $user['nama_depan'] ?>"
                                                    data-lastname="<?= $user['nama_belakang']?>"><i class="fa fa-trash"></i> Hapus</a>
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
    <script src="script.js"></script>
    <script src="jquery-3.7.1.min.js"></script>
    <script>
        function script(){
            this.initialize = function(){
                this.registerEvents();
            }, 

            this.registerEvents = function(){
                document.addEventListener('click', function(e){
                    targetElement = e.target;
                    classList = targetElement.classList;

                    if(classList.contains('deleteUser')){
                        e.preventDefault();
                        userId = targetElement.dataset.userid;
                        firstname = targetElement.dataset.firstname;
                        lastname = targetElement.dataset.lastname;
                        fullName = firstname + ' ' + lastname;

                        if (window.confirm('Apakah anda yakin ingin menghapus data ' + fullName + '?')){
                            $.ajax({
                                method: 'POST',
                                data: {
                                    user_id: userId
                                }, 
                                url: 'delete_users.php';
                            })
                        } else {
                            console.log('Tidak terhapus');
                        }
                    }
                });
            }
        }
        var script = new script;
        script.initialize();
    </script>
</body>
</html>
