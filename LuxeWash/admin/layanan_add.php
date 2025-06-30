<?php
include '../includes/db.php';
include '../includes/auth.php';

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);

    $query = "INSERT INTO layanan (nama, harga) VALUES ('$nama', '$harga')";
    if (mysqli_query($conn, $query)) {
        header('Location: layanan.php?success=1');
        exit;
    } else {
        $error = "Gagal menambah layanan.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah Layanan - Luxe Wash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card mx-auto shadow" style="max-width: 500px;">
    <div class="card-body">
      <h4 class="text-center text-pink">Tambah Layanan 🧺</h4>
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>
      <form method="POST">
        <div class="mb-3">
          <label>Nama Layanan</label>
          <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Harga (Rp)</label>
          <input type="number" name="harga" class="form-control" required>
        </div>
        <button class="btn btn-pink w-100">Simpan</button>
        <a href="layanan.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
      </form>
    </div>
  </div>
</div>

<style>
  .btn-pink { background-color: #ff69b4; color: white; }
  .text-pink { color: #ff69b4; }
</style>
</body>
</html>
