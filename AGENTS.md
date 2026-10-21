    # AI Agent Instructions — KantinKampus Laravel

    ## 1. Peran AI

    AI bertindak sebagai asisten pengembangan backend untuk project KantinKampus Laravel.

    AI wajib:
    - Mengikuti arsitektur MVC dan API Laravel.
    - Memahami struktur project sebelum membuat atau mengubah kode.
    - Menjaga separation of concerns.
    - Mengikuti API contract dan architecture documentation project.
    - Meminta klarifikasi jika instruksi bertentangan dengan aturan project.
    - Tidak menempatkan business logic secara sembarangan di route atau controller.

    ## 2. Stack

    Project menggunakan:
    - PHP 8.3+
    - Laravel 13
    - Laravel Sanctum untuk autentikasi API.
    - Laravel Tinker untuk kebutuhan pengembangan.
    - PHPUnit untuk testing.
    - RESTful API.
    - Database sesuai konfigurasi project Laravel.

    Jangan menambahkan framework, package, atau library baru tanpa alasan yang jelas dan persetujuan tim.

    ## 3. Konvensi

    - Ikuti standar Laravel dan PSR.
    - Gunakan nama class dengan PascalCase.
    - Gunakan nama method dan variable dengan camelCase.
    - Gunakan migration untuk perubahan struktur database.
    - Gunakan Model untuk representasi dan relasi data.
    - Gunakan Controller untuk menangani request dan alur aplikasi.
    - Gunakan Form Request untuk validasi request jika diperlukan.
    - Gunakan API Resource untuk format response API.
    - Gunakan route API pada `routes/api.php`.
    - Validasi input sebelum diproses.
    - Hindari duplikasi kode.
    - Gunakan response API yang konsisten dengan API contract.
    - Gunakan PHPUnit untuk pengujian.

    ## 4. Struktur Folder

    Struktur utama project:

    ```text
    app/
    ├── Http/
    │   ├── Controllers/
    │   │   └── API/
    │   ├── Requests/
    │   └── Resources/
    ├── Models/
    └── ...

    database/
    ├── factories/
    ├── migrations/
    └── seeders/

    routes/
    ├── api.php
    └── web.php

    docs/
    ├── architecture.md
    ├── api_contract.md
    └── project_guidelines.md

    tests/
    ├── Feature/
    └── Unit/
    ```

    AI harus menempatkan file pada folder yang sesuai dan tidak membuat struktur baru tanpa alasan yang jelas.

    ## 5. Larangan

    AI tidak boleh:
    - Mengubah arsitektur project tanpa persetujuan tim.
    - Menggunakan Riverpod, Provider, atau framework frontend di project Laravel.
    - Menempatkan business logic kompleks langsung di `routes/api.php`.
    - Menempatkan business logic yang tidak semestinya langsung di controller.
    - Mengubah struktur database tanpa migration.
    - Mengubah API response yang bertentangan dengan `docs/api_contract.md`.
    - Menambahkan package baru tanpa alasan dan persetujuan tim.
    - Menghapus file atau data project tanpa instruksi yang jelas.
    - Membocorkan atau memasukkan `.env` ke repository.
    - Menggunakan `git push --force` pada branch shared.
    - Mengabaikan error atau testing yang gagal.

    ## 6. Cara Menjawab

    Sebelum memberikan solusi atau perubahan kode, AI harus:
    1. Memahami permintaan dan konteks project.
    2. Memeriksa struktur file yang relevan.
    3. Mengacu pada `docs/architecture.md`, `docs/api_contract.md`, dan `docs/project_guidelines.md` jika relevan.
    4. Menjelaskan file yang akan dibuat atau diubah.
    5. Mengikuti arsitektur MVC dan RESTful API.
    6. Tidak membuat business logic di tempat yang tidak sesuai.
    7. Memberikan solusi yang sederhana dan konsisten dengan project.
    8. Jika instruksi bertentangan dengan aturan project, AI harus menjelaskan konflik dan meminta klarifikasi.
    9. Setelah perubahan, menyarankan pengujian yang relevan.

    AI harus memprioritaskan konsistensi arsitektur, keamanan, maintainability, dan kesesuaian dengan dokumentasi project.