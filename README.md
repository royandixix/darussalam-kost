<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://opensource.org/licenses/MIT">
    <img src="https://img.shields.io/badge/license-MIT-green" alt="License">
  </a>
</p>

# Sistem Informasi Kosan Darussalam
## Deskripsi Project
**Sistem Informasi Kosan Darussalam** adalah aplikasi berbasis website yang dibangun menggunakan framework Laravel untuk membantu pengelolaan kos secara digital.
Sistem ini dirancang untuk mempermudah pengelola kos dalam mengatur data kamar, pemesanan, feedback penghuni, serta laporan maintenance (kerusakan fasilitas). Seluruh proses pengelolaan kos menjadi lebih terstruktur, efisien, dan terdokumentasi dengan baik.

## Tujuan Sistem

- Mempermudah pemesanan kamar kos secara online
- Mengelola data kamar dan penghuni secara terpusat
- Menyediakan fitur feedback dari penghuni
- Menangani laporan kerusakan melalui sistem maintenance
- Meningkatkan kualitas pelayanan Kos Darussalam

---

## Fitur Utama

### Pengguna (User)

- Registrasi dan login akun
- Melihat daftar kamar yang tersedia
- Melakukan pemesanan kamar
- Memberikan feedback dan rating
- Mengirim laporan kerusakan fasilitas

### Admin (Filament Panel)

- Manajemen data kamar kos
- Manajemen data pemesanan
- Monitoring data pengguna
- Melihat dan merespons feedback penghuni
- Mengelola laporan maintenance
- Dashboard admin interaktif

---

## Teknologi yang Digunakan

| Teknologi | Keterangan |
|---|---|
| Laravel Framework | Backend utama aplikasi |
| PHP 8+ | Bahasa pemrograman server-side |
| MySQL | Database relasional |
| Filament Admin Panel | Panel administrasi |
| Tailwind CSS | Styling antarmuka |
| Vite | Build tool frontend |

---

## Cara Instalasi

**1. Clone repository**

```bash
git clone https://github.com/USERNAME/darussalam-kost.git
```

**2. Masuk ke folder project**

```bash
cd darussalam-kost
```

**3. Install dependency**

```bash
composer install
npm install
```

**4. Salin file environment**

```bash
cp .env.example .env
```

**5. Generate application key**

```bash
php artisan key:generate
```

**6. Konfigurasi database**

Sesuaikan nilai `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di file `.env` sesuai konfigurasi lokal Anda.

**7. Jalankan migrasi database**

```bash
php artisan migrate
```

**8. Jalankan server pengembangan**

```bash
php artisan serve
```

Aplikasi dapat diakses di `http://localhost:8000`.

---

## Tentang Penelitian

Project ini merupakan bagian dari penelitian:

> **"Implementasi Platform Pemesanan Kosan Darussalam Terintegrasi dengan Modul Feedback dan Maintenance Berbasis Website"**

---

## Developer

| Informasi | Detail |
|---|---|
| Nama | Siti Nurhalizah |
| NIM | 21024014067 |
| Universitas | Universitas Islam Makassar |
| Program Studi | Teknik Informatika |

---

## Lisensi

Project ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT) — bebas digunakan dan dikembangkan dengan tetap mencantumkan atribusi.
