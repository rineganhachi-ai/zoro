# Tugas Laravel: CRUD Produk dengan Authentication

## Deskripsi Aplikasi

Aplikasi web manajemen produk berbasis **Laravel 12** dengan fitur autentikasi lengkap dan operasi CRUD. Setiap user yang terdaftar dapat login, menambahkan produk, melihat daftar produk miliknya, mengedit, menghapus, mengupload gambar, mencari, dan memfilter berdasarkan kategori.

Implementasi mengikuti pola MVC dengan pemisahan logika yang jelas, validasi input dalam Bahasa Indonesia, dan proteksi authorization sehingga setiap user hanya bisa mengakses data miliknya sendiri.

---

## Tech Stack

| Komponen           | Teknologi            |
| ------------------ | -------------------- |
| Framework          | Laravel 12           |
| Bahasa Pemrograman | PHP 8.1+             |
| Database           | MySQL / MariaDB      |
| CSS Framework      | Bootstrap 5.3        |
| Ikon               | Bootstrap Icons 1.10 |
| Templating Engine  | Blade                |

---

## Fitur Lengkap

### Autentikasi

| Fitur              | Detail                                                                                                                                  |
| ------------------ | --------------------------------------------------------------------------------------------------------------------------------------- |
| Register           | Form registrasi dengan validasi (nama, email unik, password min 6 karakter, konfirmasi password). Auto login setelah register berhasil. |
| Login              | Form login dengan validasi email & password. Support "Remember Me".                                                                     |
| Logout             | Menghapus session, invalidate token CSRF, redirect ke halaman login dengan pesan sukses.                                                |
| Session Regenerate | Setiap login berhasil, session di-regenerate untuk mencegah session fixation attack.                                                    |

---

### CRUD Produk

| Fitur         | Detail                                                                                                                                                                                                    |
| ------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Create        | Form tambah produk dengan field: nama, SKU (auto uppercase, hanya huruf besar + angka + dash), harga, stok, kategori (dropdown 4 pilihan), deskripsi, upload gambar, toggle status aktif.                 |
| Read (List)   | Tabel daftar produk dengan kolom: nama + kategori, SKU, harga (format Rupiah), stok (badge warna), status (badge), tombol aksi (detail, edit, hapus). Dilengkapi pagination, search bar, filter kategori. |
| Read (Detail) | Halaman detail menampilkan: gambar produk, tabel info (nama, SKU, kategori, harga, stok, status, pembuat, waktu dibuat, waktu diupdate), deskripsi.                                                       |
| Update        | Form edit sama dengan create, pre-filled data lama. Jika upload gambar baru, gambar lama otomatis dihapus dari storage. Validasi SKU mengabaikan produk yang sedang diedit (Rule::unique()->ignore()).    |
| Delete        | Hapus produk dengan konfirmasi JavaScript. Gambar di storage juga dihapus. Redirect ke daftar dengan pesan sukses.                                                                                        |

---

### Fitur Tambahan

| Fitur                     | Detail                                                                                                                             |
| ------------------------- | ---------------------------------------------------------------------------------------------------------------------------------- |
| Pagination                | 10 produk per halaman. Query string filter/search tetap terjaga saat pindah halaman (withQueryString()).                           |
| Search                    | Cari berdasarkan nama produk atau SKU. Menggunakan LIKE dengan subquery untuk mencari di kedua kolom sekaligus.                    |
| Filter Kategori           | Dropdown filter: Semua, Elektronik, Fashion, Makanan, Lainnya.                                                                     |
| Image Upload              | Upload gambar ke storage/app/public/products/. Validasi: hanya image, format JPEG/PNG/JPG/GIF, maks 2MB. Akses via Storage::url(). |
| Validasi Bahasa Indonesia | Semua pesan error validasi dalam Bahasa Indonesia (contoh: "Nama produk wajib diisi", "SKU sudah digunakan").                      |
| Authorization             | Setiap akses ke show/edit/update/destroy mengecek `$product->user_id !== auth()->id()`. Jika bukan pemilik, abort(403).            |
| Flash Messages            | Pesan sukses/error ditampilkan dengan alert Bootstrap yang bisa ditutup (tombol X).                                                |
| Navbar Dropdown           | Menu dropdown user menampilkan nama, email, dan tombol logout.                                                                     |
| Data Persistence          | Jika validasi gagal, input yang sudah diisi tetap ada (`old()`).                                                                   |

---

## Struktur Project

