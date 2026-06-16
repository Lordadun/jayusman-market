<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $baseProducts = [
            ['category_id' => 1, 'code' => 'PRD001', 'name' => 'Indomie Goreng', 'stock' => 100, 'min_stock' => 10, 'purchase_price' => 2500, 'selling_price' => 3500, 'unit' => 'pcs'],
            ['category_id' => 2, 'code' => 'PRD002', 'name' => 'Aqua Botol 600ml', 'stock' => 80, 'min_stock' => 15, 'purchase_price' => 3000, 'selling_price' => 4500, 'unit' => 'pcs'],
            ['category_id' => 3, 'code' => 'PRD003', 'name' => 'Minyak Goreng 1 Liter', 'stock' => 50, 'min_stock' => 10, 'purchase_price' => 14000, 'selling_price' => 17000, 'unit' => 'pcs'],
            ['category_id' => 4, 'code' => 'PRD004', 'name' => 'Sabun Mandi', 'stock' => 60, 'min_stock' => 12, 'purchase_price' => 3500, 'selling_price' => 5000, 'unit' => 'pcs'],
        ];

        foreach ([1, 2, 3, 4, 5] as $branchId) {
            foreach ($baseProducts as $product) {
                $code = $product['code'] . '-C' . $branchId;
                Product::updateOrCreate(
                    ['code' => $code],
                    array_merge($product, ['branch_id' => $branchId, 'code' => $code])
                );
            }
        }
    }
}
