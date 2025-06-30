<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM transaksi WHERE id = $id");

header("Location: transaksi.php?success=1");
exit;
