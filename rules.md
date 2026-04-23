# Sistem Manajemen Laundry (CleanPro)

### 📄 Latar Belakang
Usaha laundry 'BersihCepat' di sekitar Grendeng ingin sistem digital untuk mencatat order, melacak status pengerjaan, dan menghitung estimasi selesai otomatis berdasarkan layanan yang dipilih pelanggan.

### 🎯 Tujuan Pembelajaran Spesifik
Mahasiswa memahami harga dinamis berbasis berat + layanan, workflow multi-status, dan perhitungan estimasi waktu selesai.

### ✅ Fitur Wajib Paket Ini
* Autentikasi (Admin, Kasir, Pelanggan) dengan Breeze/UI
* CRUD Jenis Layanan (Cuci Reguler, Cuci Express, Dry Clean, Setrika Saja) dengan harga/kg dan durasi hari
* CRUD Pelanggan (nama, alamat, no HP)
* Form Terima Order: pilih pelanggan, tambah multi-item (layanan + berat)
* Dashboard status: Diterima -> Dicuci -> Dikeringkan -> Disetrika -> Siap Diambil -> Selesai
* Halaman ubah status dengan log history (siapa, kapan mengubah)
* Cetak nota order (PDF) dengan total dan estimasi selesai
* Laporan pendapatan harian & bulanan (export Excel)
* Riwayat order per pelanggan

### 💧 Tantangan Unik Paket Ini
> **Penting:** Tantangan di bawah ini adalah poin penilaian UTAMA paket ini. Jika tidak diimplementasikan, fitur dianggap dasar dan tidak mendapat nilai maksimal pada aspek 'Logika Bisnis & Tantangan'.

50. Kalkulasi total: untuk setiap item -> `harga_per_kg x berat`; total order = sum subtotal
51. Estimasi tanggal selesai = `tanggal_terima + max(durasi_hari)` dari semua item layanan (bukan sum!)
52. Layanan Express memiliki biaya tambahan 50% dari harga normal
53. Status workflow harus urut: tidak bisa 'Siap Diambil' sebelum 'Disetrika'
54. Setiap perubahan status harus dicatat di tabel `status_histories` (siapa mengubah, waktu, status lama, status baru)
55. Kirim email notifikasi saat status berubah menjadi 'Siap Diambil' (gunakan `Mail::to` atau queue)
56. Pelanggan hanya bisa lihat riwayat order miliknya, dengan search by kode order

### 🗄️ Spesifikasi DDL MySQL (Wajib Diikuti)
Struktur tabel minimal berikut WAJIB ada di database. Anda boleh menambah kolom/tabel tambahan sesuai kebutuhan fitur, tetapi tidak boleh mengurangi atau mengubah nama/tipe kolom yang sudah didefinisikan. Migration Laravel harus mencerminkan struktur ini.
# 🧺 CleanPro — Laundry Management System

**Pemrograman Web II (CPMK-02 Project)**

---

## 👤 Student Information

* **Name:** Fahmi arif setiawan
* **NIM:** H1D024014
* **Package:** 4 — *Laundry Management System (CleanPro)*

---

## 📌 Project Overview

CleanPro is a web-based laundry management system built using **Laravel 13**.
The system is designed to help laundry businesses manage orders, track status, calculate pricing dynamically, and monitor workflow efficiently.

This project is part of the **CPMK-02 Web Programming II final assignment**, focusing on full-stack web development using Laravel.

---

## 🎯 Learning Objectives

This project demonstrates the ability to:

* Design relational databases with proper normalization & constraints
* Implement MVC architecture in Laravel (Model, View, Controller)
* Apply authentication & role-based authorization
* Handle complex business logic (workflow, calculations, state tracking)
* Build responsive UI using Bootstrap/Tailwind
* Use Git & GitHub professionally (meaningful commits)

---

## ⚙️ Tech Stack

* **Backend:** Laravel 13 (PHP 8.2+)
* **Database:** MySQL / MariaDB
* **Frontend:** Blade + Bootstrap / Tailwind
* **Version Control:** Git & GitHub
* **Tools:** Composer, Node.js, NPM, Vite

---

## 🔑 Core Features

### 1. Authentication

* Register, Login, Logout
* Password validation & email uniqueness

### 2. Role & Authorization

* Admin
* Staff / Customer
* Middleware-based route protection

### 3. CRUD Modules

* Customers
* Services (Laundry Types)
* Orders

### 4. Order Processing

* Multi-service per order
* Dynamic price calculation:

  ```
  total = price × weight
  ```

### 5. Workflow System

Laundry status flow:

```
Diterima → Dicuci → Dikeringkan → Disetrika → Siap Diambil → Selesai
```

### 6. Status History Tracking

* Every status change is logged
* Stored in `status_histories` table

### 7. Payment Handling

* Payment validation
* Order completion after payment

### 8. Search & Filter

* Search orders/customers
* Filter by status

### 9. Pagination

* Minimum 10 data per page

### 10. File Upload

* Upload proof (optional)

### 11. Export Report

* PDF / Excel export

### 12. Responsive Design

* Mobile, tablet, desktop friendly

### 13. Seeder

* Default admin account

---

## 🧠 Business Logic Highlights

* Dynamic pricing per service
* Order status state machine
* Status transition validation
* History tracking per order
* Multi-item order handling

---

## 🗄️ Database Structure (Simplified)

* `users`
* `customers`
* `services`
* `orders`
* `order_items`
* `status_histories`

---

## 🚀 Installation Guide

### 1. Clone Repository

```bash
git clone https://github.com/username/repo-name.git
cd repo-name
```

### 2. Install Backend

