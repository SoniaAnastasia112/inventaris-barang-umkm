CREATE DATABASE IF NOT EXISTS db_inventaris;
USE db_inventaris;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS barang;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(100) NOT NULL,
  role ENUM('admin', 'user') NOT NULL
);

INSERT INTO users (username, password, role) VALUES
('admin', 'admin123', 'admin'),
('staff', 'staff123', 'user');

CREATE TABLE barang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_barang VARCHAR(100) NOT NULL,
  kategori VARCHAR(50) NOT NULL,
  jumlah INT NOT NULL,
  satuan VARCHAR(20) NOT NULL,
  tanggal_masuk DATE NOT NULL,
  tanggal_expired DATE,
  lokasi VARCHAR(100)
);

CREATE TABLE histori (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  aksi VARCHAR(50), -- tambah, edit, hapus
  nama_barang VARCHAR(100),
  waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);