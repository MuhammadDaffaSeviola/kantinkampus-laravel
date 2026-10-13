# API Contract — KantinKampus Laravel

Base URL:

http://127.0.0.1:8000/api/v1

Authentication:

Bearer Token menggunakan Laravel Sanctum.

---

## 1. Authentication

### POST /auth/register

Registrasi pengguna.

Request:

{
  "nim": "20260003",
  "name": "Mahasiswa Baru",
  "email": "mahasiswa3@kantinkampus.test",
  "password": "12345678",
  "role": "mahasiswa",
  "faculty": "Teknik"
}

Response:

{
  "status": "success",
  "message": "Registrasi berhasil",
  "data": {
    "user": {},
    "token": "..."
  }
}

### POST /auth/login

Login pengguna.

Request:

{
  "email": "apitest@kantinkampus.test",
  "password": "12345678"
}

Response:

{
  "status": "success",
  "message": "Login berhasil",
  "data": {
    "user": {},
    "token": "..."
  }
}

---

## 2. User

### GET /user

Mengambil data pengguna yang sedang login.

Authentication: Required

---

## 3. Canteens

### GET /canteens

Mengambil daftar kantin.

Authentication: Required

Response:

{
  "status": "success",
  "message": "Data kantin berhasil diambil",
  "data": []
}

### GET /canteens/{id}

Mengambil detail kantin.

Authentication: Required

---

## 4. Categories

### GET /categories

Mengambil daftar kategori menu.

Authentication: Required

Response:

{
  "status": "success",
  "message": "Data kategori berhasil diambil",
  "data": []
}

---

## 5. Menus

### GET /menus

Mengambil daftar menu beserta kantin dan kategori.

Authentication: Required

### GET /menus/{id}

Mengambil detail menu beserta:

- canteen
- category
- options

Authentication: Required

---

## 6. Menu Options

### GET /menus/{menuId}/options

Mengambil opsi menu yang tersedia.

Authentication: Required

Contoh:

{
  "status": "success",
  "message": "Data opsi menu berhasil diambil",
  "data": []
}

---

## 7. Orders

### POST /orders

Membuat pesanan baru.

Authentication: Required

### GET /orders

Mengambil daftar pesanan pengguna.

Authentication: Required

### GET /orders/{id}

Mengambil detail pesanan.

Authentication: Required

Detail dapat mencakup:

- canteen
- items
- menu
- options
- payment
- queue_ticket

### PATCH /orders/{id}/status

Memperbarui status pesanan.

Authentication: Required

Request:

{
  "status": "processing"
}

Status yang telah diuji:

- pending
- processing
- ready
- completed

---

## 8. Payment

### GET /orders/{orderId}/payment

Mengambil informasi pembayaran pesanan.

Authentication: Required

### POST /orders/{orderId}/payment

Memproses pembayaran.

Authentication: Required

Request:

{
  "payment_method": "cash"
}

Payment method:

- cash
- qris
- transfer

Response:

{
  "status": "success",
  "message": "Pembayaran berhasil diproses",
  "data": {
    "id": 4,
    "order_id": 4,
    "payment_method": "cash",
    "amount": "17000.00",
    "status": "paid",
    "paid_at": "..."
  }
}

Pembayaran berhasil akan mengubah status order menjadi:

paid

dan membuat nomor antrean secara otomatis.

---

## 9. Queue

### GET /orders/{orderId}/queue

Mengambil nomor antrean pesanan.

Authentication: Required

Contoh response:

{
  "status": "success",
  "message": "Data antrean berhasil diambil",
  "data": {
    "id": 3,
    "order_id": 4,
    "queue_number": "A003",
    "queue_status": "waiting",
    "estimated_wait_minutes": 10,
    "people_ahead": 1
  }
}

---

## 10. Error Response

Resource tidak ditemukan:

{
  "status": "error",
  "message": "Data tidak ditemukan",
  "data": null
}

Validation error menggunakan HTTP 422.

Unauthorized menggunakan HTTP 401.

---

## 11. Authentication Header

Endpoint yang membutuhkan autentikasi menggunakan:

Authorization: Bearer {token}

Accept: application/json

Content-Type: application/json

---

## 12. Current Backend Verification

Endpoint yang telah diuji menggunakan PowerShell:

- POST /auth/login
- GET /canteens
- GET /categories
- GET /menus
- GET /menus/{id}
- GET /menus/{menuId}/options
- POST /orders
- GET /orders/{id}
- POST /orders/{orderId}/payment
- GET /orders/{orderId}/payment
- GET /orders/{orderId}/queue
- PATCH /orders/{id}/status

Payment dan queue telah terbukti terintegrasi:

Payment:
paid

Queue:
waiting

Contoh nomor antrean:
A003