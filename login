<?php
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === "aby" && $password === "123") {
        $_SESSION['login'] = true;
        header("Location: coba.php");
        exit();
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <style>

        body {
            background: #f5f7fb;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        input {
            width: 50%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        button {
            width: 55%;
            padding: 12px;
            background: #1abc9c;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 15px;
        
        }

        button:hover {
            background: #16a085;
        }

        .error {
            background: #ffecec;
            color: #e74c3c;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-box">
        <h2>Login ToDo</h2>

        <?php if (isset($error)) { ?>
            <div class="error"><?= $error ?></div>
        <?php } ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</div>

</body>
</html>
