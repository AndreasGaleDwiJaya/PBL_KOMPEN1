<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'mahasiswa_id' => 1,
                'level_id' => 2,
                'username' => 'mahasiswa',
                'nama' => 'Andreas Gale Dwi Jaya',
                'password' => Hash::make('12345'),
                'nim' => '2241760033',
                'avatar' => '',
            ],
        ];
        DB::table('m_usermahasiswa') -> insert($data);
    }
}