```bash
composer install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database

Edit `.env`:

```
DB_DATABASE=cleanpro
DB_USERNAME=root
DB_PASSWORD=
```

Create database in phpMyAdmin:

```
cleanpro_db
```

### 5. Run Migration & Seeder

```bash
php artisan migrate --seed
```

### 6. Install Frontend

```bash
npm install
npm run dev
```

### 7. Run Application

```bash
php artisan serve
```

or (Laragon):

```
http://project-name.test
```

---

## 🔐 Default Account

* **Email:** [admin@example.com](mailto:admin@example.com)
* **Password:** password

---

## 📊 Git Commit Strategy (IMPORTANT)

> Minimal 10 commit, meaningful, and done gradually.

### ✅ Commit Checkpoints

1. initial laravel project setup
2. setup authentication with breeze
3. create database migrations
4. define model relationships
5. implement CRUD services & customers
6. implement CRUD orders
7. add validation & flash messages
8. implement price calculation logic
9. implement workflow status system
10. add status history tracking
11. implement payment logic
12. improve UI & responsive design
13. add search, filter, pagination
14. implement file upload & export
15. final cleanup, seeder, documentation

---

## ⚠️ Important Rules

* Commit must be:

  * meaningful (not "update", "fix")
  * incremental (not all at once)
* Do NOT commit:

  * `/vendor`
  * `/node_modules`
  * `.env`
* Repository must be **PRIVATE**
* Add collaborator: **@mohammadirham37**

---

## 🎥 Demo Video

[YouTube Link Here]

---

## 📎 Notes

* This project is developed individually
* AI tools are used for learning support, not copying
* All code is understood and implemented manually

---

## 🏁 Conclusion

CleanPro demonstrates a complete Laravel full-stack implementation, combining backend logic, database design, and frontend interaction into a cohesive system.

---

✨ *Built with Laravel & determination*

database:
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','kasir','pelanggan') DEFAULT 'pelanggan',
    email_verified_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL
);

CREATE TABLE customers (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED UNIQUE,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT,
    created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE services (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(80) NOT NULL,
    price_per_kg DECIMAL(10,2) NOT NULL,
    duration_days INT UNSIGNED DEFAULT 2,
    is_express BOOLEAN DEFAULT FALSE,
    description TEXT,
    created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL
);

CREATE TABLE orders (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_code VARCHAR(20) UNIQUE NOT NULL,
    customer_id BIGINT UNSIGNED NOT NULL,
    received_by BIGINT UNSIGNED NOT NULL,
    received_at DATE NOT NULL,
    estimated_finish_date DATE NOT NULL,
    total_weight DECIMAL(8,2) NOT NULL,
    total_amount DECIMAL(12,2) NOT NULL,
    status ENUM('diterima','dicuci','dikeringkan','disetrika','siap_diambil','selesai') 
DEFAULT 'diterima',
    notes TEXT,
    created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (received_by) REFERENCES users(id)
);

CREATE TABLE order_items (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL,
    service_id BIGINT UNSIGNED NOT NULL,
    weight DECIMAL(8,2) NOT NULL,
    price_per_kg DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id)
);

CREATE TABLE status_histories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL,
    old_status VARCHAR(30),
    new_status VARCHAR(30) NOT NULL,
    changed_by BIGINT UNSIGNED NOT NULL,
    notes TEXT,
    created_at TIMESTAMP NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (changed_by) REFERENCES users(id)
);

🎯 ROADMAP CHECKPOINT VERSI NILAI MAKSIMAL
✅ CHECKPOINT 1 — Setup Project + DB

(sudah selesai)

Isi:

Laravel install
database connect
migrate jalan

Commit:

initial laravel setup and database configuration
✅ CHECKPOINT 2 — Authentication (WAJIB)

Isi:

login
register
logout
forgot password (kalau Breeze support)

Commit:

setup authentication using laravel breeze

🔥 Ini wajib banget.

✅ CHECKPOINT 3 — Role & Authorization (WAJIB)

Isi:

admin
staff/customer
middleware route protect
redirect sesuai role

Commit:

implement role based authorization system
✅ CHECKPOINT 4 — 3 CRUD Minimal (WAJIB BESAR)

Isi:

CRUD 1:

Services

CRUD 2:

Customers

CRUD 3:

Orders

Commit:

implement core CRUD modules for services customers and orders

🔥 Ini langsung memenuhi syarat besar.

✅ CHECKPOINT 5 — Validasi + Flash Message (WAJIB)

Isi:

required fields
old input
success alert
error alert

Commit:

add form validation and flash messages
✅ CHECKPOINT 6 — Search + Filter + Pagination (WAJIB)

Isi:

search customer
filter status order
paginate 10/page

Commit:

implement search filter and pagination features
✅ CHECKPOINT 7 — Laundry Core Logic (PAKET KHUSUS)

Isi:

hitung total harga
berat × layanan
estimasi

Commit:

implement laundry pricing and calculation logic
✅ CHECKPOINT 8 — Workflow Status System (PAKET KHUSUS)

Isi:

Received → Washing → Drying → Ironing → Ready → Completed

Commit:

implement laundry workflow status management
✅ CHECKPOINT 9 — Status History Tracking

Isi:

log perubahan status

Commit:

add status history tracking for orders
✅ CHECKPOINT 10 — Upload Feature (WAJIB)

Isi:

upload bukti pembayaran / foto item

Commit:

implement file upload feature for orders
✅ CHECKPOINT 11 — Export Report (WAJIB)

Isi:

export PDF / Excel transaksi

Commit:

add report export to pdf or excel
✅ CHECKPOINT 12 — Responsive UI

Isi:

mobile
tablet
desktop

Commit:

improve responsive user interface
✅ CHECKPOINT 13 — Seeder + README

Isi:

admin default
dummy data
dokumentasi

Commit:

add seeders and complete project documentation