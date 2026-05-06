README.md Lengkap Sesuai Dashboard
Simpan sebagai README.md di root project:

Tugas Laravel: CRUD Produk dengan Authentication
Deskripsi Aplikasi
Aplikasi web manajemen produk berbasis Laravel 12 dengan fitur autentikasi lengkap dan operasi CRUD. Setiap user yang terdaftar dapat login, menambahkan produk, melihat daftar produk miliknya, mengedit, menghapus, mengupload gambar, mencari, dan memfilter berdasarkan kategori. Implementasi mengikuti pola MVC dengan pemisahan logika yang jelas, validasi input dalam Bahasa Indonesia, dan proteksi authorization sehingga setiap user hanya bisa mengakses data miliknya sendiri.

Tech Stack
Komponen	Teknologi	Versi
Framework	Laravel	12.x
Bahasa Pemrograman	PHP	8.2+
Database	MySQL	5.7+
CSS Framework	Bootstrap	5.3
Ikon	Bootstrap Icons	1.10
Templating Engine	Blade	Bawaan Laravel
Fitur Lengkap
Autentikasi
Register — Form registrasi dengan validasi (nama, email unik, password min 6 karakter, konfirmasi password). Auto login setelah register berhasil.
Login — Form login dengan validasi email & password. Support "Remember Me".
Logout — Menghapus session, invalidate token CSRF, redirect ke halaman login dengan pesan sukses.
Session Regenerate — Setiap login berhasil, session di-regenerate untuk mencegah session fixation attack.
CRUD Produk
Create — Form tambah produk dengan field: nama, SKU (auto uppercase, hanya huruf besar + angka + dash), harga, stok, kategori (dropdown 4 pilihan), deskripsi, upload gambar, toggle status aktif.
Read (List) — Tabel daftar produk dengan kolom: nama + kategori, SKU, harga (format Rupiah), stok (badge warna), status (badge), tombol aksi (detail, edit, hapus). Dilengkapi pagination, search bar, filter kategori.
Read (Detail) — Halaman detail menampilkan: gambar produk, tabel info (nama, SKU, kategori, harga, stok, status, pembuat, waktu dibuat, waktu diupdate), deskripsi.
Update — Form edit sama dengan create, pre-filled data lama. Jika upload gambar baru, gambar lama otomatis dihapus dari storage. Validasi SKU mengabaikan produk yang sedang diedit (Rule::unique()->ignore()).
Delete — Hapus produk dengan konfirmasi JavaScript. Gambar di storage juga dihapus. Redirect ke daftar dengan pesan sukses.
Fitur Tambahan
Pagination — 10 produk per halaman. Query string filter/search tetap terjaga saat pindah halaman (withQueryString()).
Search — Cari berdasarkan nama produk atau SKU. Menggunakan LIKE dengan subquery untuk mencari di kedua kolom sekaligus.
Filter Kategori — Dropdown filter: Semua, Elektronik, Fashion, Makanan, Lainnya.
Image Upload — Upload gambar ke storage/app/public/products/. Validasi: hanya image, format JPEG/PNG/JPG/GIF, maks 2MB. Akses via Storage::url().
Validasi Bahasa Indonesia — Semua pesan error validasi dalam Bahasa Indonesia (contoh: "Nama produk wajib diisi", "SKU sudah digunakan").
Authorization — Setiap akses ke show/edit/update/destroy mengecek product->user_id !== auth()->id(). Jika bukan pemilik, abort 403.
Flash Messages — Pesan sukses/error ditampilkan dengan alert Bootstrap yang bisa ditutup (tombol X).
Navbar Dropdown — Menu dropdown user menampilkan nama, email, dan tombol logout.
Data Persistence — Jika validasi gagal, input yang sudah diisi tetap ada (old()).
Struktur Project

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

README.md Lengkap Sesuai Dashboard
Simpan sebagai README.md di root project:

