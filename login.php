<?php
session_start();

$username_benar = "admin";
$password_benar = "123";

$error = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === $username_benar && $password === $password_benar) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        header("location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

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
            background: #000;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #333;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Form Login</h2>

    <?php if ($error != "") { ?>
        <div class="error"><?= $error ?></div>
    <?php } ?>

    <form method="post">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>
    
