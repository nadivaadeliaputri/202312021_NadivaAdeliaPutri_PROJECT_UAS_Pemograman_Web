<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Username atau Email sudah terdaftar.";
    } else {
        $role_id = 2; // default user
        $query = mysqli_query($conn, "INSERT INTO users (username, password, full_name, email, phone, role_id, created_at) VALUES ('$username', '$password', '$full_name', '$email', '$phone', $role_id, NOW())");
        if ($query) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Gagal mendaftar. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - Luxe Wash</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #ffe6f0, #ffd9ec);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .register-box {
            background-color: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(255, 105, 180, 0.3);
            width: 400px;
            text-align: center;
            position: relative;
        }
        .logo-circle {
            background-color: #fff0f5;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            position: absolute;
            top: -45px;
            left: calc(50% - 45px);
            box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-circle img {
            max-width: 60%;
        }
        .btn-pink {
            background-color: #ff5ca1;
            color: white;
            border: none;
        }
        .btn-pink:hover {
            background-color: #ff3c8d;
        }
        .text-pink {
            color: #ff5ca1;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <div class="logo-circle">
            <img src="../assets/images/luxe_logo.png" alt="Luxe Wash Logo">
        </div>
        <h4 class="mt-5 mb-4 text-pink fw-bold">Daftar - Luxe Wash</h4>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3 text-start">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="mb-3 text-start">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="mb-3 text-start">
                <input type="text" class="form-control" name="full_name" placeholder="Nama Lengkap" required>
            </div>
            <div class="mb-3 text-start">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="mb-3 text-start">
                <input type="text" class="form-control" name="phone" placeholder="No. Telepon" required>
            </div>
            <button type="submit" class="btn btn-pink w-100 mb-3">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.php" class="text-pink">Login di sini</a></p>
    </div>
</body>
</html>
