Aplikasi Administrasi dan Tabungan Sekolah
Aplikasi web sederhana yang dibangun dengan Laravel untuk mengelola data administrasi dan keuangan siswa di sekolah, meliputi manajemen data siswa, tabungan, pembayaran SPP, dan pembuatan laporan.

Aplikasi ini dirancang untuk digunakan oleh satu operator sekolah (Super User).

✨ Fitur Utama
👤 Manajemen Siswa (CRUD): Tambah, lihat, ubah, dan hapus data siswa. Pencarian siswa berdasarkan Nama atau Nomor Induk.

💰 Manajemen Tabungan: Mencatat transaksi setoran dan penarikan tabungan untuk setiap siswa. Saldo akan terhitung secara otomatis.

💳 Pembayaran SPP: Mencatat pembayaran SPP bulanan untuk setiap siswa. Tampilan status lunas/belum lunas per bulan dalam satu tahun ajaran.

📄 Laporan PDF Bulanan: Menghasilkan laporan keuangan (Pemasukan & Pengeluaran) dalam format PDF untuk bulan dan tahun yang dipilih.

📊 Laporan PDF Semester: Menghasilkan laporan rekapitulasi status pembayaran SPP (lunas/belum lunas) per semester untuk semua siswa.

🔐 Autentikasi: Sistem login yang aman untuk operator sekolah.

🛠️ Teknologi yang Digunakan
Backend: PHP 8.1+ / Laravel 10.x

Frontend: Blade Templates, Tailwind CSS

Database: MySQL

Library Tambahan:

Laravel Breeze untuk sistem autentikasi.

barryvdh/laravel-dompdf untuk generate file PDF.

🚀 Panduan Instalasi
Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan lokal Anda.

1. Prasyarat
PHP >= 8.1

Composer

Node.js & NPM

Database Server (misalnya MySQL, MariaDB)

2. Clone atau Salin Proyek
Jika ini adalah repositori git, clone proyeknya. Jika tidak, cukup salin semua file ke direktori lokal Anda.

# Contoh jika menggunakan git
git clone https://nama-repositori-anda.git
cd nama-proyek

3. Instalasi Dependensi
Instal semua dependensi PHP menggunakan Composer.

composer install

4. Konfigurasi Lingkungan (.env)
Salin file .env.example menjadi .env.

cp .env.example .env

Buka file .env dan sesuaikan konfigurasi database Anda:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_sekolah
DB_USERNAME=root
DB_PASSWORD=

Penting: Pastikan Anda sudah membuat database db_sekolah (atau nama lain sesuai konfigurasi) di server database Anda.

5. Generate Application Key
Buat kunci aplikasi yang dibutuhkan oleh Laravel.

php artisan key:generate

6. Jalankan Migrasi Database
Perintah ini akan membuat semua tabel yang dibutuhkan (users, students, dll.) di database Anda.

php artisan migrate

7. Instalasi Dependensi Frontend
Instal dan kompilasi aset frontend (CSS, JS).

npm install
npm run dev

8. Jalankan Server
Sekarang Anda bisa menjalankan server pengembangan lokal.

php artisan serve

Aplikasi akan berjalan secara default di http://127.0.0.1:8000.

👨‍💻 Pengaturan Akun Operator (Super User)
Aplikasi ini dirancang untuk satu operator. Ikuti langkah ini untuk membuat akun:

Buka Halaman Registrasi: Kunjungi http://127.0.0.1:8000/register.

Daftarkan Akun: Isi form pendaftaran untuk membuat akun operator.

Nonaktifkan Registrasi (PENTING!): Setelah berhasil mendaftar, buka file routes/web.php dan nonaktifkan rute registrasi untuk mencegah orang lain mendaftar.

// Ganti baris ini
// require __DIR__.'/auth.php';

// Menjadi seperti ini, jika Anda menggunakan Laravel Breeze standar.
// Jika Anda menambahkan Auth::routes(), ubah 'register' => true menjadi false.
// Pastikan Anda menemukan cara yang sesuai untuk menonaktifkannya
// berdasarkan versi Laravel Breeze/UI Anda.

Cara termudah adalah dengan menghapus file register.blade.php dari resources/views/auth/ atau mengarahkan rute /register ke halaman login.

Flow Penggunaan Aplikasi
Login: Operator melakukan login ke sistem.

Manajemen Siswa: Dari Dashboard, masuk ke menu "Manajemen Siswa". Di sini operator dapat menambah, mengedit, atau menghapus data siswa.

Input Transaksi: Klik "Detail" pada salah satu siswa untuk masuk ke halaman detail. Di halaman ini, operator bisa:

Memasukkan transaksi tabungan (setor/tarik).

Memasukkan pembayaran SPP per bulan.

Cetak Laporan: Dari Dashboard, masuk ke menu "Cetak Laporan" untuk menghasilkan laporan PDF bulanan atau semester.