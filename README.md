# Sistem Inventaris Barang UMKM

Aplikasi berbasis web untuk membantu UMKM mencatat, mengelola, dan memantau stok barang di gudang.

## 📌 Fitur Utama
- Login & Registrasi
- Tambah, edit, hapus, dan cari barang
- Notifikasi barang hampir expired (⚠️)
- FIFO: Menampilkan 5 barang masuk paling awal
- Hak akses Admin dan User (staff)
- Riwayat aktivitas pengguna (histori)

## 🚀 Cara Menjalankan
1. Install [XAMPP](https://www.apachefriends.org/)
2. Jalankan Apache & MySQL
3. Import file `query.sql` ke database `db_inventaris` di phpMyAdmin
4. Simpan semua file ke folder `htdocs/inventaris-barang-umkm`
5. Akses di browser: `http://localhost/inventaris-barang-umkm/`

## 🔐 Login Akun
- **Admin**: admin / admin123
- **User**: staff / staff123

## 📁 Struktur Folder
- `index.php` – Halaman login
- `dashboard.php` – Menu utama
- `barang_add.php`, `barang_list.php`, `barang_edit.php` – Manajemen barang
- `koneksi.php` – Koneksi database
- `style.css` – Tampilan web

---

Created by [SoniaAnastasia112](https://github.com/SoniaAnastasia112)
