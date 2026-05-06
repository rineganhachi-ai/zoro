<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();                           // ID produk (primary key, auto-increment)
            $table->string('name');                 // Nama produk, varchar(255)
            $table->string('sku')->unique();        // SKU unik, tidak boleh sama
            $table->text('description')->nullable(); // Deskripsi, BOLEH kosong (nullable)
            $table->decimal('price', 15, 2);        // Harga: 15 digit total, 2 di belakang koma
            $table->integer('stock');                // Stok, bilangan bulat
            $table->enum('category', [               // Kategori tetap (hanya pilihan ini)
                'Elektronik', 'Fashion', 'Makanan', 'Lainnya'
            ]);
            $table->string('image')->nullable();     // Path gambar, boleh kosong
            $table->boolean('is_active')->default(true); // Status aktif, default true
            $table->foreignId('user_id')             // Foreign key ke tabel users
                  ->constrained()                   // Otomatis refer ke kolom id di users
                  ->onDelete('cascade');            // Jika user dihapus, produk ikut terhapus
            $table->timestamps();                    // Membuat created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};