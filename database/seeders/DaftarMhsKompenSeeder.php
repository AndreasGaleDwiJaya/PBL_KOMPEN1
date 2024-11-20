<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaftarMhsKompenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'daftarmhskompen_id' => 1,
                'daftarmhsalpha_id' => 1,
                'jumlah_jam_telah_dikerjakan' => 15,
            ],
        ];
        DB::table('m_daftarmhskompen') -> insert($data);
    }
}
