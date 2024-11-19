<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => '1',
                'level_id' => '1',
                'username' => 'admin',
                'nama' => 'Kadek Suarjana',
                'password' => Hash::make('12345'),
            ],
            [
                'user_id' => '2',
                'level_id' => '2',
                'username' => 'mahasiswa',
                'nama' => 'Andreas Gale Dwi Jaya',
                'password' => Hash::make('12345'),
            ],
            [
                'user_id' => '3',
                'level_id' => '3',
                'username' => 'dosen',
                'nama' => 'Kadek Suarjana',
                'password' => Hash::make('12345'),
            ],
            [
                'user_id' => '4',
                'level_id' => '4',
                'username' => 'tendik',
                'nama' => 'Supratman',
                'password' => Hash::make('12345'),
            ],
        ];
        DB::table('m_user')->insert($data);
    }
}
