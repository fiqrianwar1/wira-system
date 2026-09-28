# Wira System — Sistem Manajemen Bengkel Body Repair

Aplikasi web terpadu untuk manajemen bengkel **Body Repair**, mulai dari pencatatan Customer, Kendaraan, Work Order (SPK), hingga pengelolaan Gudang Sparepart & Gudang Bahan. 

Dibuat dengan Laravel untuk memastikan seluruh proses perbaikan kendaraan, dari estimasi biaya hingga mobil selesai, dapat dipantau secara real-time oleh petugas dan pelanggan.

---

## Tampilan Aplikasi

> **Catatan:** Tambahkan hasil screenshot ke dalam folder `docs/screenshots/` dengan nama file yang sesuai agar gambar muncul di sini.

### Dashboard (Service Advisor)
Ringkasan status Work Order, kendaraan yang sedang diproses, dan laporan harian.

![Dashboard Service Advisor](docs/screenshots/dashboard-sa.png)

### Work Order / SPK
Daftar kendaraan yang masuk, status perbaikan per panel, dan estimasi waktu selesai.

![Work Order](docs/screenshots/work-order.png)

### Gudang Sparepart & Bahan
Pemantauan ketersediaan part (seperti bumper, kaca) dan bahan (cat, thinner), serta status pemesanan part (OTW / Ready).

![Gudang](docs/screenshots/gudang.png)

### Tampilan Customer
Pelanggan dapat login untuk melihat progres perbaikan mobil mereka secara langsung tanpa harus datang ke bengkel.

![Customer View](docs/screenshots/customer-view.png)

---

## Fitur Utama

### 1. Manajemen Work Order (SPK)
- Pencatatan estimasi biaya, keluhan, tipe perbaikan (Regular / Quick Repair).
- Pemantauan status perbaikan per panel (Preparation, Paint, Poles, Washing).
- Estimasi waktu pengerjaan dan pelacakan riwayat servis per kendaraan.

### 2. Manajemen Inventory (Gudang)
- **Gudang Sparepart:** Memantau part fisik seperti kap mesin, pintu, bumper. Status bisa berupa "OTW" atau "Ready".
- **Gudang Bahan:** Mengontrol ketersediaan bahan cair seperti cat, pernis, dan thinner.
- **Purchase Order:** Pembuatan Purchase Order (PO) untuk kebutuhan part bengkel.

### 3. Monitoring Foreman & Mekanik
- Absensi mekanik berdasarkan spesialisasi (Body, Preparation, Paint, Poles, Washing).
- Penugasan pekerjaan spesifik ke teknisi atau leader, memudahkan pelacakan tanggung jawab.
- Update progres pekerjaan perbaikan bodi secara berkala.

### 4. Portal Customer
- Pelanggan (seperti Bapak Budi) bisa login dan memantau status mobilnya (contoh: Fortuner sedang dalam tahap Preparation).
- Riwayat perbaikan sebelumnya (contoh: Innova yang sudah selesai bulan lalu) dapat dilihat kapan saja.
- Pengajuan keluhan (Complaint) secara langsung melalui sistem.

### Hak Akses (Role)

Sistem membagi akses menjadi beberapa peran spesifik:

| Role | Hak Akses |
|---|---|
| **Service Advisor (SA)** | Membuat SPK, mendaftarkan customer & kendaraan, membuat estimasi biaya. |
| **Foreman Controller** | Memantau progres perbaikan, assign tugas ke mekanik, kontrol kualitas. |
| **Gudang Sparepart** | Mengelola stok part fisik, update status part (OTW/Ready). |
| **Gudang Bahan** | Mengelola stok cat/thinner untuk kebutuhan tinting dan pengecatan. |
| **Customer** | Hanya bisa melihat status kendaraannya sendiri dan membuat komplain. |

---

## Kebutuhan Sistem

- **PHP** >= 8.3
- **Composer**
- **Node.js** >= 18 & npm
- **MySQL** (atau SQLite)

---

## Cara Menjalankan

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

Lalu **atur koneksi database** di file `.env`.

```bash
# 4. Buat tabel & akun awal
php artisan migrate:fresh --seed

# 5. Build aset tampilan
npm run dev

# 6. Jalankan
php artisan serve
```

Buka **http://localhost:8000**

### Akun Login (Bawaan Seeder)

Gunakan akun berikut untuk login dan menguji fitur:

| Role | Email | Password |
|---|---|---|
| **Service Advisor** | `sa@wira.com` | `12345678` |
| **Foreman** | `foreman@wira.com` | `12345678` |
| **Gudang Sparepart** | `part@wira.com` | `12345678` |
| **Gudang Bahan** | `bahan@wira.com` | `12345678` |
| **Customer (Budi)** | `budi@gmail.com` | `12345678` |

> **Penting:** Harap ganti password ini jika aplikasi akan digunakan di tahap produksi (production).

---

## Lisensi

Proyek internal Wira System. Dibangun di atas [Laravel](https://laravel.com).
