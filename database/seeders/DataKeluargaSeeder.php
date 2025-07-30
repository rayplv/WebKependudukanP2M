<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataKeluargaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('data_keluarga')->insert([
            [
                'no_kk' => '3210010101010001',
                'alamat' => 'Jl. Melati No. 1',
                'rt' => '01',
                'rw' => '02',
                'desa' => 'Desa Sukamaju',
                'kecamatan' => 'Kec. Sukaraja',
                'tanggal_dikeluarkan' => '2020-01-15',
            ],
            [
                'no_kk' => '3210010101010002',
                'alamat' => 'Jl. Mawar No. 5',
                'rt' => '03',
                'rw' => '04',
                'desa' => 'Desa Mekarsari',
                'kecamatan' => 'Kec. Cibiru',
                'tanggal_dikeluarkan' => '2021-06-10',
            ],
        ]);
    }
}