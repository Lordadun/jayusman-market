<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Pak Jayusman',
            'email' => 'owner@jayusman.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'branch_id' => null,
        ]);

        User::create([
            'name' => 'Manajer Cianjur',
            'email' => 'manager@jayusman.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'branch_id' => 1,
        ]);

        User::create([
            'name' => 'Kasir Cianjur',
            'email' => 'kasir@jayusman.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'branch_id' => 1,
        ]);

        User::create([
            'name' => 'Gudang Cianjur',
            'email' => 'gudang@jayusman.com',
            'password' => Hash::make('password'),
            'role' => 'warehouse',
            'branch_id' => 1,
        ]);
    }
}
