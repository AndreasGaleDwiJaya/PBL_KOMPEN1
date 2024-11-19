<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidangKompetensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'bidkom_id' => 1,
                'nama_bidkom' => 'Programming',
            ],
            [
                'bidkom_id' => 2,
                'nama_bidkom' => 'Analisis',
            ],
            [
                'bidkom_id' => 3,
                'nama_bidkom' => 'UI/UX Design',
            ],
        ];
        DB::table('m_bidangkompetensi') -> insert($data);
    }
}
