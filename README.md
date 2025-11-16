# 📘 Employee Management System (EMS) – Simple Version

Sebuah aplikasi manajemen pegawai sederhana yang dibuat untuk menyelesaikan **Technical Test Full Stack Developer Intern – Sinergi Impact Indonesia**.

---

# 🚀 Overview

Aplikasi ini dibangun menggunakan **Laravel 11** dan **FilamentPHP v3** sebagai admin panel untuk mempercepat proses development. Sistem menyediakan fitur login admin, dashboard sederhana, dan CRUD data pegawai.

---

# 🛠️ Tech Stack

* **Laravel 11** (Backend Framework)
* **FilamentPHP v3** (Admin Panel)
* **MySQL** (Database)
* **PHP 8.2+**
* **Composer & Node.js**

---

# ✨ Features

## 🔐 Admin Authentication

* Login admin menggunakan guard bawaan Laravel.
* Tanpa multi-role untuk kesederhanaan.

## 📊 Dashboard

Dashboard menampilkan:

* Total pegawai
* (Bonus) Total pegawai aktif
* (Bonus) Jumlah divisi terisi
* (Bonus) Daftar 5 pegawai terbaru

## 👥 Employee CRUD

Admin dapat melakukan:

* Menambah pegawai
* Mengedit pegawai
* Menghapus pegawai
* Melihat daftar pegawai

## 📌 Employee Data Structure

Fields utama pegawai meliputi:

* NIK
* Nama lengkap
* Email
* Jenis kelamin
* Jabatan
* Divisi
* Tanggal bergabung
* ID unik otomatis (UUID)
* (Opsional) Nomor telepon, tanggal lahir, alamat, status, gaji pokok

---

# 📂 Project Structure (Simplified)

```
app/
├── Filament/
│   ├── Pages/
│   ├── Resources/
│   │   └── EmployeeResource.php
│   └── Widgets/
│       ├── StatsOverview.php
│       └── LatestOrderTable.php
├── Models/Employee.php
```

---

# ⚙️ Installation Guide

## 1. Clone Repository

```
git clone <repo-url>
cd employee-management
```

## 2. Install Dependencies

```
composer install
npm install
```

## 3. Environment Setup

```
cp .env.example .env
php artisan key:generate
```

Atur koneksi database di `.env`.

## 4. Run Migration

```
php artisan migrate --seed
```

Seeder akan membuat 1 akun admin default:


```
Email : admin@example.com
Password : password
```
Atau menggunakan **php artisan make:filament-user** jika tidak ingin menggunakan seeder

## 5. Start Development Server

```
php artisan serve
```

Akses admin panel di:

```
http://localhost:8000/admin
```

---

# 🧪 Demo Video

> [Demo Video Penjelasan](https://drive.google.com/file/d/1WZSFT0rHJGjpH_h0WYXDRz-uJEFt-09E/view?usp=sharing).

---

# 📝 Notes

* Sistem dibuat dengan struktur kode bersih dan mudah dipahami.
* Seluruh validasi form menggunakan Laravel Validator & Filament Form Rules.
* ID pegawai menggunakan UUID otomatis.

---

# 🏁 Conclusion

Aplikasi ini dibangun untuk menampilkan kemampuan dasar Full Stack Development menggunakan Laravel + FilamentPHP. Dengan arsitektur yang rapi dan fitur yang sesuai requirement, sistem siap diuji dan dikembangkan lebih lanjut.
