<?php
include "koneksi.php";
session_start(); // penting untuk ambil username

$nama     = $_POST['nama_barang'];
$kategori = $_POST['kategori'];
$jumlah   = $_POST['jumlah'];
$satuan   = $_POST['satuan'];
$tanggal  = $_POST['tanggal_masuk'];
$expired  = $_POST['tanggal_expired'];
$lokasi   = $_POST['lokasi'];

$conn->query("INSERT INTO barang (nama_barang, kategori, jumlah, satuan, tanggal_masuk, tanggal_expired, lokasi)
VALUES ('$nama', '$kategori', '$jumlah', '$satuan', '$tanggal', '$expired', '$lokasi')");

// ✅ Tambahkan ke histori
$username = $_SESSION['username'];
$conn->query("INSERT INTO histori (username, aksi, nama_barang) VALUES ('$username', 'tambah', '$nama')");

header("Location: barang_list.php");
exit;