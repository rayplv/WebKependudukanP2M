<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PendidikanTerakhirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pendidikan_terakhir')->insert([
            ['id' => 1, 'nama' => 'TIDAK / BELUM SEKOLAH'],
            ['id' => 2, 'nama' => 'BELUM TAMAT SD/SEDERAJAT'],
            ['id' => 3, 'nama' => 'TAMAT SD/SEDERAJAT'],
            ['id' => 4, 'nama' => 'SLTP/SEDERAJAT'],
            ['id' => 5, 'nama' => 'SLTA/SEDERAJAT'],
            ['id' => 6, 'nama' => 'DIPLOMA I/II'],
            ['id' => 7, 'nama' => 'AKADEMI/DIPLOMA III/S. MUDA'],
            ['id' => 8, 'nama' => 'DIPLOMA IV/STRATA I'],
            ['id' => 9, 'nama' => 'STRATA II'],
            ['id' => 10, 'nama' => 'STRATA III'],
        ]);
    }

}
