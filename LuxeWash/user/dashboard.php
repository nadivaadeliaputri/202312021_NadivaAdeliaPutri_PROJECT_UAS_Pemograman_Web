<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header('Location: ../auth/login.php');
    exit;
}

include '../includes/db.php';

$username = $_SESSION['username'];
$userId = $_SESSION['user_id'];

$jam = date('H');
$sapaan = 'Halo';
if ($jam >= 5 && $jam < 12) $sapaan = 'Selamat Pagi';
elseif ($jam >= 12 && $jam < 17) $sapaan = 'Selamat Siang';
elseif ($jam >= 17 && $jam < 20) $sapaan = 'Selamat Sore';
else $sapaan = 'Selamat Malam';

$images = glob('../assets/images/illustrations/*.png');
$imgPath = count($images) ? $images[array_rand($images)] : '../assets/images/dashboard_illustration.png';

$notif = "🔔 Belum ada transaksi laundry yang tercatat.";
$query = mysqli_query($conn, "SELECT status FROM transaksi WHERE user_id = $userId ORDER BY id DESC LIMIT 1");
$data = mysqli_fetch_assoc($query);
if ($data) {
    if ($data['status'] === 'Selesai') {
        $notif = "🎉 Cucian kamu sudah bisa diambil!";
    } elseif ($data['status'] === 'Proses') {
        $notif = "🌀 Cucian kamu sedang diproses...";
    } elseif ($data['status'] === '50%') {
        $notif = "⏳ Cucian kamu 50% selesai, ditunggu ya!";
    } else {
        $notif = "📦 Belum ada cucian aktif saat ini.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pengguna - Luxe Wash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #ffe6f0, #fff0f5);
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: #ffdee9;
      border-bottom-left-radius: 15px;
      border-bottom-right-radius: 15px;
      box-shadow: 0 4px 10px rgba(255, 105, 180, 0.05);
    }

    .navbar-brand, .nav-link {
      color: #ff4da6 !important;
      font-weight: 600;
    }

    .nav-link:hover {
      text-decoration: underline;
    }

    .container {
      max-width: 950px;
      background-color: #fff8fb;
      margin: 50px auto;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 6px 20px rgba(255, 105, 180, 0.1);
    }

    h2 {
      color: #ff4da6;
      font-weight: 600;
    }

    .dashboard-img {
      max-height: 240px;
      display: block;
      margin: 20px auto;
    }

    .notif {
      background-color: #ffe1ec;
      color: #ff4da6;
      font-weight: 500;
      padding: 15px 20px;
      border-left: 5px solid #ff4da6;
      border-radius: 12px;
      margin: 20px auto;
      text-align: center;
      max-width: 700px;
      box-shadow: 0 4px 12px rgba(255, 105, 180, 0.05);
    }

    .cards {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 30px;
      margin-top: 30px;
    }

    .card {
      width: 240px;
      height: 330px;
      background-color: white;
      border-radius: 20px;
      box-shadow: 0 6px 16px rgba(255, 105, 180, 0.15);
      padding: 20px;
      text-align: center;
      transition: transform 0.2s ease;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      align-items: stretch;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(255, 105, 180, 0.25);
    }

    .card-body {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      min-height: 180px;
    }

    .card-body i {
      font-size: 38px;
      color: #ff4da6;
      margin-bottom: 15px;
    }

    .card-body h5 {
      color: #ff4da6;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .card-body p {
      font-size: 14px;
      line-height: 1.4;
      margin: 0;
      padding: 0 10px;
      min-height: 40px;
    }

    .btn-pink {
      background-color: #ff4da6;
      color: white;
      border-radius: 10px;
      border: none;
      padding: 10px 0;
      width: 100%;
    }

    .btn-pink:hover {
      background-color: #ff80b3;
    }

    footer {
      margin-top: 40px;
      text-align: center;
      font-size: 0.9rem;
      color: #999;
    }

    @media (max-width: 768px) {
      .cards {
        flex-direction: column;
        align-items: center;
      }

      .container {
        margin: 20px;
        padding: 20px;
      }
    }

    /* 🔥 Animasi Tambahan */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes zoomIn {
      from { opacity: 0; transform: scale(0.8); }
      to { opacity: 1; transform: scale(1); }
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-4px); }
    }

    .fade-in {
      animation: fadeIn 0.8s ease-out;
    }

    .zoom-in {
      animation: zoomIn 0.5s ease-out;
    }

    .btn-animate:hover {
      animation: bounce 0.4s ease-in-out;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg shadow-sm">
  <div class="container-fluid px-4">
    <a class="navbar-brand fw-bold" href="#">Luxe Wash</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="status.php">Status Cucian</a></li>
        <li class="nav-item"><a class="nav-link" href="riwayat.php">Riwayat</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container fade-in">
  <div class="text-center">
    <h2><?= $sapaan ?>, <?= htmlspecialchars($username) ?>!</h2>
    <p>Ini adalah dashboard pelanggan <strong>Luxe Wash</strong> 💖</p>
    <img src="<?= $imgPath ?>" alt="Ilustrasi Dashboard" class="dashboard-img img-fluid">
  </div>

  <div class="notif">
    <i class="fas fa-bell"></i> <?= $notif ?>
  </div>

  <div class="cards">
    <div class="card zoom-in">
      <div class="card-body">
        <i class="fas fa-tshirt"></i>
        <h5>Status Cucian</h5>
        <p>Lihat status cucian Anda secara real-time.</p>
      </div>
      <a href="status.php" class="btn btn-sm btn-pink mt-2 btn-animate">Lihat</a>
    </div>
    <div class="card zoom-in">
      <div class="card-body">
        <i class="fas fa-receipt"></i>
        <h5>Riwayat Transaksi</h5>
        <p>Riwayat semua transaksi laundry Anda.</p>
      </div>
      <a href="riwayat.php" class="btn btn-sm btn-pink mt-2 btn-animate">Lihat</a>
    </div>
  </div>
</div>

<footer>
  &copy; <?= date('Y') ?> Luxe Wash. Semua hak dilindungi.
</footer>

</body>
</html>
