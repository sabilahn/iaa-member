# Dokumentasi Lengkap Proyek: IAA Member Portal (`iaa-member`)

Dokumen ini berisi rangkuman teknis, arsitektur sistem, skema basis data, alur integrasi API, serta panduan instalasi dan perbaikan untuk proyek **iaa-member**.

---

## 1. Ringkasan Proyek

- **Nama Aplikasi**: IAA Investment Member Portal (`iaa-member`)
- **Tipe Aplikasi**: Web Portal Anggota / Investor Mandiri (*Self-Service Member Portal*)
- **Framework**: CodeIgniter 3.1.x (PHP 8.1+)
- **Tujuan**:
  Menyediakan akses informasi transparan bagi anggota/investor Koperasi atau Perseroan IAA (Dharma IAA), meliputi profil rekening saham, mutasi saldo investasi, rata-rata harian, distribusi porsi Sisa Hasil Usaha (SHU), dividen persero, serta pencetakan sertifikat surat saham legal ber-QR code.

---

## 2. Tech Stack & Dependensi

| Layer | Komponen / Library | Fungsi |
| :--- | :--- | :--- |
| **Backend** | CodeIgniter 3 | Arsitektur MVC & controller routing |
| **Frontend UI** | Stisla Admin Template | Layout responsive berbasis Bootstrap 4 |
| **Icons & Font** | FontAwesome 5, Google Fonts | Ikonografi antarmuka |
| **Interactive Table** | jQuery DataTables | Rendering data tabel dinamis via AJAX |
| **PDF Generator** | Dompdf (`dompdf/dompdf: ^2.0`) | Rendering dokumen sertifikat surat saham format PDF |
| **QR Code** | PHP QR Code (`application/libraries/qrcode/`) | Pembuatan barcode verifikasi sertifikat |
| **Database** | MySQL / MariaDB via `mysqli` | Penyimpanan kredensial akun dan mirroring data lokal |
| **API Integration** | cURL Gateway (`application/controllers/Curl.php`) | Jembatan komunikasi aman ke REST API pusat |

---

## 3. Arsitektur Data (*Dual-Source Pattern*)

Aplikasi menggunakan pendekatan hybrid:
1. **Database Lokal (MySQL)**:
   - Digunakan untuk autentikasi user (`user_account`), session role, logging aktivitas, dan tabel/view relasional lokal.
2. **REST API Gateway Eksternal (`https://api.dharma-iaa.com/ws/admin/`)**:
   - Diintegrasikan melalui controller [`Curl.php`](application/controllers/Curl.php) menggunakan header rahasia `x-secret-key`.
   - Menjamin *API secret key* tersimpan aman di server dan tidak bocor ke browser sisi klien.

### Diagram Alur Data

```
[ Browser Klien / Member ]
       │
       ├── (1) POST auth/login ─────────────► [ Database MySQL Lokal ]
       │   (Validasi username & md5 pass)         (Tabel user_account)
       │
       └── (2) AJAX DataTables ─────────────► [ Controller: Curl.php ]
           (Meminta path data saldo/dividen)      │
                                                  ├── (3) cURL + x-secret-key
                                                  ▼
                                            [ REST API Pusat Dharma IAA ]
                                            (api.dharma-iaa.com/ws/admin/)
```

---

## 4. Daftar Modul & Fungsionalitas Utama

### A. Autentikasi & Keamanan ([`Auth.php`](application/controllers/Auth.php))
- **Login Akun**: Username berupa nomor rekening investor (contoh: `1887-xxxx`), password dienkripsi MD5.
- **Dynamic GD Captcha**: Captcha gambar acak anti-bot menggunakan pustaka GD PHP dengan font lokal (`Ubuntu.ttf`, `Merriweather.ttf`, `PlayfairDisplay.ttf`).
- **Ganti Password**: Memvalidasi kesesuaian password lama dan konfirmasi password baru dengan proteksi *database transaction* (commit/rollback).

### B. Dashboard Anggota ([`Dashboard.php`](application/controllers/Dashboard.php))
- Menampilkan identitas investor secara real-time dari API `clientId/{no_rekening}`:
  - NIK
  - Nama Lengkap
  - Tanggal Lahir
  - Alamat & Kecamatan/Kabupaten
  - Tanggal Terdaftar

### C. Saldo Investasi & Saldo Rata-rata Harian ([`Saldo_client.php`](application/controllers/Saldo_client.php))
- **Saldo Investasi** (`/saldo/investasi`): Filter dropdown tahun transaksi, menyajikan data transaksi investasi, penarikan, saldo akhir, dan keterangan mutasi.
- **Rata-rata Harian** (`/saldo/rata_harian`): Memuat data kalkulasi rata-rata saldo harian dan akumulasi per tahun dari API `saldoHarianId/{no_rekening}`.

