<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['branch_id' => null, 'name' => 'Pak Jayusman', 'email' => 'owner@jayusman.com', 'role' => 'owner', 'phone' => '080000000000'],
            ['branch_id' => 1, 'name' => 'Manajer Cianjur', 'email' => 'manager@jayusman.com', 'role' => 'manager', 'phone' => '081111111112'],
            ['branch_id' => 1, 'name' => 'Supervisor Cianjur', 'email' => 'supervisor@jayusman.com', 'role' => 'supervisor', 'phone' => '081111111113'],
            ['branch_id' => 1, 'name' => 'Kasir Cianjur', 'email' => 'kasir@jayusman.com', 'role' => 'cashier', 'phone' => '081111111114'],
            ['branch_id' => 1, 'name' => 'Gudang Cianjur', 'email' => 'gudang@jayusman.com', 'role' => 'warehouse', 'phone' => '081111111115'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                array_merge($user, [
                    'password' => Hash::make('password'),
                    'is_active' => true,
                ])
            );
        }
    }
}
