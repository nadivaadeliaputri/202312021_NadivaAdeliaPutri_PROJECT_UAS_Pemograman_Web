<?php
include '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID tidak ditemukan.";
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "Pengguna tidak ditemukan.";
    exit;
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
  <h3>Edit Pengguna</h3>
  <form action="proses_edit_user.php" method="POST">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Password Baru (kosongkan jika tidak ingin mengubah)</label>
      <input type="password" name="password" class="form-control">
    </div>
    <div class="mb-3">
      <label>Role</label>
      <select name="role" class="form-control" required>
        <option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Admin</option>
        <option value="2" <?= $user['role'] == 2 ? 'selected' : '' ?>>User</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="users.php" class="btn btn-secondary">Batal</a>
  </form>
</div>
</body>
</html>
