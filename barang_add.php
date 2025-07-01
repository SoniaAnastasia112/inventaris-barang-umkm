<?php
include "koneksi.php";

// ❗ Tambahkan proteksi hanya untuk admin
if (!is_logged_in() || !is_admin()) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Tambah Barang</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-box">
  <h2>Tambah Barang</h2>
  <form action="barang_add_proses.php" method="POST" onsubmit="return validateForm()">
    <div class="mb-3">
      <input type="text" name="nama_barang" class="form-control" placeholder="Nama Barang" required>
    </div>
    <div class="mb-3">
      <input type="text" name="kategori" class="form-control" placeholder="Kategori" required>
    </div>
    <div class="mb-3">
      <input type="number" name="jumlah" class="form-control" placeholder="Jumlah" min="1" required>
    </div>
    <div class="mb-3">
      <input type="text" name="satuan" class="form-control" placeholder="Satuan" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Tanggal Masuk:</label>
      <input type="date" name="tanggal_masuk" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Tanggal Expired (opsional):</label>
      <input type="date" name="tanggal_expired" class="form-control">
    </div>
    <div class="mb-3">
      <input type="text" name="lokasi" class="form-control" placeholder="Lokasi Penyimpanan" required>
    </div>
    <button type="submit" class="btn btn-success w-100">Simpan</button>
    <a href="barang_list.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
  </form>
</div>

<script>
  
// Validasi jumlah harus > 0 (opsional karena HTML sudah handle min=1)
function validateForm() {
  let jumlah = document.querySelector('input[name="jumlah"]').value;
  if (jumlah <= 0) {
    alert("Jumlah harus lebih dari 0");
    return false;
  }
  return true;
}
</script>
</body>
</html>