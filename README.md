# 👕 Galipat Order Management System

Sistem manajemen pemesanan (Order Management System) berbasis Web untuk industri *Apparel* / Konveksi Jersey. Aplikasi ini dirancang untuk menjembatani komunikasi data antara **Customer**, **Admin (Owner)**, dan **Tim Produksi**, guna meminimalisir kesalahan cetak (typo nama/nomor) dan memastikan alur kerja produksi lebih terstruktur.

## 🚀 Fitur Utama

Aplikasi ini menggunakan konsep **Role-Based Access Control (RBAC)** dengan 3 level pengguna:

1. **👑 Super Admin (Owner/Manajer)**
   - Akses penuh ke seluruh pesanan masuk.
   - Manajemen User (Tambah, Ubah Role, Reset Password, Hapus Akun).
   - Kendali Status Pesanan (`DRAFT` ➔ `PROSES` ➔ `SELESAI`).
   - Fitur Hapus Pesanan (beserta data turunannya).
   
2. **👤 User (Customer / Klien)**
   - Membuat pesanan tim baru.
   - Input data ukuran, nama punggung, dan nomor punggung secara manual.
   - **Import Excel:** Mengunggah file Excel berisi puluhan data pemain sekaligus.
   - Hak akses mengedit/menghapus data hanya berlaku saat pesanan berstatus `DRAFT`.
   
3. **🏭 Read-Only (Tim Produksi / Penjahit / Sablon)**
   - Akses melihat daftar pesanan yang sedang diproses.
   - Tidak memiliki tombol *Add, Edit, Delete, atau Import* (Mencegah perubahan data tidak sengaja).
   - **Export Excel:** Mengunduh data pesanan ke dalam format Excel siap cetak.

## ⚙️ Alur Kerja Sistem (Workflow)

Sistem menggunakan "kunci status" untuk menjaga integritas data selama produksi:
* 🟡 **DRAFT:** Customer membuat pesanan dan memasukkan data. Data bebas diubah, ditambah, atau dihapus. Tim Produksi belum boleh mengeksekusi.
* 🔵 **PROSES:** Admin memverifikasi pesanan dan mengubah status menjadi "Proses". Sistem akan **mengunci** akses edit/hapus pada akun Customer. Tim Produksi mulai mencetak baju berdasarkan data final.
* 🟢 **SELESAI:** Baju telah selesai diproduksi dan dikirim. Status diubah sebagai arsip.

## 🛠️ Tech Stack & Requirements

* **Framework:** Laravel 11/12
* **Frontend:** Tailwind CSS, Alpine.js, Laravel Blade
* **Authentication:** Laravel Breeze
* **Database:** MySQL / MariaDB
* **Library Tambahan:** [Maatwebsite/Laravel-Excel](https://laravel-excel.com/) (Butuh ekstensi PHP `php-gd`, `php-zip`, dan `php-xml`).

---

## 💻 Panduan Instalasi (Local Development)

Jika Anda ingin menjalankan atau mengembangkan project ini di komputer lokal (localhost), ikuti langkah-langkah berikut:

### 1. Clone Repository
```bash
git clone [https://github.com/USERNAME_GITHUB/order-jersey.git](https://github.com/USERNAME_GITHUB/order-jersey.git)
cd order-jersey
```
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
