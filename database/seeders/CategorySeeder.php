<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan', 'description' => 'Produk makanan ringan dan kebutuhan pangan'],
            ['name' => 'Minuman', 'description' => 'Produk minuman kemasan'],
            ['name' => 'Kebutuhan Rumah Tangga', 'description' => 'Produk kebutuhan rumah'],
            ['name' => 'Kebersihan', 'description' => 'Produk kebersihan'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
