<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../auth/login.php');
    exit;
}

include '../includes/db.php';

$error = '';
$success = '';

// Ambil data layanan & user
$layanan = mysqli_query($conn, "SELECT * FROM layanan ORDER BY nama_layanan ASC");
$users = mysqli_query($conn, "SELECT * FROM users WHERE role_id = 2 ORDER BY username ASC");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    $layanan_id = $_POST['layanan_id'] ?? '';
    $berat = $_POST['berat'] ?? '';
    $status = $_POST['status'] ?? 'proses';

    if ($user_id && $layanan_id && $berat) {
        $layanan_query = mysqli_query($conn, "SELECT * FROM layanan WHERE id = '$layanan_id'");
        $layanan_data = mysqli_fetch_assoc($layanan_query);
        $harga = $layanan_data['harga'];
        $total = $berat * $harga;

        $query = "INSERT INTO transaksi (user_id, layanan_id, berat, total, status, tanggal) 
                  VALUES ('$user_id', '$layanan_id', '$berat', '$total', '$status', NOW())";

        if (mysqli_query($conn, $query)) {
            $success = "Transaksi berhasil ditambahkan.";
        } else {
            $error = "Gagal menambahkan transaksi. " . mysqli_error($conn);
        }
    } else {
        $error = "Semua field harus diisi!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Transaksi - Luxe Wash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #fff0f5; font-family: 'Segoe UI', sans-serif; }
        .container {
            max-width: 700px;
            margin: 50px auto;
            background: white;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 10px 25px rgba(255, 105, 180, 0.15);
        }
        h4 { color: #ff69b4; font-weight: bold; }
        .btn-pink {
            background-color: #ff69b4;
            color: white;
            border-radius: 8px;
            border: none;
            padding: 8px 20px;
        }
        .btn-pink:hover {
            background-color: #ff85c1;
        }
        .btn-kembali {
            background-color: #ff69b4;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 8px 20px;
            font-weight: 500;
            transition: background-color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(255, 105, 180, 0.2);
            text-decoration: none;
        }
        .btn-kembali:hover {
            background-color: #ff85c1;
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>🧺 Tambah Transaksi</h4>
        <a href="transaksi.php" class="btn-kembali"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="user_id">Nama Pelanggan</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- Pilih Pelanggan --</option>
                <?php mysqli_data_seek($users, 0); while ($u = mysqli_fetch_assoc($users)) : ?>
                    <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['username']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="layanan_id">Layanan</label>
            <select name="layanan_id" class="form-select" required>
                <option value="">-- Pilih Layanan --</option>
                <?php mysqli_data_seek($layanan, 0); while ($l = mysqli_fetch_assoc($layanan)) : ?>
                    <option value="<?= $l['id'] ?>">
                        <?= htmlspecialchars($l['nama_layanan']) ?> (Rp<?= number_format($l['harga'], 0, ',', '.') ?>/kg)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="berat">Berat Cucian (kg)</label>
            <input type="number" step="0.1" name="berat" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-select" required>
                <option value="proses">Proses</option>
                <option value="selesai">Selesai</option>
                <option value="diambil">Diambil</option>
            </select>
        </div>

        <button type="submit" class="btn btn-pink">Simpan Transaksi</button>
    </form>
</div>
</body>
</html>
