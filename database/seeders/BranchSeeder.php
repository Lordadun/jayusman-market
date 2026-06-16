<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            ['name' => 'Jayusman Mart Cianjur', 'city' => 'Cianjur', 'address' => 'Jl. Raya Cianjur', 'phone' => '081111111111'],
            ['name' => 'Jayusman Mart Bandung', 'city' => 'Bandung', 'address' => 'Jl. Asia Afrika', 'phone' => '082222222222'],
            ['name' => 'Jayusman Mart Bogor', 'city' => 'Bogor', 'address' => 'Jl. Pajajaran', 'phone' => '083333333333'],
            ['name' => 'Jayusman Mart Sukabumi', 'city' => 'Sukabumi', 'address' => 'Jl. Sudirman', 'phone' => '084444444444'],
            ['name' => 'Jayusman Mart Garut', 'city' => 'Garut', 'address' => 'Jl. Ahmad Yani', 'phone' => '085555555555'],
        ];

        foreach ($branches as $branch) {
            Branch::updateOrCreate(['name' => $branch['name']], $branch);
        }
    }
}
