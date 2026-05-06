<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'sku', 'description', 'price', 'stock',
        'category', 'image', 'is_active', 'user_id',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    // Product milik SATU User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Format harga ke Rupiah
    public function getPriceFormattedAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Status dalam teks
    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Aktif' : 'Tidak Aktif';
    }
}