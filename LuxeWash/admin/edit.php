<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header('Location: ../auth/login.php');
    exit;
}
include '../includes/db.php';

$id = $_GET['id'] ?? 0;
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $id"));

if (!$user) {
    echo "User tidak ditemukan."; exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $role_id = $_POST['role_id'];

    $query = "UPDATE users SET full_name='$full_name', email='$email', phone='$phone', role_id='$role_id' WHERE id=$id";

    if (mysqli_query($conn, $query)) {
        header('Location: users.php');
        exit;
    } else {
        $error = "Gagal mengupdate user: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Pengguna - Luxe Wash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h3 class="text-pink">✏️ Edit Pengguna</h3>
  <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="POST">
    <input name="full_name" class="form-control mb-2" placeholder="Nama Lengkap" value="<?= $user['full_name'] ?>" required>
    <input name="email" type="email" class="form-control mb-2" placeholder="Email" value="<?= $user['email'] ?>">
    <input name="phone" class="form-control mb-2" placeholder="No. HP" value="<?= $user['phone'] ?>">
    <select name="role_id" class="form-control mb-3" required>
      <option value="1" <?= $user['role_id'] == 1 ? 'selected' : '' ?>>Admin</option>
      <option value="2" <?= $user['role_id'] == 2 ? 'selected' : '' ?>>User</option>
    </select>
    <button class="btn btn-pink">Update</button>
    <a href="users.php" class="btn btn-secondary">Batal</a>
  </form>
</div>
<style>.btn-pink { background-color: #ff69b4; color: white; }</style>
</body>
</html>
