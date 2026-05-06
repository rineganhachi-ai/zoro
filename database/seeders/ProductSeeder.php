<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $products = [
            ['name' => 'Laptop ASUS ROG', 'sku' => 'LAPTOP-001',
             'description' => 'Laptop gaming Intel i7, RAM 16GB',
             'price' => 25000000, 'stock' => 15, 'category' => 'Elektronik'],
            ['name' => 'iPhone 15 Pro', 'sku' => 'PHONE-001',
             'description' => 'Smartphone Apple chip A17 Pro',
             'price' => 22000000, 'stock' => 25, 'category' => 'Elektronik'],
            ['name' => 'Kemeja Batik Premium', 'sku' => 'FASHION-001',
             'description' => 'Batik tulis asli Pekalongan',
             'price' => 350000, 'stock' => 50, 'category' => 'Fashion'],
            ['name' => 'Kopi Arabika Gayo', 'sku' => 'FOOD-001',
             'description' => 'Kopi premium dari Aceh',
             'price' => 85000, 'stock' => 100, 'category' => 'Makanan'],
            ['name' => 'Mouse Wireless', 'sku' => 'ACC-001',
             'description' => 'Mouse ergonomis 4000 DPI',
             'price' => 450000, 'stock' => 0, 'category' => 'Elektronik',
             'is_active' => false],
        ];

        foreach ($products as $data) {
            $data['user_id'] = $user->id;
            $data['is_active'] = $data['is_active'] ?? true;
            Product::create($data);
        }
    }
}