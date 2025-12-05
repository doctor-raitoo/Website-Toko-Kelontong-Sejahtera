<?php
    session_start();

    if(isset($_SESSION['user'])) header('location: dashboard.php');

    $errorMessage = '';

    if ($_POST){

        include('koneksi.php');

        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = 'SELECT * FROM pengguna WHERE pengguna.email ="' . $username . '" AND pengguna.password="'. $password.'"';
        $stmt = $conn -> prepare($query);
        $stmt -> execute();

        if($stmt->rowCount() > 0){
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $user = $stmt->fetchAll()[0];


            $_SESSION['user'] = $user;

            header('Location: dashboard.php');
        } else $errorMessage = 'Pastikan email dan password yang anda masukkan sudah benar';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Manajemen Toko Kelontong Sejahtera</title>
    <link rel="stylesheet" href="style.css">
</head>
<body id="loginBody">
    <?php 
        if(!empty($errorMessage)) {
    ?>

    <div id="errorMessage">
        <strong>ERROR: </strong> <p><?= $errorMessage ?> </p>
    </div>
    
    <?php } ?>
    <div class="container">
    <div class="loginHeader">
        <h1>STOKS</h1>
        <p>Sistem Informasi Toko Kelontong Sejahtera</p>
    </div>
    <div class="loginBody">
        <form action="login.php" method="POST">
            <div class="loginInput">
                <label for="">Username</label>
                <input type="text" name="username" placeholder="Username">
            </div>
            <div class="loginInput">
                <label for="">Password</label>
                <input type="password" name="password" placeholder="Password">
            </div>
            <div class="loginButton">
                <button>Login</button>
            </div>
        </form>
    </div>
    </div>
</body>
</html>