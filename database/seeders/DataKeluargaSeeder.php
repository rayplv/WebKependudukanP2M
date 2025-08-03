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
                'alamat' => 'Jl. Melati No. 1 RT 01 RW 02 Desa Sukamaju Kec. Sukaraja',
                'rt' => '01',
                'rw' => '02',
                'tanggal_dikeluarkan' => '2020-01-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_kk' => '3210010101010002',
                'alamat' => 'Jl. Mawar No. 5 RT 03 RW 04 Desa Mekarsari Kec. Cibiru',
                'rt' => '03',
                'rw' => '04',
                'tanggal_dikeluarkan' => '2021-06-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_kk' => '3210010101010003',
                'alamat' => 'Jl. Anggrek No. 12 RT 02 RW 01 Desa Cibeunying Kec. Bandung Wetan',
                'rt' => '02',
                'rw' => '01',
                'tanggal_dikeluarkan' => '2019-03-22',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_kk' => '3210010101010004',
                'alamat' => 'Jl. Dahlia No. 8 RT 05 RW 03 Desa Cipadung Kec. Cibiru',
                'rt' => '05',
                'rw' => '03',
                'tanggal_dikeluarkan' => '2022-11-05',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_kk' => '3210010101010005',
                'alamat' => 'Jl. Kenanga No. 15 RT 04 RW 02 Desa Sukajadi Kec. Sukajadi',
                'rt' => '04',
                'rw' => '02',
                'tanggal_dikeluarkan' => '2023-07-18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_kk' => '3210010101010006',
                'alamat' => 'Jl. Tulip No. 20 RT 01 RW 05 Desa Ciumbuleuit Kec. Cidadap',
                'rt' => '01',
                'rw' => '05',
                'tanggal_dikeluarkan' => '2018-09-12',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_kk' => '3210010101010007',
                'alamat' => 'Jl. Sakura No. 3 RT 06 RW 01 Desa Dago Kec. Coblong',
                'rt' => '06',
                'rw' => '01',
                'tanggal_dikeluarkan' => '2024-02-28',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_kk' => '3210010101010008',
                'alamat' => 'Jl. Bougenville No. 7 RT 03 RW 06 Desa Setiabudi Kec. Setiabudi',
                'rt' => '03',
                'rw' => '06',
                'tanggal_dikeluarkan' => '2020-12-03',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}