<?php
include '../includes/db.php';
include '../includes/auth.php';

$id = $_GET['id'] ?? 0;
$result = mysqli_query($conn, "SELECT * FROM layanan WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_layanan = mysqli_real_escape_string($conn, $_POST['nama_layanan']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);

    $update = mysqli_query($conn, "UPDATE layanan SET nama_layanan='$nama_layanan', harga='$harga' WHERE id=$id");
    if ($update) {
        header("Location: layanan.php?success=1");
        exit;
    } else {
        $error = "Gagal mengupdate data.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Layanan - Luxe Wash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card mx-auto shadow" style="max-width: 500px;">
    <div class="card-body">
      <h4 class="text-center text-pink">Edit Layanan 🧺</h4>
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>
      <form method="POST">
        <div class="mb-3">
          <label>Nama Layanan</label>
          <input type="text" name="nama_layanan" class="form-control" value="<?= htmlspecialchars($data['nama_layanan']) ?>" required>
        </div>
        <div class="mb-3">
          <label>Harga (Rp)</label>
          <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required>
        </div>
        <button class="btn btn-pink w-100">Simpan Perubahan</button>
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
