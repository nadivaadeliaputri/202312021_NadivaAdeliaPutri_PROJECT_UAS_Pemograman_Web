<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

$data = [];
$labels = [];

$query = mysqli_query($conn, "
  SELECT DATE_FORMAT(tanggal, '%M %Y') AS bulan, COUNT(*) AS total 
  FROM transaksi 
  GROUP BY YEAR(tanggal), MONTH(tanggal)
");

while ($row = mysqli_fetch_assoc($query)) {
    $labels[] = $row['bulan'];
    $data[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Grafik Transaksi - Luxe Wash</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h4 class="text-pink mb-4">📊 Grafik Transaksi per Bulan</h4>
  <canvas id="grafik"></canvas>
</div>

<script>
const ctx = document.getElementById('grafik').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Jumlah Transaksi',
            data: <?= json_encode($data) ?>,
            backgroundColor: '#ff69b4'
        }]
    },
});
</script>

<style>
.text-pink { color: #ff69b4; }
</style>
</body>
</html>
