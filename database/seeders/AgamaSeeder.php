<?php

namespace Database\Seeders;

use App\Models\Agama;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agama = [[
                'agama' => 'Islam'
            ],[
                'agama' => 'Katolik'
            ],[
                'agama' => 'Kristen'
            ],[
                'agama' => 'Hindu'
            ],[
                'agama' => 'Buddha'
            ],[
                'agama' => 'Konghucu'
            ]
        ];

        Agama::insert($agama);
    }
}