### D. Distribusi dan Porsi SHU ([`Distribusi_dan_porsi.php`](application/controllers/Distribusi_dan_porsi.php))
- Menampilkan transparansi pembagian Sisa Hasil Usaha (SHU) berdasarkan tahun buku dari endpoint `dispen/{tahun}` dan `disda/{tahun}`:
  - Porsi alokasi SHU anggota (persentase, uraian, nilai, jumlah).
  - Porsi alokasi manajemen operasional.

### E. Dividen Persero ([`Bagi_hasil.php`](application/controllers/Bagi_hasil.php))
- Menampilkan rekapan pembagian dividen tahunan dari endpoint `devidenId/{no_rekening}`:
  - Saham Persero
  - Sisa Hasil Usaha
  - Nominal Bagi Hasil

### F. Surat Saham & Cetak Dokumen PDF ([`Copy_of_surat_saham.php`](application/controllers/Copy_of_surat_saham.php))
- Menampilkan daftar transaksi sertifikat saham dari API `transaksiId/{no_rekening}`.
- Terdapat aturan bisnis: nomor sertifikat dengan kode `0101` tidak dapat dicetak (transaksi inisial).
- Sertifikat lainnya dapat dicetak melalui Dompdf dengan custom landscape paper (`771 x 395 pt`) lengkap dengan background resmi dan QR Code verifikasi.

---

## 5. Struktur Direktori Proyek

```
iaa-member/
├── application/
│   ├── config/
│   │   ├── api.php.example          # Template konfigurasi URL & API Key
│   │   ├── database.php.example     # Template konfigurasi koneksi MySQL
│   │   ├── routes.php               # Mapping URL routing
│   │   ├── autoload.php             # Library & helper autoload
│   │   └── config.php               # Konfigurasi base URL, session, composer
│   ├── controllers/
│   │   ├── Auth.php                 # Autentikasi, session, captcha, password
│   │   ├── Dashboard.php            # Controller dashboard
│   │   ├── Saldo_client.php         # Controller saldo investasi & rata-rata harian
│   │   ├── Distribusi_dan_porsi.php # Controller distribusi porsi SHU
│   │   ├── Bagi_hasil.php           # Controller dividen persero
│   │   ├── Copy_of_surat_saham.php  # Controller sertifikat saham & export PDF
│   │   └── Curl.php                 # Controller API gateway proxy
│   ├── models/
│   │   ├── LoginModel.php           # Query tabel user_account & activity_log
│   │   ├── ProfilPemegangSaham.php  # Query tabel client_account
│   │   ├── TransaksiInvestasi.php   # Query transaksi_investasi & saldo_harian
│   │   ├── SisaHasilUsaha.php       # Query sisa_hasil_usaha
│   │   ├── SaldoHarian.php          # Query v_saldo_harian
│   │   ├── BagiHasil.php            # Query v_bagi_hasil
│   │   ├── DistribusiDanPorsi.php   # Query porsi distribusi
│   │   ├── SuratSaham.php           # Query v_transaksi
│   │   └── LaporanModel.php         # Query pelaporan data
│   ├── libraries/
│   │   ├── Cetak_pdf.php            # Wrapper library Dompdf
│   │   ├── Ciqrcode.php             # Library CodeIgniter QR Code
│   │   └── qrcode/                  # Engine PHP QR Code generator
│   └── views/
│       ├── client/                  # Tampilan UI portal member (Stisla)
│       │   ├── dashboard.php
│       │   ├── saldo_investasi.php
│       │   ├── saldo_rata_harian.php
│       │   ├── distribusi_porsi.php
│       │   ├── dividen_persero.php
│       │   ├── surat_saham.php
│       │   ├── cetak_surat_saham.php
│       │   └── menu.php
│       ├── users/                   # Tampilan login & ubah password
│       ├── header.php               # Template header & CSS loader
│       └── footer.php               # Template footer & script loader
├── assets/
│   ├── fonts/                       # File TTF untuk captcha
│   └── stisla/                      # Asset Stisla template (CSS/JS/images)
├── composer.json                    # Dependensi Composer (dompdf, html5)
└── index.php                        # Titik masuk utama CodeIgniter
```

---

## 6. Rekonstruksi Skema Database (MySQL)

Berdasarkan analisis terhadap query yang dipanggil di model:

### Tabel Fisik (*Base Tables*)
1. **`user_account`**
   - `user_id` (INT / VARCHAR, PK)
   - `username` (VARCHAR): Nomor rekening anggota
   - `userpass` (VARCHAR): MD5 hash
   - `role` (VARCHAR): Level akses (`user`, `admin`)
