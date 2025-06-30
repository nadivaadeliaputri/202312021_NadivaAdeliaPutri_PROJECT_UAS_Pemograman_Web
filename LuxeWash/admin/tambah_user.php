<?php
include '../includes/db.php';
include '../includes/auth.php';

$err = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role_id = $_POST['role_id'];

  $insert = mysqli_query($conn, "INSERT INTO users (username, full_name, email, phone, password, role_id, created_at)
                                VALUES ('$username', '$full_name', '$email', '$phone', '$password', '$role_id', NOW())");

  if ($insert) {
    header('Location: users.php');
    exit;
  } else {
    $err = 'Gagal menambahkan pengguna.';
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Pengguna - Luxe Wash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #ffe6f0, #fff0f5);
      font-family: 'Poppins', sans-serif;
    }
    .btn-pink {
      background-color: #ff69b4;
      color: white;
    }
    .btn-pink:hover {
      background-color: #ff85c1;
    }
    .card {
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(255, 105, 180, 0.1);
      background-color: white;
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <div class="card">
    <h3 class="mb-4 text-pink">➕ Tambah Pengguna Baru</h3>

    <?php if ($err): ?>
      <div class="alert alert-danger"><?= $err ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="full_name" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">No HP</label>
          <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Role</label>
          <select name="role_id" class="form-select" required>
            <option value="">-- Pilih Role --</option>
            <option value="1">Admin</option>
            <option value="2">User</option>
          </select>
        </div>
      </div>
      <div class="mt-4">
        <a href="users.php" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-pink">Simpan</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>
