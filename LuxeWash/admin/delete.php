<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header('Location: ../auth/login.php');
    exit;
}
include '../includes/db.php';

$id = $_GET['id'] ?? 0;
mysqli_query($conn, "DELETE FROM users WHERE id = $id");

header('Location: users.php');
exit;
?>
