<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insertOrIgnore([
            [
                'name' => 'Superadmin',
                'email' => 'superadmin@indragiri.id',
                'password' => Hash::make('indragiri'),
            ],
            [
                'name' => 'Admin 1',
                'email' => 'admin1@indragiri.id',
                'password' => Hash::make('indragiri'),
            ]
        ]);
    }
}
