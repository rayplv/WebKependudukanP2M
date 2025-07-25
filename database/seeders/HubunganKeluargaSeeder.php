<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HubunganKeluargaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hubungan_keluarga')->insert([
            ['id' => 1, 'nama' => 'KEPALA KELUARGA'],
            ['id' => 2, 'nama' => 'SUAMI'],
            ['id' => 3, 'nama' => 'ISTRI'],
            ['id' => 4, 'nama' => 'ANAK'],
            ['id' => 5, 'nama' => 'MENANTU'],
            ['id' => 6, 'nama' => 'CUCU'],
            ['id' => 7, 'nama' => 'ORANG TUA'],
            ['id' => 8, 'nama' => 'MERTUA'],
            ['id' => 9, 'nama' => 'FAMILI LAIN'],
            ['id' => 10, 'nama' => 'PEMBANTU'],
            ['id' => 11, 'nama' => 'LAINNYA'],
        ]);
    }
}