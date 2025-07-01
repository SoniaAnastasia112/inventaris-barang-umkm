<?php
include "koneksi.php";
if (!is_logged_in() || !is_admin()) {
  header("Location: index.php");
  exit;
}

$data = $conn->query("SELECT * FROM histori ORDER BY waktu DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Histori Barang</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
  <div class="bg-white shadow p-4 rounded">
    <h2 class="mb-4 text-center">Histori Aktivitas Barang</h2>
    <div class="table-responsive">
      <table class="table table-bordered table-sm text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>No</th><th>Waktu</th><th>Username</th><th>Aksi</th><th>Nama Barang</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; while($row = $data->fetch_assoc()): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['waktu'] ?></td>
            <td><?= $row['username'] ?></td>
            <td><?= ucfirst($row['aksi']) ?></td>
            <td><?= $row['nama_barang'] ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <a href="dashboard.php" class="btn btn-secondary w-100 mt-3">Kembali ke Dashboard</a>
  </div>
</div>
</body>
</html>