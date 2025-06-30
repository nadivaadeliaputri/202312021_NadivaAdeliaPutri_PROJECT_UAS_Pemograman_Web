<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

// Ambil ID transaksi
$id = $_GET['id'] ?? 0;

// Fungsi ambil pengaturan
function get_pengaturan($key) {
    global $conn;
    $q = mysqli_query($conn, "SELECT nilai_pengaturan FROM pengaturan WHERE nama_pengaturan='$key'");
    $d = mysqli_fetch_assoc($q);
    return $d['nilai_pengaturan'] ?? '';
}

// Ambil pengaturan
$nama_laundry = get_pengaturan('nama_laundry');
$nomor_wa     = get_pengaturan('nomor_wa');
$alamat       = get_pengaturan('alamat');

// Ambil data transaksi
$transaksi = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT t.*, u.username, l.nama_layanan, l.harga
    FROM transaksi t
    JOIN users u ON t.user_id = u.id
    JOIN layanan l ON t.layanan_id = l.id
    WHERE t.id = $id
"));

if (!$transaksi) {
    echo "<h3 style='color:red; text-align:center;'>❌ Data transaksi tidak ditemukan.</h3>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Struk Transaksi - <?= htmlspecialchars($nama_laundry) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff0f6;
      padding: 30px;
      color: #333;
    }
    .struk-box {
      border: 2px dashed #ff69b4;
      padding: 30px;
      width: 500px;
      margin: auto;
      background-color: white;
      border-radius: 20px;
      box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
    }
    .logo {
      display: block;
      margin: auto;
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
    }
    h2 {
      text-align: center;
      color: #d63384;
      margin-bottom: 5px;
    }
    p.title {
      text-align: center;
      margin-bottom: 25px;
      font-size: 16px;
      color: #555;
    }
    .info {
      margin-top: 10px;
    }
    .info td {
      padding: 6px 10px;
      vertical-align: top;
      font-size: 14px;
    }
    .footer {
      text-align: center;
      margin-top: 30px;
      font-size: 13px;
      color: #777;
    }
    @media print {
      body {
        margin: 0;
        background-color: white;
      }
      .footer {
        font-size: 11px;
      }
    }
  </style>
  <script>
    window.onload = function() {
      window.print();
      setTimeout(() => window.close(), 1000);
    };
  </script>
</head>
<body>
<div class="struk-box">
  <img src="../assets/images/logo.png" alt="Logo" class="logo">
  <h2><?= htmlspecialchars($nama_laundry) ?></h2>
  <p class="title">Struk Transaksi</p>

  <table class="info">
    <tr><td><strong>Pelanggan</strong></td><td>: <?= htmlspecialchars($transaksi['username']) ?></td></tr>
    <tr><td><strong>Layanan</strong></td><td>: <?= htmlspecialchars($transaksi['nama_layanan']) ?></td></tr>
    <tr><td><strong>Berat</strong></td><td>: <?= $transaksi['berat'] ?> kg</td></tr>
    <tr><td><strong>Harga/kg</strong></td><td>: Rp<?= number_format($transaksi['harga'], 0, ',', '.') ?></td></tr>
    <tr><td><strong>Total</strong></td><td>: Rp<?= number_format($transaksi['total'], 0, ',', '.') ?></td></tr>
    <tr><td><strong>Status</strong></td><td>: <?= ucfirst($transaksi['status']) ?></td></tr>
    <tr><td><strong>Tanggal</strong></td><td>: <?= date('d-m-Y H:i', strtotime($transaksi['tanggal'])) ?></td></tr>
    <?php if (!empty($transaksi['waktu_pengambilan'])): ?>
    <tr><td><strong>Waktu Pengambilan</strong></td><td>: <?= date('d-m-Y H:i', strtotime($transaksi['waktu_pengambilan'])) ?></td></tr>
    <?php endif; ?>
  </table>

  <div class="footer">
    <?= htmlspecialchars($alamat) ?><br>
    📞 <?= htmlspecialchars($nomor_wa) ?><br><br>
    ✨ Terima kasih telah mempercayakan cucian Anda kepada <strong style="color:#d63384;"><?= htmlspecialchars($nama_laundry) ?></strong> ✨
  </div>
</div>
</body>
</html>
