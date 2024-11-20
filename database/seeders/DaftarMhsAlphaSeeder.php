<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaftarMhsAlphaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'daftarmhsalpha_id' => 1,
                'mahasiswa_id' => 1,
                'jumlah_jamalpha' => 23,
                'periode' => 'Ganjil-2024',
                'prodi' => 'Sistem Informasi Bisnis',
            ],
        ];
        DB::table('m_daftarmhsalpha') -> insert($data);
    }
}
