# 🔧 Wira System — Sistem Manajemen Bengkel Body & Paint

Aplikasi web terpadu untuk manajemen bengkel **Body Repair & Paint**, mulai dari pencatatan customer, kendaraan, Work Order (SPK), monitoring progres pengerjaan, sampai pengelolaan Gudang Sparepart & Gudang Bahan.

Dibangun dengan **Laravel 12** sehingga seluruh proses perbaikan kendaraan — dari estimasi biaya sampai mobil selesai — bisa dipantau secara real-time oleh petugas maupun pelanggan.

---

## 📋 Daftar Isi

- [Tampilan Aplikasi](#-tampilan-aplikasi)
  - [Halaman Publik & Autentikasi](#1-halaman-publik--autentikasi)
  - [Dashboard Service Advisor](#2-dashboard-service-advisor)
  - [Manajemen Work Order (SPK)](#3-manajemen-work-order-spk)
  - [Master Data Customer & Kendaraan](#4-master-data-customer--kendaraan)
  - [Tracking Sparepart & Klaim Garansi](#5-tracking-sparepart--klaim-garansi)
  - [Dashboard Foreman](#6-dashboard-foreman)
  - [Progres & Job Sheet (Foreman)](#7-progres--job-sheet-foreman)
  - [Manajemen SDM Produksi (Foreman)](#8-manajemen-sdm-produksi-foreman)
  - [Gudang Sparepart](#9-gudang-sparepart)
  - [Gudang Bahan](#10-gudang-bahan)
  - [Portal Customer](#11-portal-customer)
  - [Layar TV Bengkel](#12-layar-tv-bengkel)
- [Fitur Utama](#-fitur-utama)
- [Hak Akses (Role)](#-hak-akses-role)
- [Teknologi](#-teknologi)
- [Kebutuhan Sistem](#-kebutuhan-sistem)
- [Cara Menjalankan](#-cara-menjalankan)
- [Akun Demo (Seeder)](#-akun-demo-seeder)
- [Struktur Modul](#-struktur-modul)
- [Lisensi](#-lisensi)

---

## 📸 Tampilan Aplikasi

Berikut tangkapan layar fitur-fitur unggulan **Wira System**, dikelompokkan sesuai peran pengguna dan alur kerjanya.

### 1. Halaman Publik & Autentikasi

**Landing Page** — Perkenalan layanan body & paint PT. Wira Megah Profitamas Banjarmasin.

![Landing Page](docs/screenshots/landing-page.png)

**Login** — Satu pintu masuk untuk semua role (SA, Foreman, Gudang, Customer).

![Login](docs/screenshots/login.png)

**Registrasi Customer** — Pelanggan bisa mendaftar akun sendiri untuk memantau progres perbaikan.

![Registrasi Customer](docs/screenshots/register.png)

### 2. Dashboard Service Advisor

Ringkasan Work Order, unit yang sedang diproses, omzet bulanan, dan komplain customer yang butuh tindakan.

![Dashboard Service Advisor](docs/screenshots/dashboard-service-advisor.png)

### 3. Manajemen Work Order (SPK)

**Daftar SPK** — Monitoring seluruh Work Order beserta status pengerjaan, teknisi (PIC), dan estimasi selesai.

![Daftar Work Order](docs/screenshots/sa-work-orders.png)

**Buat SPK Baru** — Input data kendaraan, keluhan customer, tipe perbaikan (Regular / Quick Repair), dan estimasi biaya.

![Buat Work Order](docs/screenshots/sa-work-order-create.png)

**Detail SPK** — Progres per panel (Preparation → Paint → Poles → Washing), riwayat servis, dan cetak SPK.

![Detail Work Order](docs/screenshots/sa-work-order-detail.png)

### 4. Master Data Customer & Kendaraan

**Data Customer** — Master pelanggan beserta kontak dan riwayat kendaraannya.

![Data Customer](docs/screenshots/sa-customers.png)

**Data Kendaraan** — Master unit (Toyota, Honda, dll.) lengkap dengan nomor polisi dan pemiliknya.

![Data Kendaraan](docs/screenshots/sa-vehicles.png)

### 5. Tracking Sparepart & Klaim Garansi

**Tracking Sparepart** — Pantauan real-time status pemesanan part dari Gudang (read-only untuk SA).

![Tracking Sparepart](docs/screenshots/sa-tracking-sparepart.png)

**Klaim Garansi / Komplain** — Pencatatan dan penanganan komplain customer.

![Klaim Garansi](docs/screenshots/sa-complaints.png)

### 6. Dashboard Foreman

Control center produksi: monitoring progres tiap unit, plot mekanik, dan status tahapan pengerjaan.

![Dashboard Foreman](docs/screenshots/dashboard-foreman.png)

---

### 7. Progres & Job Sheet (Foreman)

**Progres Pengerjaan** — Papan monitoring tahapan tiap unit di lantai produksi.

![Progres Pengerjaan](docs/screenshots/foreman-progress.png)

**Update Progres** — Form plot tugas ke mekanik/leader per panel dan update status tahapan.

![Update Progres](docs/screenshots/foreman-progress-edit.png)

### 8. Manajemen SDM Produksi (Foreman)

**Data Mekanik** — Master teknisi beserta spesialisasi (Body, Preparation, Paint, Poles, Washing).

![Data Mekanik](docs/screenshots/foreman-mekanik.png)

**Data Kehadiran** — Absensi harian tim produksi.

![Data Kehadiran](docs/screenshots/foreman-absensi.png)

**Rekap Kinerja** — Laporan bulanan jumlah tahapan yang diselesaikan tiap teknisi, dapat dicetak.

![Rekap Kinerja](docs/screenshots/foreman-rekap.png)

### 9. Gudang Sparepart

**Dashboard Gudang Sparepart** — Pantauan stok part (bumper, kaca, kap mesin), status pemesanan (OTW / Ready), dan Purchase Order.

![Dashboard Gudang Sparepart](docs/screenshots/dashboard-gudang-sparepart.png)

**Stok Sparepart** — Daftar seluruh part beserta stok, harga, dan lokasi rak.

![Stok Sparepart](docs/screenshots/sparepart-stocks.png)

**Tambah Stok Sparepart** — Input part baru ke gudang.

![Tambah Stok Sparepart](docs/screenshots/sparepart-stocks-create.png)

**Purchase Order** — Pembuatan PO ke supplier beserta status kedatangan barang.

![Purchase Order](docs/screenshots/sparepart-purchases.png)

**Rekap Purchase Order** — Rekapitulasi PO dan cetak nota.

![Rekap Purchase Order](docs/screenshots/sparepart-purchases-recap.png)

### 10. Gudang Bahan

**Dashboard Gudang Bahan** — Kontrol stok bahan (cat, thinner, pernis) dan nota pembelian supplier.

![Dashboard Gudang Bahan](docs/screenshots/dashboard-gudang-bahan.png)

**Stok Bahan** — Daftar bahan cair beserta kuantitas dan satuannya.

![Stok Bahan](docs/screenshots/bahan-stoks.png)

**Tambah Stok Bahan** — Input bahan baru ke gudang.

![Tambah Stok Bahan](docs/screenshots/bahan-stok-create.png)

**Pemakaian Bahan per SPK** — Pencatatan bahan yang dipakai tiap SPK beserta nota foto, dapat dicetak.

![Pemakaian Bahan per SPK](docs/screenshots/bahan-spk.png)

### 11. Portal Customer

**Dashboard Customer** — Pelanggan memantau progres perbaikan mobilnya sendiri secara real-time.

![Portal Customer](docs/screenshots/portal-customer.png)

**Riwayat Servis** — Histori perbaikan kendaraan yang sudah selesai.

![Riwayat Servis](docs/screenshots/customer-history.png)

**Sparepart Terpakai** — Daftar part yang dipakai di kendaraan customer.

![Sparepart Terpakai](docs/screenshots/customer-spareparts.png)

**Komplain & Garansi** — Pengajuan komplain/klaim garansi langsung dari portal.

![Komplain Customer](docs/screenshots/customer-complaints.png)

### 12. Layar TV Bengkel

**Body & Paint Live Center** — Mode tampilan full screen untuk TV ruang tunggu, menampilkan posisi semua unit di lantai bengkel beserta progresnya.

![Layar TV Bengkel](docs/screenshots/customer-tv.png)

---

## ✨ Fitur Utama

### 1. Manajemen Work Order (SPK)
- Pencatatan estimasi biaya, keluhan customer, serta tipe perbaikan (**Regular** / **Quick Repair**).
- Pemantauan status perbaikan per panel (Preparation → Paint → Poles → Washing).
- Estimasi waktu pengerjaan, diskon, dan riwayat servis per kendaraan.
- Upload foto **sebelum & sesudah** perbaikan.
- Cetak SPK dan rekap SPK.

### 2. Manajemen Inventory (Gudang)
- **Gudang Sparepart** — memantau part fisik (kap mesin, pintu, bumper) dengan status **OTW** atau **Ready**.
- **Gudang Bahan** — mengontrol ketersediaan bahan cair seperti cat, pernis, dan thinner.
- **Purchase Order (PO)** — pembuatan PO ke supplier, lengkap dengan recap dan cetak nota.
- Pemakaian bahan per SPK beserta nota foto, dapat dicetak.

### 3. Monitoring Foreman & Mekanik
- Dashboard progres kerja per unit dan per panel.
- Absensi mekanik berdasarkan spesialisasi (Body, Preparation, Paint, Poles, Washing).
- Penugasan pekerjaan ke teknisi atau leader, sehingga tanggung jawab mudah dilacak.
- Rekap kinerja mekanik bulanan dan cetak laporan.
- Tombol **Selesai** pada Work Order otomatis mengirim notifikasi WhatsApp (integrasi Fonnte).

### 4. Portal Customer
- Customer login dan memantau status mobilnya sendiri (contoh: Fortuner dalam tahap Preparation).
- Riwayat perbaikan sebelumnya (contoh: Innova yang sudah selesai bulan lalu).
- Melihat daftar sparepart yang dipakai di kendaraannya.
- Pengajuan komplain/klaim garansi langsung dari sistem.

### 5. Monitoring & Layar TV
- Mode tampilan **full screen** untuk TV di ruang tunggu, menampilkan posisi unit di lantai bengkel.
- Dashboard operasional dengan grafik omzet bulanan, status SPK, dan tipe perbaikan.

---

## 👥 Hak Akses (Role)

Sistem membagi akses menjadi beberapa peran spesifik:

| Role | `role` | Hak Akses |
|---|---|---|
| **Service Advisor (SA)** | `sa` | Membuat SPK, mendaftarkan customer & kendaraan, membuat estimasi biaya, menangani komplain. |
| **Foreman Controller** | `foreman` | Memantau progres perbaikan, plot tugas ke mekanik, absensi & rekap kinerja, kontrol kualitas. |
| **Gudang Sparepart** | `sparepart` | Mengelola stok part fisik, update status part (OTW / Ready), membuat PO. |
| **Gudang Bahan** | `bahan` | Mengelola stok cat/thinner untuk tinting & pengecatan, input pemakaian bahan per SPK. |
| **Customer** | `customer` | Hanya bisa melihat status kendaraannya sendiri dan membuat komplain. |

Saat login, `DashboardController` otomatis mengarahkan tiap role ke halaman yang sesuai.

---

## 🛠 Teknologi

| Komponen | Versi / Keterangan |
|---|---|
| Framework | Laravel 12 |
| Bahasa | PHP 8.2+ |
| Autentikasi | Laravel Breeze |
| Styling | Tailwind CSS |
| Bundler | Vite |
| Database | MySQL / SQLite |
| Notifikasi | WhatsApp Gateway (Fonnte) |

---

## 💻 Kebutuhan Sistem

- **PHP** >= 8.2 (disarankan 8.3+)
- **Composer**
- **Node.js** >= 18 & npm
- **MySQL** (atau SQLite untuk development cepat)

---

## 🚀 Cara Menjalankan

```bash
# 1. Clone repository
git clone https://github.com/fiqrianwar1/wira-system.git
cd wira-system

# 2. Pasang dependency PHP & JS
composer install
npm install

# 3. Siapkan file konfigurasi
cp .env.example .env
php artisan key:generate
```

Lalu **atur koneksi database** di file `.env`. Untuk MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wira_system
DB_USERNAME=root
DB_PASSWORD=
```

Atau pakai SQLite (paling cepat untuk development):

```env
DB_CONNECTION=sqlite
```

```bash
# 4. Buat tabel & akun awal
php artisan migrate:fresh --seed

# 5. Build aset tampilan
npm run dev
```

Terakhir, jalankan aplikasinya:

```bash
php artisan serve
```

Buka **http://localhost:8000**

> 💡 Kalau pakai **Laravel Herd**, proyek otomatis bisa diakses lewat `http://wira-system.test` tanpa perlu `php artisan serve`.

---

## 🔑 Akun Demo (Seeder)

Gunakan akun berikut untuk login dan menguji masing-masing fitur. Semua password sama: `12345678`.

| Role | Email | Password |
|---|---|---|
| **Service Advisor** | `sa@wira.com` | `12345678` |
| **Foreman** | `foreman@wira.com` | `12345678` |
| **Gudang Sparepart** | `part@wira.com` | `12345678` |
| **Gudang Bahan** | `bahan@wira.com` | `12345678` |
| **Customer (Budi)** | `budi@gmail.com` | `12345678` |

> ⚠️ **Penting:** Ganti seluruh password di atas sebelum aplikasi dipakai di tahap produksi.

### Data Contoh Bawaan Seeder

- **Budi Santoso** — Toyota Fortuner VRZ (SPK status *proses*, tahap Preparation, part kap mesin *OTW*) dan Toyota Kijang Innova Reborn (SPK *selesai* bulan lalu, untuk uji riwayat).
- **Siti Aminah** — Honda Jazz RS, dipakai untuk menguji isolasi data antar customer.
- **7 mekanik** dengan spesialisasi Body, Preparation, Paint, Poles, dan Washing.

---

## 📂 Struktur Modul

```
app/Http/Controllers/
├── DashboardController.php     # Routing dashboard per role + mode TV
├── CustomerController.php      # Master customer & portal customer
├── VehicleController.php       # Master kendaraan
├── WorkOrderController.php     # SPK / Work Order
├── SparepartController.php     # Stok & monitoring sparepart
├── PurchaseOrderController.php # Purchase Order (PO)
├── BahanController.php         # Stok bahan & pemakaian per SPK
├── ForemanController.php       # Progres kerja, rekap kinerja
├── MekanikController.php       # Master mekanik
├── AbsensiController.php       # Absensi mekanik
└── ComplaintController.php     # Komplain & klaim garansi
```

Halaman utama per role:

| Role | URL |
|---|---|
| Service Advisor | `/dashboard` |
| Foreman | `/foreman/dashboard` |
| Gudang Sparepart | `/spareparts` |
| Gudang Bahan | `/bahan/dashboard` |
| Customer | `/dashboard` (portal customer) |
| Layar TV | `/monitor/tv` |

---

## 📄 Lisensi

Proyek internal **Wira System**. Dibangun di atas [Laravel](https://laravel.com).