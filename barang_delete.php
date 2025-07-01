<?php
include "koneksi.php";
session_start(); // ambil session

// 🔐 Hanya admin yang boleh hapus
if (!is_logged_in() || !is_admin()) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];

// ✅ Ambil nama barang dulu sebelum dihapus
$get = $conn->query("SELECT nama_barang FROM barang WHERE id = $id");
$nama = $get->fetch_assoc()['nama_barang'];

// ✅ Tambahkan ke histori
$username = $_SESSION['username'];
$conn->query("INSERT INTO histori (username, aksi, nama_barang) VALUES ('$username', 'hapus', '$nama')");

// 🔥 Hapus data
$conn->query("DELETE FROM barang WHERE id = $id");

header("Location: barang_list.php");
exit;