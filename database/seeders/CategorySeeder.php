<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan', 'description' => 'Produk makanan ringan dan kebutuhan pangan'],
            ['name' => 'Minuman', 'description' => 'Produk minuman kemasan'],
            ['name' => 'Kebutuhan Rumah Tangga', 'description' => 'Produk kebutuhan rumah tangga'],
            ['name' => 'Kebersihan', 'description' => 'Produk kebersihan dan sanitasi'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}
