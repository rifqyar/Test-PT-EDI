<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'status' => 1,
            'id_role' => 1
        ]);

        $this->call([
            AgamaSeeder::class,
            JenisKelaminsSeeder::class,
            RoleSeeder::class
        ]);
    }
}