2. **`client_account`**
   - `no_rekening` (VARCHAR, PK)
   - `nama` (VARCHAR)
   - `nik` (VARCHAR)
   - `tgl_lahir` (DATE)
   - `alamat` (TEXT)
   - `kec` (VARCHAR), `kab` (VARCHAR)
   - `tgl_daftar` (DATE)
3. **`transaksi_investasi`**
   - `id_transaksi` (INT, PK)
   - `no_rekening` (VARCHAR, FK)
   - `tgl_transaksi` (DATE)
   - `jml_transaksi` (DECIMAL/INT)
   - `no_sertifikat` (VARCHAR)
   - `is_deleted` (TINYINT): Status soft delete (0 / 1)
   - `created_at` (DATETIME)
4. **`penarikan_investasi`**
   - `id_penarikan` (INT, PK)
   - `no_rekening` (VARCHAR, FK)
   - `jml_penarikan` (DECIMAL/INT)
   - `tgl_penarikan` (DATE)
   - `created_at` (DATETIME)
5. **`saldo_harian`**
   - `id_saldo` (INT, PK)
   - `no_rekening` (VARCHAR, FK)
   - `tahun` (YEAR/INT)
   - `rata_rata_harian` (DECIMAL/INT)
   - `rata_rata_tahun` (DECIMAL/INT)
   - `created_at` (DATETIME)
6. **`sisa_hasil_usaha`**
   - `id_shu` (INT, PK)
   - `tahun` (YEAR/INT)
   - `nilai_shu` (DECIMAL)
   - `created_at` (DATETIME)

### Database Views
1. **`v_activity`**: Log aktivitas login & transaksi.
2. **`v_bagi_hasil`**: Rekap bagi hasil per kecamatan dan tahun.
3. **`v_transaksi`**: Join antara data identitas anggota dan transaksi investasi.
4. **`v_transaksi_thn`**: Akumulasi total transaksi investasi per tahun.
5. **`v_saldo_harian`**: Rekapitulasi saldo rata-rata per tahun buku.

---

## 7. Panduan Menjalankan Sistem (*Setup & Run*)

### Prasyarat:
- PHP >= 8.1 dengan ekstensi: `pdo`, `mysqli`, `curl`, `gd`, `mbstring`, `xml`.
- Composer terpasang.
- Web Server: Apache / Nginx / PHP Built-in Server.
- Database: MySQL atau MariaDB.

### Langkah-langkah:

1. **Pasang Dependensi Composer**:
   ```bash
   composer install
   ```

2. **Siapkan Konfigurasi Database**:
   Salin `application/config/database.php.example` menjadi `application/config/database.php`:
   ```php
   $db['default'] = array(
       'hostname' => 'localhost',
       'username' => 'root',
       'password' => '',
       'database' => 'nama_database_iaa',
       'dbdriver' => 'mysqli',
       ...
   );
   ```

3. **Siapkan Konfigurasi REST API Pusat**:
   Salin `application/config/api.php.example` menjadi `application/config/api.php`:
   ```php
   $config['iaa_api_url'] = 'https://api.dharma-iaa.com/ws/admin/';
   $config['iaa_secret_key'] = 'masukkan_secret_key_anda_di_sini';
   ```

4. **Jalankan Web Server**:
   Jika menggunakan PHP built-in server:
   ```bash
   php -S localhost:8000
   ```
   Buka di peramban: `http://localhost:8000`

---

## 8. Catatan Isu Teknis & Solusi yang Direkomendasikan

1. **Routing Surat Saham Mengalami Discrepancy**:
   - *Masalah*: Link menu navigasi mengarah ke `site_url('surat_saham')`, namun nama file controller adalah `Copy_of_surat_saham.php`.
   - *Solusi*: Tambahkan route di `application/config/routes.php`:
     ```php
     $route['surat_saham'] = 'Copy_of_surat_saham';
     ```
     atau ganti nama file dan class menjadi `Surat_saham.php`.

2. **Peningkatan Keamanan Password**:
   - *Masalah*: Password saat ini di-hash dengan algoritma MD5 biasa yang sudah tidak direkomendasikan.
   - *Solusi*: Migrasikan ke standar `password_hash($password, PASSWORD_BCRYPT)` dan `password_verify()`.

3. **Pengamanan API Proxy ([`Curl.php`](application/controllers/Curl.php))**:
   - *Masalah*: Parameter `$_POST['path']` diterima secara terbuka tanpa validasi prefix.
   - *Solusi*: Buat whitelist path yang diizinkan (misal hanya `clientId/`, `saldoInvestasi/`, `saldoHarianId/`, `dispen/`, `disda/`, `devidenId/`, `transaksiId/`).