Tugas Laravel: CRUD Produk dengan Authentication
Deskripsi Aplikasi
Aplikasi web manajemen produk berbasis Laravel 12 dengan fitur autentikasi lengkap dan operasi CRUD. Setiap user yang terdaftar dapat login, menambahkan produk, melihat daftar produk miliknya, mengedit, menghapus, mengupload gambar, mencari, dan memfilter berdasarkan kategori. Implementasi mengikuti pola MVC dengan pemisahan logika yang jelas, validasi input dalam Bahasa Indonesia, dan proteksi authorization sehingga setiap user hanya bisa mengakses data miliknya sendiri.

Tech Stack
Komponen	Teknologi	Versi
Framework	Laravel	12.x
Bahasa Pemrograman	PHP	8.2+
Database	MySQL	5.7+
CSS Framework	Bootstrap	5.3
Ikon	Bootstrap Icons	1.10
Templating Engine	Blade	Bawaan Laravel
Fitur Lengkap
Autentikasi
Register — Form registrasi dengan validasi (nama, email unik, password min 6 karakter, konfirmasi password). Auto login setelah register berhasil.
Login — Form login dengan validasi email & password. Support "Remember Me".
Logout — Menghapus session, invalidate token CSRF, redirect ke halaman login dengan pesan sukses.
Session Regenerate — Setiap login berhasil, session di-regenerate untuk mencegah session fixation attack.
CRUD Produk
Create — Form tambah produk dengan field: nama, SKU (auto uppercase, hanya huruf besar + angka + dash), harga, stok, kategori (dropdown 4 pilihan), deskripsi, upload gambar, toggle status aktif.
Read (List) — Tabel daftar produk dengan kolom: nama + kategori, SKU, harga (format Rupiah), stok (badge warna), status (badge), tombol aksi (detail, edit, hapus). Dilengkapi pagination, search bar, filter kategori.
Read (Detail) — Halaman detail menampilkan: gambar produk, tabel info (nama, SKU, kategori, harga, stok, status, pembuat, waktu dibuat, waktu diupdate), deskripsi.
Update — Form edit sama dengan create, pre-filled data lama. Jika upload gambar baru, gambar lama otomatis dihapus dari storage. Validasi SKU mengabaikan produk yang sedang diedit (Rule::unique()->ignore()).
Delete — Hapus produk dengan konfirmasi JavaScript. Gambar di storage juga dihapus. Redirect ke daftar dengan pesan sukses.
Fitur Tambahan
Pagination — 10 produk per halaman. Query string filter/search tetap terjaga saat pindah halaman (withQueryString()).
Search — Cari berdasarkan nama produk atau SKU. Menggunakan LIKE dengan subquery untuk mencari di kedua kolom sekaligus.
Filter Kategori — Dropdown filter: Semua, Elektronik, Fashion, Makanan, Lainnya.
Image Upload — Upload gambar ke storage/app/public/products/. Validasi: hanya image, format JPEG/PNG/JPG/GIF, maks 2MB. Akses via Storage::url().
Validasi Bahasa Indonesia — Semua pesan error validasi dalam Bahasa Indonesia (contoh: "Nama produk wajib diisi", "SKU sudah digunakan").
Authorization — Setiap akses ke show/edit/update/destroy mengecek product->user_id !== auth()->id(). Jika bukan pemilik, abort 403.
Flash Messages — Pesan sukses/error ditampilkan dengan alert Bootstrap yang bisa ditutup (tombol X).
Navbar Dropdown — Menu dropdown user menampilkan nama, email, dan tombol logout.
Data Persistence — Jika validasi gagal, input yang sudah diisi tetap ada (old()).
Struktur Project
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


---

## Database Schema

### Tabel `users` (Bawaan Laravel)

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT UNSIGNED AI | Primary key |
| name | VARCHAR(255) | Nama lengkap user |
| email | VARCHAR(255) | Email (UNIQUE) |
| email_verified_at | TIMESTAMP NULLABLE | Waktu verifikasi email |
| password | VARCHAR(255) | Password (hashed via bcrypt) |
| remember_token | VARCHAR(100) NULLABLE | Token "remember me" |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diupdate |