```bash
tugas-laravel/
├── app/
│ ├── Http/
│ │ └── Controllers/
│ │ ├── Controller.php ← Base controller (extends \Illuminate\Routing\Controller)
│ │ ├── AuthController.php ← Login, Register, Logout
│ │ └── ProductController.php ← Index, Create, Store, Show, Edit, Update, Destroy
│ └── Models/
│ ├── User.php ← Model user + relasi hasMany(products)
│ └── Product.php ← Model produk + relasi belongsTo(user) + accessor
├── database/
│ └── migrations/
│ └── xxxx_create_products_table.php ← Struktur tabel products
├── resources/
│ └── views/
│ ├── layouts/
│ │ └── app.blade.php ← Layout utama (navbar dropdown + flash messages + @stack)
│ ├── auth/
│ │ ├── login.blade.php ← Form login dengan error display
│ │ └── register.blade.php ← Form register dengan error display
│ └── products/
│ ├── index.blade.php ← Daftar produk + search + filter + pagination
│ ├── create.blade.php ← Form tambah produk + upload gambar
│ ├── show.blade.php ← Detail produk + gambar + info table
│ └── edit.blade.php ← Form edit produk + preview gambar lama
├── routes/
│ └── web.php ← Semua route (public auth + protected group)
├── storage/
│ └── app/
│ └── public/
│ └── products/ ← Folder gambar yang diupload
├── public/
│ └── storage ← Symlink ke storage/app/public
├── .env ← Konfigurasi database
├── .gitignore ← File yang tidak di-commit
└── composer.json
```

---

## Database Schema

### Tabel `users` (Bawaan Laravel)

| Kolom               | Tipe                  | Keterangan                   |
| ------------------- | --------------------- | ---------------------------- |
| `id`                | BIGINT UNSIGNED AI    | Primary key                  |
| `name`              | VARCHAR(255)          | Nama lengkap user            |
| `email`             | VARCHAR(255)          | Email (UNIQUE)               |
| `email_verified_at` | TIMESTAMP NULLABLE    | Waktu verifikasi email       |
| `password`          | VARCHAR(255)          | Password (hashed via bcrypt) |
| `remember_token`    | VARCHAR(100) NULLABLE | Token "Remember Me"          |
| `created_at`        | TIMESTAMP             | Waktu dibuat                 |
| `updated_at`        | TIMESTAMP             | Waktu diupdate               |

---

### Tabel `products`

| Kolom         | Tipe                                             | Keterangan                      |
| ------------- | ------------------------------------------------ | ------------------------------- |
| `id`          | BIGINT UNSIGNED AI                               | Primary key                     |
| `name`        | VARCHAR(255)                                     | Nama produk                     |
| `sku`         | VARCHAR(50)                                      | Stock Keeping Unit (UNIQUE)     |
| `description` | TEXT NULLABLE                                    | Deskripsi produk (boleh kosong) |
| `price`       | DECIMAL(15,2)                                    | Harga produk                    |
| `stock`       | INT                                              | Jumlah stok                     |
| `category`    | ENUM('Elektronik','Fashion','Makanan','Lainnya') | Kategori                        |
| `image`       | VARCHAR(255) NULLABLE                            | Path gambar                     |
| `is_active`   | BOOLEAN DEFAULT TRUE                             | Status                          |
| `user_id`     | BIGINT UNSIGNED                                  | Foreign key                     |
| `created_at`  | TIMESTAMP                                        | Waktu dibuat                    |
| `updated_at`  | TIMESTAMP                                        | Waktu diupdate                  |

---

### Relasi

```
users (1) ──────────────< products (N)
users.id ◄────────────── products.user_id
```

onDelete: CASCADE
(Jika user dihapus, semua produk ikut terhapus)

---

## Penjelasan Singkat

### Controller

* AuthController → login, register, logout
* ProductController → CRUD produk

### Model

* User → hasMany(Product)
* Product → belongsTo(User)

---

## Cara Install & Jalankan

```bash
# Clone repository
git clone https://github.com/rineganhachi-ai/zoro
cd zoro

# Install dependency
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate

# Storage
php artisan storage:link

# Run
php artisan serve
```

Buka:

```
http://127.0.0.1:8000/register
```

---

## Konsep Laravel

### Mass Assignment

```php
protected $fillable = ['name', 'sku', 'description', 'price', 'stock', 'category', 'image', 'is_active', 'user_id'];
```

### Route Model Binding

```php
public function show(Product $product)
```

### CSRF Protection

```blade
@csrf
```

### Eloquent ORM

```php
Product::where('name', 'LIKE', "%{$search}%")
```

### Blade Security

```blade
{{ $product->name }}
{!! $html !!}
```

---

## Screenshot Fitur

* Halaman Register
* Halaman Login
* Navbar
* Daftar Produk
* Tambah Produk
* Detail Produk
* Edit Produk
* Validasi Error
* Flash Message

---
