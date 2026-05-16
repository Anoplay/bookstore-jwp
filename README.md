# 📚 Aplikasi BookStore (Ujian Kompetensi BNSP)

Aplikasi e-commerce Toko Buku berbasis Web yang dibangun menggunakan **Laravel 11** dan **Bootstrap 5**. Proyek ini dibuat secara khusus untuk memenuhi persyaratan Uji Kompetensi Keahlian (UKK) Badan Nasional Sertifikasi Profesi (BNSP) Skema Junior Web Developer.

## ✨ Fitur Utama (Berdasarkan Panduan Asesor)

Sistem ini memiliki **2 Hak Akses (Role)** yaitu Admin dan User, dengan pembagian tugas sebagai berikut:

### 🛡️ Fitur Admin (Panel Administrator)
1. **Dashboard Statistik**: Memonitor total buku, pengguna, dan pesanan secara *real-time*.
2. **Kelola Kategori Buku (CRUD)**: Menambah, mengubah, dan menghapus kategori buku.
3. **Kelola Data Buku (CRUD)**: Manajemen katalog buku lengkap dengan unggah gambar (*upload image*), harga, dan stok.
4. **List User Terdaftar**: Menampilkan daftar pengguna yang telah teregistrasi di dalam sistem.
5. **Manajemen Pesanan (List Pesanan)**: Melihat daftar riwayat pesanan dari berbagai user.
6. **Update Status Pengiriman**: Mengubah alur pengiriman pesanan (*Menunggu Konfirmasi -> Diproses -> Dikirim -> Selesai*). Terdapat juga fitur **Pembatalan Pesanan** yang terintegrasi dengan pengembalian stok barang secara otomatis.
7. **Pesan Masuk (Inbox)**: Membaca pesan/kontak yang dikirimkan oleh pengunjung website.

### 👤 Fitur User (Pelanggan)
1. **Registrasi & Login**: Sistem autentikasi pengguna yang aman.
2. **Katalog & Pencarian Buku**: Mencari buku berdasarkan judul/kategori.
3. **Halaman About Us**: Informasi detail mengenai visi dan misi toko buku.
4. **Contact to Admin**: Formulir pengiriman pesan langsung ke kotak masuk Admin.
5. **Add to Cart (Keranjang Belanja)**: Fitur keranjang dinamis dengan kemampuan modifikasi *quantity* sebelum *checkout*.
6. **Checkout (Payment at Delivery)**: Proses pemesanan buku dengan metode pembayaran *Payment at Delivery* (Bayar di tempat).
7. **Tracking Status Pengiriman**: Memantau status pesanan (Apakah sudah diproses/dikirim oleh Admin).

## 🛠️ Teknologi yang Digunakan
- **Framework Backend**: Laravel 11 (PHP 8.x)
- **Framework Frontend**: Bootstrap 5 (HTML5, CSS3)
- **Database**: MySQL (phpMyAdmin)
- **Arsitektur**: MVC (Model-View-Controller)

---
*Didevelop untuk keperluan sertifikasi kompetensi profesi.*
