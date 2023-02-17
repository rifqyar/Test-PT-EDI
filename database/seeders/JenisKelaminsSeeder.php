<?php

namespace Database\Seeders;

use App\Models\JenisKelamins;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisKelaminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jk = [[
            'jenis_kelamin' => 'Laki-laki',
            'jenis_kelamin' => 'Perempuan'
        ]];

        JenisKelamins::insert($jk);
    }
}
