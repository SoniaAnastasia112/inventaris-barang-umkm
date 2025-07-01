<?php
include "koneksi.php";

// 🔐 Hanya admin yang boleh akses
if (!is_logged_in() || !is_admin()) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM barang WHERE id = $id");
$row = $data->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Barang</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-box">
  <h2>Edit Barang</h2>
  <form action="barang_edit_proses.php" method="POST">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <div class="mb-3">
      <input type="text" name="nama_barang" class="form-control" value="<?= $row['nama_barang'] ?>" required>
    </div>
    <div class="mb-3">
      <input type="text" name="kategori" class="form-control" value="<?= $row['kategori'] ?>" required>
    </div>
    <div class="mb-3">
      <input type="number" name="jumlah" class="form-control" value="<?= $row['jumlah'] ?>" min="1" required>
    </div>
    <div class="mb-3">
      <input type="text" name="satuan" class="form-control" value="<?= $row['satuan'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Tanggal Masuk:</label>
      <input type="date" name="tanggal_masuk" class="form-control" value="<?= $row['tanggal_masuk'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Tanggal Expired (opsional):</label>
      <input type="date" name="tanggal_expired" class="form-control" value="<?= $row['tanggal_expired'] ?>">
    </div>
    <div class="mb-3">
      <input type="text" name="lokasi" class="form-control" value="<?= $row['lokasi'] ?>" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Update</button>
    <a href="barang_list.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
  </form>
</div>
</body>
</html>