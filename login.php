<?php
session_start();

$error = "";

$username_benar = "admin";
$password_benar = "123";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username === $username_benar && $password === $password_benar) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        header("location:dashboard.php");
        exit;
    }   else {
        $error = "gagal cik";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logen</title>
     <style>
        body {
            background: #f4f4f4;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: #fff;
            padding: 30px;
            width: 300px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background: #0486ff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background:  #0486ff;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        img {
        padding:10px;
        margin-top: 10%;
        width: 50%;
        
        

        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Form</h2>

       <?php if($error != "") { ?>
        <div class="error" <?= $error ?>
            <?php } ?>

        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>
            <button type="submit" name="login">Login</button>
</Form>
</div>
        <img src="image.png">
</body>
</html>
