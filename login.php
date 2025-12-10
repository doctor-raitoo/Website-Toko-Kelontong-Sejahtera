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

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">

    <style>
        body#loginBody {
            background: url('image/gambar2.png') no-repeat center center fixed;
            background-size: cover;
            font-family: "Montserrat";
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        #errorMessage {
            max-width: 500px;
            margin: 20px auto;
            background: rgba(255, 0, 0, 0.25);
            padding: 15px;
            color: white;
            font-size: 18px;
            backdrop-filter: blur(6px);
            border-radius: 10px;
        }

        .container {
            width: 100%;
            max-width: 480px;
        }

        .loginHeader h1 {
            font-size: 60px;
            font-weight: bold;
            text-align: center;
            color: blue;
            letter-spacing: 2px;
            font-style: italic;
            margin-bottom: 10px;
        }

        .loginHeader p {
            text-align: center;
            font-size: 20px;
            color: #f1f1f1;
            margin-bottom: 20px;
        }

        .loginBody form {
            background: rgba(255, 255, 255, 0.18);
            padding: 35px 40px; /* ← lebih kecil dan simetris */
            border-radius: 18px;
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.25);
            box-sizing: border-box;
            text-align: left; /* ← memastikan form rata kiri */
        }

        .loginInput label {
            font-size: 16px;
            font-weight: 600;
            color: white;
            display: block;
            margin-bottom: 6px;
        }

        .loginInput input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 10px;
            border: none;          
            outline: none;
            background: rgba(255,255,255,0.9);
            transition: .25s;
            box-sizing: border-box;
        }

        .loginInput input:focus {
            background: white;
            box-shadow: 0 0 8px rgba(30,102,255,0.5);
        }

        .loginInput {
            margin-top: 22px;
        }

        .loginButton button {
            margin-top: 30px;
            width: 100%;
            padding: 14px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 10px;
            border: none; 
            background: linear-gradient(135deg, #1e66ff, #0a4ed1);
            color: white;
            cursor: pointer;
            transition: .25s;
        }

        .loginButton button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(30,102,255,0.4);
        }
    </style>
</head>

<body id="loginBody">

    <?php if(!empty($errorMessage)) { ?>
        <div id="errorMessage">
            <strong>ERROR: </strong> <p><?= $errorMessage ?></p>
        </div>
    <?php } ?>

    <div class="container">
        <div class="loginHeader">
            <h1>STOKS</h1>
        </div>

        <div class="loginBody">
            <form action="login.php" method="POST">
                <div class="loginInput">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username">
                </div>

                <div class="loginInput">
                    <label>Password</label>
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
