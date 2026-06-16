<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'branch_id' => 1,
                'category_id' => 1,
                'code' => 'PRD001',
                'name' => 'Indomie Goreng',
                'stock' => 100,
                'min_stock' => 10,
                'purchase_price' => 2500,
                'selling_price' => 3500,
                'unit' => 'pcs',
            ],
            [
                'branch_id' => 1,
                'category_id' => 2,
                'code' => 'PRD002',
                'name' => 'Aqua Botol 600ml',
                'stock' => 80,
                'min_stock' => 15,
                'purchase_price' => 3000,
                'selling_price' => 4500,
                'unit' => 'pcs',
            ],
            [
                'branch_id' => 1,
                'category_id' => 3,
                'code' => 'PRD003',
                'name' => 'Minyak Goreng 1 Liter',
                'stock' => 50,
                'min_stock' => 10,
                'purchase_price' => 14000,
                'selling_price' => 17000,
                'unit' => 'pcs',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
