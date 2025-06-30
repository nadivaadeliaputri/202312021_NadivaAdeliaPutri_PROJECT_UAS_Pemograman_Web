<?php
include '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID tidak ditemukan.";
    exit;
}

if (mysqli_query($conn, "DELETE FROM users WHERE id = $id")) {
    echo "<script>alert('Pengguna berhasil dihapus'); window.location='users.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus pengguna'); window.location='users.php';</script>";
}
?>
