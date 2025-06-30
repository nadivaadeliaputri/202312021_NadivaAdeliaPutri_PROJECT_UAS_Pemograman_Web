<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

// Simpan pengaturan jika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $wa = $_POST['nomor_wa'];
    $alamat = $_POST['alamat'];

    mysqli_query($conn, "UPDATE pengaturan SET nilai_pengaturan='$nama' WHERE nama_pengaturan='nama_laundry'");
    mysqli_query($conn, "UPDATE pengaturan SET nilai_pengaturan='$wa' WHERE nama_pengaturan='nomor_wa'");
    mysqli_query($conn, "UPDATE pengaturan SET nilai_pengaturan='$alamat' WHERE nama_pengaturan='alamat'");

    header("Location: pengaturan.php?update=1");
    exit;
}

// Ambil data
function get_pengaturan($key) {
    global $conn;
    $q = mysqli_query($conn, "SELECT nilai_pengaturan FROM pengaturan WHERE nama_pengaturan='$key'");
    $d = mysqli_fetch_assoc($q);
    return $d['nilai_pengaturan'] ?? '';
}

$nama_laundry = get_pengaturan('nama_laundry');
$nomor_wa = get_pengaturan('nomor_wa');
$alamat = get_pengaturan('alamat');
?>

<!DOCTYPE html>
<html>
<head>
  <title>Pengaturan - Luxe Wash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fff0f6;
      font-family: 'Poppins', sans-serif;
    }
    .container {
      max-width: 600px;
      margin-top: 60px;
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(255, 105, 180, 0.2);
    }
    .text-pink { color: #d63384; font-weight: bold; }
    .btn-pink { background-color: #ff69b4; color: white; }
    .btn-pink:hover { background-color: #ff1493; }
  </style>
</head>
<body>
  <div class="container">
    <h4 class="text-pink mb-4">⚙️ Pengaturan Aplikasi</h4>

    <?php if (isset($_GET['update'])): ?>
      <div class="alert alert-success">✔️ Pengaturan berhasil diperbarui.</div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nama Laundry</label>
        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($nama_laundry) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Nomor WhatsApp/CS</label>
        <input type="text" name="nomor_wa" class="form-control" value="<?= htmlspecialchars($nomor_wa) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Alamat Laundry</label>
        <textarea name="alamat" class="form-control" rows="3" required><?= htmlspecialchars($alamat) ?></textarea>
      </div>
      <button class="btn btn-pink" type="submit">💾 Simpan Pengaturan</button>
    </form>
  </div>
</body>
</html>
