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
