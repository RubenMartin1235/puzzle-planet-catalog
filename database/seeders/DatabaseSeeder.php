<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            BlockSeeder::class,
            PlanetSeeder::class,
            CommentSeeder::class,
            RatingSeeder::class,
            CardSeeder::class,
        ]);
    }
}
