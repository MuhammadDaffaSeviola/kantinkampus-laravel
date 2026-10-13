# Architecture — KantinKampus Laravel API

## 1. Tujuan Aplikasi

KantinKampus adalah aplikasi pemesanan makanan pada lingkungan kampus.

Backend Laravel berfungsi sebagai REST API yang menangani:

- autentikasi pengguna;
- data kantin;
- kategori menu;
- menu dan opsi menu;
- pemesanan;
- pembayaran;
- nomor antrean;
- perubahan status pesanan.

Backend dipisahkan dari frontend Flutter dan dikembangkan dalam repository GitHub tersendiri.

---

## 2. Arsitektur Backend

Backend menggunakan pola:

MVC + API

Alur utama:

Route
→ Form Request
→ Controller
→ Model / Eloquent
→ MySQL
→ API Resource
→ JSON Response

Frontend tidak mengakses database secara langsung.

---

## 3. Struktur Folder Utama

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Controller.php
│   │   └── API/
│   │       ├── AuthController.php
│   │       ├── CanteenController.php
│   │       ├── CategoryController.php
│   │       ├── MenuController.php
│   │       ├── MenuOptionController.php
│   │       ├── OrderController.php
│   │       ├── PaymentController.php
│   │       └── QueueController.php
│   │
│   ├── Requests/
│   │   ├── Auth/
│   │   │   ├── LoginRequest.php
│   │   │   └── RegisterRequest.php
│   │   ├── Order/
│   │   │   └── StoreOrderRequest.php
│   │   └── Payment/
│   │       └── StorePaymentRequest.php
│   │
│   └── Resources/
│       ├── UserResource.php
│       ├── CanteenResource.php
│       ├── CategoryResource.php
│       ├── MenuResource.php
│       ├── MenuOptionResource.php
│       ├── OrderResource.php
│       ├── OrderItemResource.php
│       ├── PaymentResource.php
│       └── QueueTicketResource.php
│
├── Models/
│   ├── User.php
│   ├── Canteen.php
│   ├── Category.php
│   ├── Menu.php
│   ├── MenuOption.php
│   ├── Order.php
│   ├── OrderItem.php
│   ├── OrderItemOption.php
│   ├── Payment.php
│   └── QueueTicket.php
│
└── Providers/

database/
└── migrations/

routes/
├── api.php
├── web.php
└── console.php

docs/
├── architecture.md
├── erd.png
├── database.sql
└── api_contract.md