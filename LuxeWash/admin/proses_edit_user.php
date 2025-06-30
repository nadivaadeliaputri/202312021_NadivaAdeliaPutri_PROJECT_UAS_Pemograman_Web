<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php'; // agar hanya admin yang bisa akses

// Ambil data pengaturan
$pengaturan = [];
$query = mysqli_query($conn, "SELECT * FROM pengaturan");
while ($row = mysqli_fetch_assoc($query)) {
    $pengaturan[$row['nama_pengaturan']] = $row['nilai_pengaturan'];
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_laundry = $_POST['nama_laundry'];
    $nomor_wa = $_POST['nomor_wa'];
    $alamat = $_POST['alamat'];

    // Update masing-masing
    mysqli_query($conn, "UPDATE pengaturan SET nilai_pengaturan='$nama_laundry' WHERE nama_pengaturan='nama_laundry'");
    mysqli_query($conn, "UPDATE pengaturan SET nilai_pengaturan='$nomor_wa' WHERE nama_pengaturan='nomor_wa'");
    mysqli_query($conn, "UPDATE pengaturan SET nilai_pengaturan='$alamat' WHERE nama_pengaturan='alamat'");

    $_SESSION['success'] = "Pengaturan berhasil diperbarui!";
    header("Location: pengaturan.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Pengaturan Aplikasi - Luxe Wash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff0f5;
    }
    .container {
      max-width: 800px;
      margin: 40px auto;
      background-color: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(255, 105, 180, 0.1);
    }
    h4 {
      color: #d63384;
      font-weight: 600;
      margin-bottom: 25px;
    }
    .form-label {
      font-weight: 500;
      color: #d63384;
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
    .alert {
      font-size: 0.95rem;
    }
  </style>
</head>
<body>
<div class="container">
  <h4><i class="bi bi-gear-fill"></i> Pengaturan Aplikasi</h4>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Nama Laundry</label>
      <input type="text" name="nama_laundry" value="<?= htmlspecialchars($pengaturan['nama_laundry'] ?? '') ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Nomor WhatsApp / CS</label>
      <input type="text" name="nomor_wa" value="<?= htmlspecialchars($pengaturan['nomor_wa'] ?? '') ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Alamat Laundry</label>
      <textarea name="alamat" class="form-control" rows="3" required><?= htmlspecialchars($pengaturan['alamat'] ?? '') ?></textarea>
    </div>

    <button type="submit" class="btn btn-pink"><i class="bi bi-save"></i> Simpan Pengaturan</button>
  </form>
</div>
</body>
</html>
