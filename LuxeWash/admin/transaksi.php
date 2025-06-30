<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

// Ambil data transaksi dengan JOIN ke tabel users dan layanan
$query = mysqli_query($conn, "
    SELECT transaksi.*, users.username, layanan.nama_layanan AS layanan_nama
    FROM transaksi
    JOIN users ON transaksi.user_id = users.id
    JOIN layanan ON transaksi.layanan_id = layanan.id
    ORDER BY transaksi.tanggal DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manajemen Transaksi - Luxe Wash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #fef6f9;
      font-family: 'Segoe UI', sans-serif;
    }
    .container {
      max-width: 1100px;
      margin: 40px auto;
      background-color: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0px 10px 20px rgba(255, 105, 180, 0.1);
    }
    h4 {
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
    }
    .table thead {
      background-color: #ffe0f0;
      color: #d63384;
    }
    .badge {
      font-size: 0.85rem;
      text-transform: lowercase;
    }
  </style>
</head>
<body>

<div class="container">
  <h4><i class="bi bi-journal-text"></i> Daftar Transaksi Laundry</h4>
  
  <div class="mb-3 d-flex justify-content-between">
    <a href="dashboard.php" class="btn btn-outline-pink">
      <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>
    <a href="transaksi_add.php" class="btn btn-pink">
      <i class="bi bi-plus-circle"></i> Tambah Transaksi
    </a>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
      <thead>
        <tr>
          <th>No</th>
          <th>Pelanggan</th>
          <th>Layanan</th>
          <th>Berat (kg)</th>
          <th>Total</th>
          <th>Status</th>
          <th>Tanggal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; if (mysqli_num_rows($query) > 0): while($row = mysqli_fetch_assoc($query)): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['layanan_nama']) ?></td>
          <td><?= $row['berat'] ?></td>
          <td>Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
          <td>
            <span class="badge bg-<?= $row['status'] === 'selesai' ? 'secondary' : ($row['status'] === 'diambil' ? 'success' : 'warning') ?>">
              <?= htmlspecialchars($row['status']) ?>
            </span>
          </td>
          <td><?= date('d-m-Y H:i', strtotime($row['tanggal'])) ?></td>
          <td>
            <a href="transaksi_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="transaksi_delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
            <a href="transaksi_struk_multi.php?id=<?= $row['id'] ?>" target="_blank" class="btn btn-sm btn-info">Cetak</a>
          </td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="8">Belum ada data transaksi.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
