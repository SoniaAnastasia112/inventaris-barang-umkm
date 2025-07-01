<?php
include "koneksi.php";
session_start(); // ambil session username

$id       = $_POST['id'];
$nama     = $_POST['nama_barang'];
$kategori = $_POST['kategori'];
$jumlah   = $_POST['jumlah'];
$satuan   = $_POST['satuan'];
$tanggal  = $_POST['tanggal_masuk'];
$expired  = $_POST['tanggal_expired'];
$lokasi   = $_POST['lokasi'];

$conn->query("UPDATE barang SET
  nama_barang = '$nama',
  kategori = '$kategori',
  jumlah = '$jumlah',
  satuan = '$satuan',
  tanggal_masuk = '$tanggal',
  tanggal_expired = '$expired',
  lokasi = '$lokasi'
  WHERE id = $id
");

// ✅ Tambahkan ke histori
$username = $_SESSION['username'];
$conn->query("INSERT INTO histori (username, aksi, nama_barang) VALUES ('$username', 'edit', '$nama')");

header("Location: barang_list.php");
exit;