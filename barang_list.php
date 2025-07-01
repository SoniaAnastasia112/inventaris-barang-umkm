<?php
include "koneksi.php";

if (!is_logged_in()) {
    header("Location: index.php");
    exit;
}

// Urutkan berdasarkan tanggal masuk (FIFO)
$data = $conn->query("SELECT * FROM barang ORDER BY tanggal_masuk ASC");

$today = date("Y-m-d");
$next7 = date("Y-m-d", strtotime("+7 days"));
?>
<!DOCTYPE html>
<html>
<head>
  <title>Data Barang</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    .expired {
      background-color: #ffd6d6 !important; /* Merah muda */
    }
    .near-expired {
      background-color: #fffacc !important; /* Kuning muda */
    }
    tr.expired td,
    tr.near-expired td {
      background-color: inherit !important;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="bg-white shadow rounded p-4">
    <h2 class="text-center mb-4">Data Barang (Urutan FIFO)</h2>

    <div class="table-responsive">
      <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Masuk</th>
            <th>Expired</th>
            <th>Lokasi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($data->num_rows > 0): ?>
            <?php $no = 1; while ($row = $data->fetch_assoc()): ?>
              <?php
              $expiredClass = '';
              if (!empty($row['tanggal_expired'])) {
                  if ($row['tanggal_expired'] < $today) {
                      $expiredClass = 'expired';
                  } elseif ($row['tanggal_expired'] <= $next7) {
                      $expiredClass = 'near-expired';
                  }
              }
              ?>
              <tr class="<?= $expiredClass ?> text-dark fw-semibold">
                <td><?= $no++ ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['kategori'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['satuan'] ?></td>
                <td><?= $row['tanggal_masuk'] ?></td>
                <td><?= $row['tanggal_expired'] ?: '-' ?></td>
                <td><?= $row['lokasi'] ?></td>
                <td>
                  <a href="barang_edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm me-1">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <a href="barang_delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus barang ini?')" class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="9" class="text-center">Belum ada data barang.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <a href="dashboard.php" class="btn btn-secondary w-100 mt-3">Kembali ke Dashboard</a>
  </div>
</div>

</body>
</html>