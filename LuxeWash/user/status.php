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
    <title>Status Cucian - Luxe Wash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #ffe0f0, #fff0f5);
            font-family: 'Segoe UI', sans-serif;
            padding-top: 50px;
            color: #333;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 10px 30px rgba(255, 105, 180, 0.15);
            max-width: 900px;
        }
        h3 {
            color: #ff4fa0;
            font-weight: bold;
            text-align: center;
        }
        .btn-back {
            background-color: #ff69b4;
            color: white;
            border-radius: 10px;
        }
        .btn-back:hover {
            background-color: #ff4f9a;
        }
        table th {
            background-color: #ffe6ef;
            color: #ff1493;
        }
        table tbody tr:hover {
            background-color: #fff5f9;
        }
        .table {
            border-radius: 15px;
            overflow: hidden;
        }
        .status-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .status-header img {
            max-width: 120px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container shadow-sm">
    <div class="status-header">
        <img src="../assets/images/logo.png" alt="Status Icon">
        <h3>Status Cucian Anda</h3>
    </div>
    <p>Halo <strong><?= htmlspecialchars($username) ?></strong>, berikut adalah status cucian Anda:</p>

    <?php
    $query = mysqli_query($conn, "SELECT * FROM transaksi WHERE user_id = '$user_id' ORDER BY tanggal DESC");

    if (mysqli_num_rows($query) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars(ucfirst($row['status'])) ?></td>
                        <td><?= htmlspecialchars($row['tanggal']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-muted mt-4">Belum ada cucian yang terdaftar.</p>
    <?php endif; ?>

    <div class="text-end">
        <a href="dashboard.php" class="btn btn-back mt-4">Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>
