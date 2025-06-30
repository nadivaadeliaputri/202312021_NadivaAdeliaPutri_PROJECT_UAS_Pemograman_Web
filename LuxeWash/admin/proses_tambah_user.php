<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = intval($_POST['role']);

    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if (mysqli_query($conn, $query)) {
        header("Location: users.php");
        exit;
    } else {
        echo "Gagal menambahkan pengguna: " . mysqli_error($conn);
    }
} else {
    header("Location: users.php");
    exit;
}
?>