### Tabel `products`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT UNSIGNED AI | Primary key |
| name | VARCHAR(255) | Nama produk |
| sku | VARCHAR(50) | Stock Keeping Unit (UNIQUE) |
| description | TEXT NULLABLE | Deskripsi produk (boleh kosong) |
| price | DECIMAL(15,2) | Harga produk (15 digit, 2 di belakang koma) |
| stock | INT | Jumlah stok tersedia |
| category | ENUM('Elektronik','Fashion','Makanan','Lainnya') | Kategori produk |
| image | VARCHAR(255) NULLABLE | Path file gambar di storage |
| is_active | BOOLEAN DEFAULT TRUE | Status produk aktif/tidak |
| user_id | BIGINT UNSIGNED | Foreign key ke users.id |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diupdate |

### Relasi

Tabel: users (1) ──────────────< Tabel: products (N)

users.id ◄────────────── products.user_id

onDelete: CASCADE
(Jika user dihapus, semua produk user tersebut ikut terhapus)


**Implementasi di Model:**
- `User.php` → `return $this->hasMany(Product::class)` 
- `Product.php` → `return $this->belongsTo(User::class)`

---

## Penjelasan Setiap File

### `app/Http/Controllers/Controller.php`

```php
abstract class Controller extends \Illuminate\Routing\Controller

Mengapa ini penting? Laravel 12 membuat Controller kosong tanpa parent class. Tanpa extends \Illuminate\Routing\Controller, method seperti middleware(), validate(), dan authorize() tidak akan tersedia. Ini adalah akar dari error "Call to undefined method middleware()".

app/Http/Controllers/AuthController.php
Method
HTTP
URL
Fungsi
showLoginForm()	GET	/login	Tampilkan form login. Jika sudah login, redirect ke /products
login()	POST	/login	Validasi email+password, Auth::attempt, regenerate session, redirect
showRegisterForm()	GET	/register	Tampilkan form register. Jika sudah login, redirect ke /products
register()	POST	/register	Validasi (name, email unique, password confirmed), Hash::make, User::create, Auth::login
logout()	POST	/logout	Auth::logout, invalidate session, regenerate token, redirect

Keamanan yang diterapkan:

Password di-hash otomatis via Hash::make() (bcrypt)
Session di-regenerate setelah login (cegah session fixation)
CSRF token otomatis via @csrf di form
Email dicek keunikan di database (unique:users,email)
app/Http/Controllers/ProductController.php
Method
HTTP
URL
Fungsi
__construct()	-	-	Daftarkan middleware auth untuk semua method
index()	GET	/products	Query produk user + search + filter + pagination
create()	GET	/products/create	Tampilkan form tambah dengan data kategori
store()	POST	/products	Validasi + upload gambar + Product::create
show()	GET	/products/{id}	Tampilkan detail produk (cek ownership)
edit()	GET	/products/{id}/edit	Tampilkan form edit (cek ownership)
update()	PUT	/products/{id}	Validasi + ganti gambar + product->update (cek ownership)
destroy()	DELETE	/products/{id}	Hapus gambar + product->delete (cek ownership)

Konsep penting:

Route Model Binding — Parameter type-hinted Product $product otomatis mencari by ID, 404 otomatis jika tidak ketemu
Authorization — Setiap method akses data tunggal cek $product->user_id !== auth()->id(), jika tidak cocok abort(403)
Rule::unique()->ignore() — Saat edit, validasi SKU unik mengabaikan produk yang sedang diedit sendiri
Image handling — Upload ke storage/app/public/products/ via $request->file('image')->store('products', 'public'), hapus via Storage::disk('public')->delete($path)
app/Models/Product.php
Bagian
Fungsi
$fillable	Mass Assignment Protection — hanya field ini yang boleh diisi via Product::create()
casts()	Auto-casting: price selalu decimal 2 desimal, is_active selalu boolean
user()	Relasi belongsTo — $product->user mengembalikan objek User pembuat produk
getPriceFormattedAttribute()	Accessor — $product->price_formatted mengembalikan "Rp 15.000.000"
getStatusTextAttribute()	Accessor — $product->status_text mengembalikan "Aktif" / "Tidak Aktif"

app/Models/User.php
Bagian
Fungsi
$fillable	name, email, password
casts()	password → hashed (otomatis hash saat disimpan)
products()	Relasi hasMany — $user->products mengembalikan koleksi semua produk user

Public (tanpa login):
  GET  /login     → AuthController@showLoginForm
  POST /login     → AuthController@login
  GET  /register  → AuthController@showRegisterForm
  POST /register  → AuthController@register
  POST /logout    → AuthController@logout

Protected (middleware: auth):
  GET  /               → redirect ke /products
  GET  /products       → ProductController@index
  GET  /products/create → ProductController@create
  POST /products       → ProductController@store
  GET  /products/{id}  → ProductController@show
  GET  /products/{id}/edit → ProductController@edit
  PUT  /products/{id}  → ProductController@update
  DELETE /products/{id} → ProductController@destroy

  Route::resource('products', ProductController::class) membuat 7 route CRUD sekaligus

  resources/views/layouts/app.blade.php
Layout utama yang di-extend semua halaman. Komponen:

Bagian
Detail
Navbar	Logo "Manajemen Produk" dengan ikon, link login/register (guest), dropdown user+email+logout (auth)
Guest section	@guest ... @endguest — tampil hanya jika belum login
Auth section	@else ... @endguest — dropdown dengan data-bs-toggle="dropdown", nama user, email, form logout POST
Flash success	Alert hijau dengan ikon check-circle, pesan dari session('success'), tombol close
Flash error	Alert merah dengan ikon exclamation-triangle, pesan dari session('error'), tombol close
@yield('content')	Placeholder untuk konten setiap halaman
Bootstrap JS	<script src="bootstrap.bundle.min.js"> — WAJIB agar dropdown navbar berfungsi
@stack('scripts')	Slot untuk JavaScript tambahan di halaman tertentu

resources/views/auth/login.blade.php
Extends layouts.app
Form POST ke route('login') dengan @csrf
Input email (pre-filled dengan old('email'))
Input password
Error display pattern: @error('field') is-invalid @enderror + <div class="invalid-feedback">{{ $message }}</div>
Link ke register
resources/views/auth/register.blade.php
Extends layouts.app
Form POST ke route('register') dengan @csrf
Input: nama, email, password, password_confirmation
Error display pattern sama dengan login
Link ke login
resources/views/products/index.blade.php
Extends layouts.app
Tombol "Tambah Produk" di kanan atas
Form GET untuk search (input teks) + filter (dropdown kategori) + tombol Cari/Reset
Tabel dengan kolom: Produk (nama + kategori), SKU (code tag), Harga (format Rupiah), Stok (badge warna: hijau >10, kuning >0, merah =0), Status (badge hijau/abu), Aksi (ikon mata/pensil/tempat sampah)
Tombol hapus: form POST dengan @method('DELETE') dan onsubmit="return confirm()"
@forelse ... @empty ... @endforelse untuk handle data kosong
{{ $products->links() }} untuk pagination
Pre-filled filter: {{ request('search') }} dan {{ request('category') == $cat ? 'selected' : '' }}
resources/views/products/create.blade.php
Extends layouts.app
Form POST ke route('products.store') dengan enctype="multipart/form-data" (WAJIB untuk upload)
Layout 2 kolom: kiri (nama, SKU, kategori), kanan (harga, stok, toggle aktif)
Full width: deskripsi (textarea), gambar (file input)
Error display di setiap field
SKU: style="text-transform:uppercase" untuk visual uppercase
Toggle aktif: form-check-switch dengan checked default
Tombol Kembali + Simpan
resources/views/products/show.blade.php
Extends layouts.app
Tombol kembali ke daftar
Card dengan header (judul + tombol edit)
Layout 2 kolom: kiri (gambar produk atau placeholder "Tidak ada gambar"), kanan (tabel info)
Tabel: nama, SKU, kategori (badge info), harga (bold besar warna primary), stok (badge warna), status (badge), dibuat oleh ($product->user->name), waktu dibuat, waktu diupdate
Deskripsi (jika ada) dengan nl2br(e())
Tombol hapus di bawah dengan konfirmasi
resources/views/products/edit.blade.php
Extends layouts.app
Sama seperti create, tapi dengan @method('PUT') dan action ke route('products.update', $product)
Semua input pre-filled: old('name', $product->name) — prioritas input lama (saat validasi gagal), fallback ke data DB
Preview gambar lama: @if($product->image) <img src="{{ Storage::url(...) }}" width="150"> @endif
Tombol Kembali + Update
Cara Install & Jalankan
Prasyarat
PHP 8.1+ dengan ekstensi: mbstring, openssl, pdo, tokenizer, xml, ctype, json, fileinfo
Composer
MySQL
Langkah-langkah

# 1. Clone repository
git clone https://github.com/USERNAME/tugas-laravel.git
cd tugas-laravel

# 2. Install dependency PHP
composer install

# 3. Salin file environment
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Buat database di MySQL
mysql -u root -e "CREATE DATABASE tugas_laravel;"

# 6. Konfigurasi database di file .env
#    DB_CONNECTION=mysql
#    DB_HOST=127.0.0.1
#    DB_PORT=3306
#    DB_DATABASE=tugas_laravel
#    DB_USERNAME=root
#    DB_PASSWORD=

# 7. Jalankan migration (buat tabel users + products)
php artisan migrate

# 8. Buat symbolic link storage (agar gambar bisa diakses publik)
php artisan storage:link

# 9. Jalankan development server
php artisan serve

# 10. Buka di browser
#     http://127.0.0.1:8000/register

Akun Testing
Buat akun melalui halaman register di browser. Tidak ada seeder bawaan di versi ini.

Konsep Laravel yang Diterapkan
1. Mass Assignment Protection
protected $fillable = ['name', 'sku', ...];

Tanpa $fillable, Product::create([...]) akan error. Mencegah hacker menyisipkan field sensitif via form

2. Route Model Binding
public function show(Product $product) // Otomatis find by ID
Lebih bersih daripada Product::find($id) manual. 404 otomatis jika tidak ketemu.

3. CSRF Protection
@csrf <!-- Generate hidden input _token -->
Setiap form POST/PUT/DELETE wajib punya ini. Mencegah serangan Cross-Site Request Forgery.

4. Eloquent ORM & Prepared Statements
Product::where('name', 'LIKE', "%{$search}%")->get();
// Konversi ke: SELECT * FROM products WHERE name LIKE ? (parameter binding)
Otomatis aman dari SQL Injection tanpa perlu manual escape.

5. Blade XSS Protection
{{ $product->name }} <!-- Otomatis htmlspecialchars() -->
{!! $html !!}} <!-- TANPA escape — hati-hati, hanya untuk HTML yang sudah dipercaya -->

6. Accessor (Dynamic Property)
// Di Model:
public function getPriceFormattedAttribute() { ... }

// Di View:
{{ $product->price_formatted }} // Laravel otomatis panggil accessor

Screenshot Fitur
Fitur
Deskripsi
Halaman Register	Form register dengan validasi Bahasa Indonesia
Halaman Login	Form login dengan error display
Navbar	Logo, dropdown user (nama + email + logout)
Daftar Produk	Tabel + search bar + filter kategori + pagination
Tambah Produk	Form 2 kolom + upload gambar + toggle status
Detail Produk	Gambar + tabel info lengkap + tombol edit/hapus
Edit Produk	Form pre-filled + preview gambar lama
Validasi Error	Input berwarna merah + pesan error di bawah field
Flash Message	Alert hijau/merah dengan tombol close X

