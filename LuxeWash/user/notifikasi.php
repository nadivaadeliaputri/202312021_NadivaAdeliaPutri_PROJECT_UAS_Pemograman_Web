<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}
require_once '../includes/db.php';

$user_id = $_SESSION['user']['id'];
$success = $error = '';

// Ambil daftar layanan
$layanan = mysqli_query($conn, "SELECT * FROM layanan");

// Proses form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $layanan_id = $_POST['layanan_id'];
    $berat = floatval($_POST['berat']);
    $catatan = trim($_POST['catatan']);
    $tanggal = date('Y-m-d');

    // Ambil harga layanan
    $query = mysqli_query($conn, "SELECT harga FROM layanan WHERE id = $layanan_id");
    $data = mysqli_fetch_assoc($query);
    $harga = $data['harga'];
    $total = $harga * $berat;

    // Generate kode transaksi unik
    $kode = 'TRX' . time();

    $insert = mysqli_query($conn, "
        INSERT INTO transaksi (user_id, layanan_id, kode_transaksi, tanggal, status, total, berat, catatan) 
        VALUES ($user_id, $layanan_id, '$kode', '$tanggal', 'proses', $total, $berat, '$catatan')
    ");

    if ($insert) {
        $success = "Transaksi berhasil disimpan!";
    } else {
        $error = "Gagal menyimpan transaksi.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Transaksi Laundry - Luxe Wash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #ffe0f0, #fff0f8);
            font-family: 'Segoe UI', sans-serif;
        }
        .form-box {
            max-width: 600px;
            margin: 60px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(255, 105, 180, 0.2);
        }
        h3 {
            color: #ff4da6;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-pink {
            background-color: #ff5ca1;
            color: white;
            font-weight: bold;
            border-radius: 30px;
        }
        .btn-pink:hover {
            background-color: #ff3b90;
        }
    </style>
</head>
<body>
<div class="form-box">
    <h3>🧼 Input Transaksi Laundry</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Layanan</label>
            <select name="layanan_id" class="form-select" required>
                <option value="">-- Pilih Layanan --</option>
                <?php while ($l = mysqli_fetch_assoc($layanan)): ?>
                    <option value="<?= $l['id'] ?>"><?= $l['nama'] ?> - Rp <?= number_format($l['harga'], 0, ',', '.') ?>/kg</option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Berat Cucian (kg)</label>
            <input type="number" name="berat" class="form-control" step="0.1" min="1" required>
        </div>
        <div class="mb-3">
            <label>Catatan (opsional)</label>
            <textarea name="catatan" class="form-control" placeholder="Contoh: Jangan dicampur, parfum khusus, dll..."></textarea>
        </div>
        <button type="submit" class="btn btn-pink w-100">Simpan Transaksi</button>
    </form>

    <div class="text-center mt-4">
        <a href="dashboard.php" class="btn btn-outline-secondary">⬅️ Kembali ke Dashboard</a>
    </div>
</div>
</body>
</html>
