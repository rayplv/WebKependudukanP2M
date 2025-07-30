<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('agama')->insert([
            ['id' => 1, 'nama' => 'ISLAM'],
            ['id' => 2, 'nama' => 'KRISTEN'],
            ['id' => 3, 'nama' => 'KATOLIK'],
            ['id' => 4, 'nama' => 'HINDU'],
            ['id' => 5, 'nama' => 'BUDDHA'],
            ['id' => 6, 'nama' => 'KHONGHUCU'],
        ]);
    }

}
