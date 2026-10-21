# Project Guidelines — KantinKampus Laravel

## 1. Overview

KantinKampus Laravel merupakan backend API untuk mendukung aplikasi KantinKampus.

Project dikembangkan menggunakan Laravel dengan pendekatan MVC dan RESTful API. Backend bertanggung jawab terhadap pengelolaan data, autentikasi, validasi, serta penyediaan endpoint yang digunakan oleh aplikasi Flutter.

Dokumen ini menjadi panduan utama pengembangan dan harus digunakan bersama:
- `docs/architecture.md`
- `docs/api_contract.md`
- `AGENTS.md`

## 2. Arsitektur Laravel

Project menggunakan pola MVC dan API Laravel.

Struktur utama:
- `app/Models/` untuk model dan relasi database.
- `app/Http/Controllers/API/` untuk menangani request API.
- `app/Http/Requests/` untuk validasi request.
- `app/Http/Resources/` untuk format response API.
- `database/migrations/` untuk struktur database.
- `database/seeders/` untuk data awal.
- `routes/api.php` untuk endpoint REST API.
- `tests/` untuk pengujian.

Prinsip utama:
- Separation of concerns.
- Validasi dilakukan sebelum data diproses.
- Perubahan database dilakukan melalui migration.
- Response API mengikuti API contract.
- Business logic tidak ditempatkan langsung pada route.

## 3. Database Summary

Database digunakan untuk menyimpan data utama yang dibutuhkan sistem KantinKampus.

Struktur tabel dan relasi database mengikuti rancangan pada:
`docs/architecture.md`

Perubahan struktur database wajib menggunakan Laravel migration.

Aturan database:
- Gunakan primary key dan foreign key sesuai kebutuhan.
- Gunakan relasi Eloquent pada Model.
- Hindari duplikasi data yang tidak diperlukan.
- Jangan mengubah struktur database secara manual tanpa migration.
- Seeder digunakan untuk data awal atau data pengujian.

## 4. API Summary

Backend menyediakan RESTful API untuk komunikasi dengan aplikasi Flutter.

Endpoint dan format response mengikuti:
`docs/api_contract.md`

Ketentuan API:
- Endpoint API ditempatkan pada `routes/api.php`.
- Gunakan HTTP method sesuai fungsi endpoint.
- Validasi request sebelum diproses.
- Gunakan authentication dan authorization sesuai kebutuhan.
- Response harus memiliki format yang konsisten.
- Gunakan API Resource jika diperlukan untuk membentuk response.
- Error harus dikembalikan dengan HTTP status yang sesuai.

Laravel Sanctum digunakan untuk kebutuhan autentikasi API.

## 5. Design System

Backend tidak mengatur tampilan UI secara langsung. Namun, struktur response API harus mendukung kebutuhan aplikasi Flutter.

Ketentuan:
- Nama field response harus konsisten dengan API contract.
- Jangan mengubah nama atau struktur response tanpa memperbarui dokumentasi.
- Data yang dikirim ke Flutter harus relevan dengan kebutuhan fitur.
- Format tanggal, status, identifier, dan data lainnya harus konsisten.
- Perubahan yang memengaruhi UI Flutter harus dikomunikasikan kepada tim Flutter.

## 6. Code Review Checklist

Sebelum perubahan di-merge, reviewer memeriksa:

- [ ] Struktur file sesuai arsitektur Laravel.
- [ ] Tidak ada business logic kompleks di route.
- [ ] Controller tetap terorganisasi.
- [ ] Validasi request sudah diterapkan jika diperlukan.
- [ ] Model dan relasi sesuai database.
- [ ] Perubahan database menggunakan migration.
- [ ] Response API sesuai `api_contract.md`.
- [ ] Tidak ada credential atau `.env` yang di-commit.
- [ ] Tidak menambahkan package tanpa alasan yang jelas.
- [ ] Testing yang relevan sudah dilakukan.
- [ ] Tidak ada perubahan yang tidak berkaitan dengan fitur.
- [ ] Kode mengikuti standar Laravel dan PSR.

## 7. Rules untuk AI

AI harus:
- Membaca `AGENTS.md` sebelum memberikan perubahan kode.
- Mengacu pada `docs/architecture.md` dan `docs/api_contract.md` jika relevan.
- Mempertahankan arsitektur MVC dan RESTful API.
- Menempatkan file pada folder yang sesuai.
- Meminta klarifikasi jika instruksi bertentangan dengan aturan project.
- Menjelaskan file yang akan dibuat atau diubah.
- Menyarankan pengujian setelah perubahan.

AI tidak boleh:
- Mengubah arsitektur tanpa persetujuan tim.
- Menambahkan framework atau package tanpa alasan dan persetujuan.
- Menaruh business logic kompleks pada route.
- Mengubah API contract secara diam-diam.
- Memasukkan `.env` atau credential ke repository.
- Menghapus data atau file penting tanpa instruksi.
- Menggunakan `git push --force` pada branch shared.

## 8. Git Workflow

Pengembangan dilakukan menggunakan branch agar `main` tetap stabil.

Struktur branch:

```text
main
└── dev
    ├── feature/[nama]
    ├── fix/[nama]
    └── docs/[nama]
```

Aturan:
1. Jangan bekerja langsung pada `main`.
2. Buat branch dari `dev` untuk perubahan.
3. Gunakan Conventional Commits.
4. Push branch ke repository.
5. Buat Pull Request menuju `dev`.
6. Pull Request harus direview anggota lain.
7. Setelah disetujui, perubahan dapat di-merge.
8. Perubahan yang sudah dipush dibatalkan menggunakan `git revert` jika diperlukan.
9. Jangan menggunakan `git push --force` pada branch shared.

Contoh commit:

```text
feat(menu): add menu listing endpoint
fix(order): fix order validation
docs(api): update API documentation
test(order): add order API test
```

## Referensi Proyek

Dokumen yang menjadi acuan pengembangan:

- `AGENTS.md`
- `docs/architecture.md`
- `docs/api_contract.md`
- `docs/project_guidelines.md`