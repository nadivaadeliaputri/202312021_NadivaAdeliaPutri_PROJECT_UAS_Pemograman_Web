<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

$id = $_GET['id'] ?? 0;
$query = mysqli_query($conn, "SELECT * FROM transaksi WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? 'diproses';
    $update = mysqli_query($conn, "UPDATE transaksi SET status='$status' WHERE id=$id");

    if ($update) {
        header("Location: transaksi.php?success=1");
        exit;
    } else {
        $error = "Gagal mengupdate status.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Status Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fff0f5;
    }
    .btn-pink {
      background-color: #ff69b4;
      color: white;
      border: none;
    }
    .btn-pink:hover {
      background-color: #ff85c1;
    }
    .text-pink {
      color: #ff69b4;
    }
  </style>
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow mx-auto" style="max-width: 400px;">
    <div class="card-body">
      <h4 class="text-center text-pink">Ubah Status Transaksi</h4>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Status Cucian</label>
          <select name="status" class="form-select" required>
            <option value="diproses" <?= $data['status'] == 'diproses' ? 'selected' : '' ?>>Diproses</option>
            <option value="selesai" <?= $data['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
            <option value="diambil" <?= $data['status'] == 'diambil' ? 'selected' : '' ?>>Diambil</option>
          </select>
        </div>
        <button type="submit" class="btn btn-pink w-100">💾 Simpan</button>
        <a href="transaksi.php" class="btn btn-outline-secondary w-100 mt-2">← Kembali</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
