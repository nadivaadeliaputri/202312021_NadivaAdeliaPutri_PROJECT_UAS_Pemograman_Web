<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../auth/login.php');
    exit;
}
include '../includes/db.php';

// Statistik
$userCount = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE role = 2"));
$transCount = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM transaksi"));
$layananCount = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM layanan"));

// Transaksi Terbaru
$log = mysqli_query($conn, "SELECT transaksi.id, users.username, transaksi.tanggal 
                            FROM transaksi 
                            JOIN users ON transaksi.user_id = users.id 
                            ORDER BY transaksi.tanggal DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin - Luxe Wash</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #ffe6f0, #fff0f5);
      font-family: 'Poppins', sans-serif;
    }

    .d-flex {
      flex-wrap: nowrap;
    }

    .sidebar {
      height: 100vh;
      background-color: #ffdee9;
      padding: 40px 15px 25px 15px;
      width: 230px;
      border-radius: 0 20px 20px 0;
      box-shadow: 2px 0 10px rgba(255, 105, 180, 0.1);
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 35px;
      padding-left: 5px;
    }

    .brand h4 {
      color: #ff4da6;
      font-weight: 600;
      margin: 0;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 15px;
      margin-bottom: 12px;
      border-radius: 8px;
      color: #333;
      font-weight: 500;
      text-decoration: none;
      transition: all 0.2s ease;
    }

    .sidebar a i {
      font-size: 1.25rem;
      color: #333;
      min-width: 24px;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #ffe6f2;
      color: #ff4da6;
      font-weight: 600;
      transform: translateX(5px);
    }

    .sidebar a:hover i,
    .sidebar a.active i {
      color: #ff4da6;
    }

    .logout-link {
      position: absolute;
      bottom: 20px;
      left: 15px;
    }

    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 6px 16px rgba(255, 105, 180, 0.15);
      background: #fff;
      transition: transform 0.3s ease;
      min-height: 160px;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card-title {
      color: #ff4da6;
      font-weight: 600;
      font-size: 1.2rem;
      margin-top: 10px;
    }

    .header {
      margin-bottom: 40px;
      color: #ff4da6;
    }

    .icon-lg {
      font-size: 2.5rem;
      color: #ff4da6;
    }

    .activity-box {
      margin-top: 50px;
      background: #fff0f6;
      padding: 20px 30px;
      border-radius: 20px;
      box-shadow: 0 4px 12px rgba(255, 105, 180, 0.1);
    }

    .activity-box h4 {
      color: #ff4da6;
      font-weight: 600;
      margin-bottom: 15px;
    }

    .activity-box ul {
      padding-left: 20px;
    }

    .activity-box ul li {
      margin-bottom: 6px;
      font-size: 0.95rem;
    }

    @media (max-width: 768px) {
      .d-flex {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        border-radius: 0;
        height: auto;
        padding: 20px;
      }

      .logout-link {
        position: static;
        margin-top: 20px;
      }
    }
  </style>
</head>
<body>
<div class="d-flex">
  <!-- Sidebar -->
  <div class="sidebar position-relative">
    <div class="brand">
      <img src="../assets/images/logo.png" alt="Logo Luxe Wash" width="40">
      <h4>Luxe Wash</h4>
    </div>
    <a href="dashboard.php" class="active"><i class="bi bi-house-heart-fill"></i> Dashboard</a>
    <a href="users.php"><i class="bi bi-people-fill"></i> Manajemen Pengguna</a>
    <a href="layanan.php"><i class="bi bi-droplet-fill"></i> Layanan</a>
    <a href="transaksi.php"><i class="bi bi-basket-fill"></i> Transaksi</a>
    <a href="laporan.php"><i class="bi bi-bar-chart-fill"></i> Laporan</a>
    <a href="../user/logout.php" class="text-danger logout-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>

  <!-- Main Content -->
  <div class="container p-5">
    <h2 class="header">👋 Selamat Datang, <b class="text-pink"><?= htmlspecialchars($_SESSION['username']); ?></b></h2>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="card text-center p-4">
          <div class="icon-lg mb-2"><i class="bi bi-people-fill"></i></div>
          <h5 class="card-title">Pengguna</h5>
          <h2><?= $userCount; ?></h2>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center p-4">
          <div class="icon-lg mb-2"><i class="bi bi-basket-fill"></i></div>
          <h5 class="card-title">Transaksi</h5>
          <h2><?= $transCount; ?></h2>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center p-4">
          <div class="icon-lg mb-2"><i class="bi bi-droplet-fill"></i></div>
          <h5 class="card-title">Layanan</h5>
          <h2><?= $layananCount; ?></h2>
        </div>
      </div>
    </div>

    <!-- Activity Log -->
    <div class="activity-box mt-5">
      <h4><i class="bi bi-clock-history me-2"></i>Riwayat Transaksi Terbaru</h4>
      <ul>
        <?php while ($row = mysqli_fetch_assoc($log)) : ?>
          <li><i class="bi bi-check2-circle text-pink me-1"></i>
            <?= htmlspecialchars($row['username']); ?> melakukan transaksi pada 
            <b><?= date('d M Y', strtotime($row['tanggal'])); ?></b>
          </li>
        <?php endwhile; ?>
      </ul>
    </div>
  </div>
</div>
</body>
</html>
