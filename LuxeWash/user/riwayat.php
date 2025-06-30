<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: ../auth/login.php");
    exit;
}

include '../includes/db.php';
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi - Luxe Wash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #ffe0f0, #fff0f5);
            font-family: 'Segoe UI', sans-serif;
            padding-top: 50px;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 10px 30px rgba(255, 105, 180, 0.15);
            max-width: 1000px;
        }
        h3 {
            color: #ff4fa0;
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
        }
        .btn-back {
            background-color: #ff69b4;
            color: white;
            border-radius: 10px;
        }
        .btn-back:hover {
            background-color: #ff4f9a;
        }
        table thead {
            background-color: #ffe6f0;
            color: #d63384;
        }
        table tbody tr:hover {
            background-color: #fff0f9;
        }
        .badge {
            padding: 6px 10px;
            font-size: 12px;
            border-radius: 10px;
        }
        .badge.selesai {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .badge.proses {
            background-color: #fff3cd;
            color: #664d03;
        }
        .badge.menunggu {
            background-color: #f8d7da;
            color: #842029;
        }
        .logo-img {
            max-width: 150px;
            display: block;
            margin: 0 auto 20px;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>
<body>

<div class="container shadow-sm">

    <!-- Gambar logo -->
    <img src="../assets/images/logo.png" alt="Logo Luxe Wash" class="logo-img img-fluid">

    <h3>Riwayat Transaksi</h3>
    <p class="mb-4 text-center">Berikut riwayat transaksi laundry Anda, <strong><?= htmlspecialchars($username) ?></strong>:</p>

    <?php
    $query = mysqli_query($conn, "
        SELECT t.*, l.nama_layanan 
        FROM transaksi t 
        LEFT JOIN layanan l ON t.layanan_id = l.id 
        WHERE t.user_id = '$user_id' 
        ORDER BY t.tanggal DESC
    ");

    if (mysqli_num_rows($query) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Layanan</th>
                        <th>Berat (kg)</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['nama_layanan'] ?? 'Tidak diketahui') ?></td>
                        <td><?= htmlspecialchars($row['berat']) ?></td>
                        <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                        <td>
                            <?php
                                $status = strtolower($row['status']);
                                $badgeClass = 'badge ';
                                if ($status == 'selesai') $badgeClass .= 'selesai';
                                elseif ($status == 'proses') $badgeClass .= 'proses';
                                else $badgeClass .= 'menunggu';
                            ?>
                            <span class="<?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                        </td>
                        <td><?= htmlspecialchars($row['tanggal']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-muted mt-3 text-center">Belum ada transaksi yang tercatat.</p>
    <?php endif; ?>

    <div class="text-end">
        <a href="dashboard.php" class="btn btn-back mt-4">Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>
