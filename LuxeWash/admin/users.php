<?php
include '../includes/db.php';
include '../includes/auth.php';

// Ambil data user + join ke role
$users = mysqli_query($conn, "SELECT users.*, roles.role_name 
                              FROM users 
                              JOIN roles ON users.role_id = roles.id 
                              ORDER BY users.created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Pengguna - Luxe Wash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #ffe6f0, #fff0f5);
      font-family: 'Poppins', sans-serif;
    }
    .btn-pink {
      background-color: #ff69b4;
      color: white;
      font-weight: 500;
    }
    .btn-pink:hover {
      background-color: #ff85c1;
      color: white;
    }
    .btn-outline-pink {
      border: 2px solid #ff69b4;
      color: #ff69b4;
      font-weight: 500;
    }
    .btn-outline-pink:hover {
      background-color: #ff69b4;
      color: white;
    }
    .text-pink {
      color: #ff69b4;
      font-weight: 600;
    }
    .table thead {
      background-color: #ffc0cb;
      color: #6b005b;
    }
    .table td, .table th {
      vertical-align: middle;
    }
    .card-box {
      background: #fff;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(255, 105, 180, 0.1);
    }
  </style>
</head>
<body>
<div class="container my-5">
  <div class="card-box">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="text-pink mb-0"><i class="bi bi-basket2-fill me-2"></i>Manajemen Pengguna - Luxe Wash</h3>
      <div>
        <a href="dashboard.php" class="btn btn-outline-pink me-2">
          <i class="bi bi-arrow-left-circle"></i> Kembali
        </a>
        <a href="tambah_user.php" class="btn btn-pink">
          <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
        </a>
      </div>
    </div>

    <table class="table table-bordered table-hover bg-white">
      <thead class="text-center">
        <tr>
          <th>No</th>
          <th>Username</th>
          <th>Nama Lengkap</th>
          <th>Email</th>
          <th>No HP</th>
          <th>Role</th>
          <th>Tanggal Dibuat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php $no = 1; while($row = mysqli_fetch_assoc($users)): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['full_name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= htmlspecialchars($row['role_name']) ?></td>
          <td><?= htmlspecialchars($row['created_at']) ?></td>
          <td class="text-center">
            <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="hapus_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
