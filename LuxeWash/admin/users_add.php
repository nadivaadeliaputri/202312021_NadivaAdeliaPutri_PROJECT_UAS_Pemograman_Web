<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: ../auth/login.php");
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pengguna - Luxe Wash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fff0f5; }
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            color: #ff69b4;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h3 class="form-title">Tambah Pengguna</h3>
        <form action="proses_tambah_user.php" method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="1">Admin</option>
                    <option value="2">User</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100" style="background-color:#ff69b4; border:none;">Simpan</button>
        </form>
    </div>
</body>
</html>
