<?php
include "koneksi.php";
if (!is_logged_in()) {
    header("Location: index.php");
    exit;
}

$keyword = $_GET['q'] ?? '';
$query = "SELECT * FROM barang WHERE nama_barang LIKE '%$keyword%' OR kategori LIKE '%$keyword%'";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Cari Barang</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
  <div class="bg-white shadow p-4 rounded">
    <h2 class="mb-4">Cari Barang</h2>
    <form method="GET" class="mb-4 d-flex">
      <input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>" class="form-control me-2" placeholder="Masukkan nama atau kategori...">
      <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>No</th><th>Nama</th><th>Kategori</th><th>Jumlah</th>
            <th>Satuan</th><th>Masuk</th><th>Expired</th><th>Lokasi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_barang'] ?></td>
            <td><?= $row['kategori'] ?></td>
            <td><?= $row['jumlah'] ?></td>
            <td><?= $row['satuan'] ?></td>
            <td><?= $row['tanggal_masuk'] ?></td>
            <td><?= $row['tanggal_expired'] ?: '-' ?></td>
            <td><?= $row['lokasi'] ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <?php else: ?>
      <p class="text-muted">Tidak ada data ditemukan.</p>
    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-secondary w-100 mt-3">Kembali ke Dashboard</a>
  </div>
</div>
</body>
</html>