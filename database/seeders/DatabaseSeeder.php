<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();
        User::create([
            'nama'  => $faker->name,
            'nis'   => '12345678',
            'email' => $faker->email,
            'role'  => 'admin',
            'password'  => bcrypt('smkn1rengasdengklok'),
        ]);
    }
}
