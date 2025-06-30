<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../auth/login.php');
    exit;
}

include '../includes/db.php';
$result = mysqli_query($conn, "SELECT * FROM layanan ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Daftar Layanan - Luxe Wash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #fff0f5;
      font-family: 'Segoe UI', sans-serif;
    }
    .container {
      max-width: 1000px;
      margin: 40px auto;
      background-color: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0px 10px 20px rgba(255, 105, 180, 0.1);
    }
    h3 {
      color: #d63384;
      font-weight: bold;
      margin-bottom: 25px;
    }
    .btn-pink {
      background-color: #ff69b4;
      color: white;
      border-radius: 8px;
      border: none;
    }
    .btn-pink:hover {
      background-color: #ff85c1;
    }
    .btn-outline-pink {
      border: 2px solid #ff69b4;
      color: #ff69b4;
      border-radius: 8px;
      background-color: white;
    }
    .btn-outline-pink:hover {
      background-color: #ffe6f0;
      color: #ff69b4;
    }
    .table thead {
      background-color: #ffcfe2;
      color: #d63384;
    }
    .btn-warning, .btn-danger {
      border-radius: 6px;
    }
  </style>
</head>
<body>

<div class="container">
  <h3>🧺 Daftar Layanan</h3>
  
  <div class="mb-3 mt-3 d-flex justify-content-between">
    <a href="dashboard.php" class="btn btn-outline-pink">
      <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>
    <a href="layanan_add.php" class="btn btn-pink">
      <i class="bi bi-plus-circle"></i> Tambah Layanan
    </a>
  </div>
<?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
  <div class="alert alert-danger text-center">
    Layanan tidak bisa dihapus karena sedang digunakan dalam transaksi.
  </div>
<?php elseif (isset($_GET['success']) && $_GET['success'] == 1): ?>
  <div class="alert alert-success text-center">
    Layanan berhasil dihapus.
  </div>
<?php endif; ?>

  <table class="table table-bordered align-middle text-center">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Layanan</th>
        <th>Harga (Rp)</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) :
      ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($row['nama_layanan']); ?></td>
        <td><?= number_format($row['harga'], 0, ',', '.'); ?></td>
        <td>
          <a href="layanan_edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="layanan_delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus layanan ini?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>
