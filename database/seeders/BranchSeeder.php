<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            ['name' => 'Jayusman Mart Cianjur', 'city' => 'Cianjur', 'address' => 'Jl. Raya Cianjur'],
            ['name' => 'Jayusman Mart Bandung', 'city' => 'Bandung', 'address' => 'Jl. Asia Afrika'],
            ['name' => 'Jayusman Mart Bogor', 'city' => 'Bogor', 'address' => 'Jl. Pajajaran'],
            ['name' => 'Jayusman Mart Sukabumi', 'city' => 'Sukabumi', 'address' => 'Jl. Sudirman'],
            ['name' => 'Jayusman Mart Garut', 'city' => 'Garut', 'address' => 'Jl. Ahmad Yani'],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
