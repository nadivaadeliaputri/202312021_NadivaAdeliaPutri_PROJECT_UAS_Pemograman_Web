<?php
session_start();
include '../includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' LIMIT 1");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role_id'] = $user['role_id'];

        // Redirect berdasarkan role
        if ($user['role_id'] == 1) {
            header("Location: ../admin/dashboard.php"); // Ubah jika nama file berbeda
            exit;
        } elseif ($user['role_id'] == 2) {
            header("Location: ../user/dashboard.php");
            exit;
        } else {
            $error = "Role tidak dikenali.";
        }
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Luxe Wash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #ffd6e8, #ffe6f0);
            font-family: 'Segoe UI', sans-serif;
        }
        .login-box {
            max-width: 400px;
            margin: 80px auto;
            padding: 40px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(255, 105, 180, 0.2);
            text-align: center;
        }
        .login-box h2 {
            color: #ff4fa0;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .btn-login {
            background-color: #ff69b4;
            color: white;
            border-radius: 10px;
        }
        .btn-login:hover {
            background-color: #ff4fa0;
        }
        .logo {
            width: 80px;
            margin: -70px auto 20px;
            background: #fff;
            padding: 15px;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="login-box">
    <img src="../assets/images/logo.png" alt="Logo" class="logo">
    <h2>Login - Luxe Wash</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-login w-100">Login</button>
    </form>

    <p class="mt-3">Belum punya akun? <a href="register.php" style="color:#ff4fa0;">Daftar di sini</a></p>
</div>

</body>
</html>
