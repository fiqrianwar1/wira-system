# 🔧 Wira System — Sistem Manajemen Bengkel Body & Paint

Aplikasi web terpadu untuk manajemen bengkel **Body Repair & Paint**, mulai dari pencatatan customer, kendaraan, Work Order (SPK), monitoring progres pengerjaan, sampai pengelolaan Gudang Sparepart & Gudang Bahan.

Dibangun dengan **Laravel 12** sehingga seluruh proses perbaikan kendaraan — dari estimasi biaya sampai mobil selesai — bisa dipantau secara real-time oleh petugas maupun pelanggan.

---

## 📋 Daftar Isi

- [Tampilan Aplikasi](#-tampilan-aplikasi)
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

### 1. Dashboard Service Advisor
Ringkasan Work Order, unit yang sedang diproses, omzet bulanan, dan komplain customer yang butuh tindakan.

![Dashboard Service Advisor](docs/screenshots/dashboard-service-advisor.png)

### 2. Foreman Control Center
Monitoring progres pengerjaan per unit, plot mekanik, dan absensi harian tim produksi.

![Dashboard Foreman](docs/screenshots/dashboard-foreman.png)

### 3. Logistik Control Center — Gudang Sparepart
Pantauan stok part (bumper, kaca, kap mesin), status pemesanan (OTW / Ready), dan Purchase Order.

![Dashboard Gudang Sparepart](docs/screenshots/dashboard-gudang-sparepart.png)

### 4. Material Control — Gudang Bahan
Kontrol stok bahan (cat, thinner, pernis), pemakaian bahan per SPK, dan nota pembelian supplier.

![Dashboard Gudang Bahan](docs/screenshots/dashboard-gudang-bahan.png)

### 5. Portal Customer
Pelanggan login sendiri untuk memantau progres perbaikan mobilnya secara real-time, tanpa harus datang ke bengkel.

![Portal Customer](docs/screenshots/portal-customer.png)

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