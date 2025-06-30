<?php
include '../includes/db.php';
include '../includes/auth.php';

$id = $_GET['id'] ?? 0;

// Cek apakah layanan sedang digunakan di transaksi
$check = mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi WHERE layanan_id = $id");
$data = mysqli_fetch_assoc($check);

if ($data['total'] > 0) {
    // Layanan sedang dipakai, tampilkan pesan error
    header("Location: layanan.php?error=1");
    exit;
}

// Jika tidak dipakai, aman dihapus
mysqli_query($conn, "DELETE FROM layanan WHERE id = $id");
header("Location: layanan.php?success=1");
exit;
