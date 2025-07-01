<?php
include "koneksi.php";
if (!is_logged_in()) {
    header("Location: index.php");
    exit;
}

// Hari ini dan 7 hari ke depan
$today = date("Y-m-d");
$next7 = date("Y-m-d", strtotime("+7 days"));

// Ambil data expired
$expiring = $conn->query("SELECT * FROM barang WHERE tanggal_expired IS NOT NULL AND tanggal_expired BETWEEN '$today' AND '$next7'");

// Total ringkasan
$total_barang = $conn->query("SELECT COUNT(*) AS jumlah FROM barang")->fetch_assoc()['jumlah'];
$total_hampir_expired = $expiring->num_rows;
$total_histori = $conn->query("SELECT COUNT(*) AS jumlah FROM histori")->fetch_assoc()['jumlah'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    .summary-box {
      background: #f8f9fa;
      border: 2px dashed #007bff;
      padding: 20px;
      border-radius: 15px;
      text-align: center;
      margin-bottom: 20px;
    }
    .summary-box h4 {
      font-size: 1.4rem;
      color: #007bff;
    }
    .summary-box p {
      font-size: 1.2rem;
      font-weight: bold;
    }
    .recent-table {
      border: 1px solid #ccc;
      background: white;
      border-radius: 10px;
      padding: 15px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark mb-4 px-4">
  <div class="container-fluid">
    <span class="navbar-brand"><i class="fa-solid fa-warehouse"></i> Inventaris Gudang</span>
    <div class="d-flex align-items-center">
      <span class="user-info me-3">
        <i class="fa-solid fa-user"></i> <?= $_SESSION['username']; ?> (<?= $_SESSION['role']; ?>)
      </span>
      <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
    </div>
  </div>
</nav>

<!-- Container -->
<div class="container">
  <h3 class="text-center mb-4">Selamat Datang di Sistem Inventaris Barang Gudang</h3>

  <!-- Notifikasi -->
  <?php if ($total_hampir_expired > 0): ?>
    <div class="alert alert-warning">
      ⚠️ <strong>Peringatan:</strong> Ada <b><?= $total_hampir_expired ?></b> barang yang akan expired dalam 7 hari!
      <ul class="mb-0">
        <?php
        mysqli_data_seek($expiring, 0);
        while($row = $expiring->fetch_assoc()): ?>
          <li><?= $row['nama_barang'] ?> (Exp: <?= date('d/m/Y', strtotime($row['tanggal_expired'])) ?>)</li>
        <?php endwhile; ?>
      </ul>
    </div>
  <?php endif; ?>

  <!-- Ringkasan -->
  <div class="row mb-4">
    <div class="col-md-6">
      <div class="summary-box">
        <h4>Total Data Barang</h4>
        <p><?= $total_barang ?> item</p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="summary-box">
        <h4>Barang Hampir Expired</h4>
        <p><?= $total_hampir_expired ?> item</p>
      </div>
    </div>
  </div>

  <!-- Menu Navigasi -->
  <div class="row g-4 mb-4">
    <?php if (is_admin()): ?>
      <div class="col-md-3">
        <a href="barang_add.php" class="text-decoration-none text-dark">
          <div class="menu-box">
            <i class="fa-solid fa-square-plus"></i>
            <div class="menu-title">Tambah Barang</div>
          </div>
        </a>
      </div>
    <?php endif; ?>

    <div class="col-md-3">
      <a href="barang_list.php" class="text-decoration-none text-dark">
        <div class="menu-box">
          <i class="fa-solid fa-boxes-stacked"></i>
          <div class="menu-title">Lihat Barang</div>
        </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="barang_search.php" class="text-decoration-none text-dark">
        <div class="menu-box">
          <i class="fa-solid fa-magnifying-glass"></i>
          <div class="menu-title">Cari Barang</div>
        </div>
      </a>
    </div>

    <?php if (is_admin()): ?>
      <div class="col-md-3">
        <a href="histori_barang.php" class="text-decoration-none text-dark">
          <div class="menu-box">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <div class="menu-title">Histori Barang</div>
          </div>
        </a>
      </div>
    <?php endif; ?>
  </div>

  <!-- Tabel FIFO -->
  <div class="recent-table mt-4">
    <h5 class="mb-3"><i class="fa-solid fa-clock-rotate-left"></i> 5 Barang Masuk (FIFO)</h5>
    <?php
    $recent = $conn->query("SELECT * FROM barang ORDER BY tanggal_masuk ASC LIMIT 5");
    if ($recent->num_rows > 0):
    ?>
    <div class="table-responsive">
      <table class="table table-bordered table-sm text-center align-middle">
        <thead class="table-light">
          <tr>
            <th>Nama</th><th>Masuk</th><th>Expired</th><th>Lokasi</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($b = $recent->fetch_assoc()): ?>
          <tr>
            <td><?= $b['nama_barang'] ?></td>
            <td><?= $b['tanggal_masuk'] ?></td>
            <td><?= $b['tanggal_expired'] ?: '-' ?></td>
            <td><?= $b['lokasi'] ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <?php else: ?>
      <p class="text-muted">Belum ada data barang masuk.</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>