<?php
session_start();
include '../includes/db.php';

$dari = $_GET['dari'] ?? '';
$sampai = $_GET['sampai'] ?? '';
$status = strtolower($_GET['status'] ?? '');

$where = "1=1";
if (!empty($dari) && !empty($sampai)) {
    $where .= " AND DATE(tanggal) BETWEEN '$dari' AND '$sampai'";
}
if (!empty($status)) {
    $where .= " AND LOWER(transaksi.status) = '$status'";
}

$query = mysqli_query($conn, "
    SELECT transaksi.*, users.username, layanan.nama_layanan 
    FROM transaksi
    JOIN users ON transaksi.user_id = users.id
    JOIN layanan ON transaksi.layanan_id = layanan.id
    WHERE $where
    ORDER BY transaksi.tanggal DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Laporan Transaksi - Luxe Wash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #fff0f5;
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
    }
    .btn-pink {
      background-color: #ff69b4;
      color: white;
      border-radius: 8px;
    }
    .btn-pink:hover {
      background-color: #ff85c1;
    }
    .btn-outline-pink {
      border: 2px solid #ff69b4;
      color: #ff69b4;
      background-color: white;
      border-radius: 8px;
    }
    .btn-outline-pink:hover {
      background-color: #ffe6f0;
    }
    .table thead {
      background-color: #ffcfe2;
      color: #d63384;
    }
  </style>
</head>
<body>
<div class="container">
  <h4>📊 Laporan Transaksi Laundry</h4>

  <form method="get" class="row g-2 align-items-end mt-3 mb-4">
    <div class="col-md-3">
      <label>Dari Tanggal</label>
      <input type="date" name="dari" class="form-control" value="<?= htmlspecialchars($dari) ?>">
    </div>
    <div class="col-md-3">
      <label>Sampai Tanggal</label>
      <input type="date" name="sampai" class="form-control" value="<?= htmlspecialchars($sampai) ?>">
    </div>
    <div class="col-md-3">
      <label>Status</label>
      <select name="status" class="form-select">
        <option value="">Semua Status</option>
        <option value="proses" <?= strtolower($status) == 'proses' ? 'selected' : '' ?>>Proses</option>
        <option value="selesai" <?= strtolower($status) == 'selesai' ? 'selected' : '' ?>>Selesai</option>
      </select>
    </div>
    <div class="col-md-3 d-flex">
      <button type="submit" class="btn btn-pink me-2">
        <i class="bi bi-funnel-fill"></i> Filter
      </button>
      <a href="dashboard.php" class="btn btn-outline-pink">
        <i class="bi bi-arrow-left-circle"></i> Kembali
      </a>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-bordered text-center align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Pelanggan</th>
          <th>Layanan</th>
          <th>Berat</th>
          <th>Total</th>
          <th>Status</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        if (mysqli_num_rows($query) > 0):
          while($row = mysqli_fetch_assoc($query)):
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['nama_layanan'] ?? '-') ?></td>
          <td><?= $row['berat'] ?> kg</td>
          <td>Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
          <td>
            <?php if (strtolower($row['status']) == 'selesai'): ?>
              <span class="badge bg-secondary">Selesai</span>
            <?php else: ?>
              <span class="badge bg-warning text-dark">Proses</span>
            <?php endif; ?>
          </td>
          <td><?= date('d-m-Y H:i', strtotime($row['tanggal'])) ?></td>
        </tr>
        <?php endwhile; else: ?>
        <tr>
          <td colspan="7">Tidak ada data transaksi.</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
