<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Planet;
use App\Models\Block;
use App\Models\User;

class PlanetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_loader = User::where('name', 'loader')->first();
        $user_fl = User::where('name', 'Flor1450')->first();

        $block_air = Block::where('name', 'Air')->first();
        $block_fire = Block::where('name', 'Fire')->first();
        $block_h2o = Block::where('name', 'H2O')->first();
        $block_soil = Block::where('name', 'Soil')->first();
        $block_iron = Block::where('name', 'Iron')->first();
        $block_zap = Block::where('name', 'Zap')->first();
        $block_herb = Block::where('name', 'Herb')->first();
        $block_zoo = Block::where('name', 'Zoo')->first();
        $block_glow = Block::where('name', 'Glow')->first();
        $block_dark = Block::where('name', 'Dark')->first();
        $block_ice = Block::where('name', 'Ice')->first();
        $block_psn = Block::where('name', 'Poison')->first();

        $planet = Planet::factory()->create([
            'name' => 'Lastar',
            'user_id' => $user_loader->id,
            'bio' => "The planet of Lastar is full of light, and the light destroys all shadows.",
            'description' => fake()->text(32)
        ]);
        $planet->blocks()->attach($block_air, ['rate' => 100]);
        $planet->blocks()->attach($block_fire, ['rate' => 100]);
        $planet->blocks()->attach($block_glow, ['rate' => 100]);
        $planet->blocks()->attach($block_iron, ['rate' => 100]);
        $planet->blocks()->attach($block_herb, ['rate' => 40]);

        $planet = Planet::factory()->create([
            'name' => 'Caustix',
            'user_id' => $user_fl->id,
            'bio' => "A green, glowing ooze covers this molten planet's surface.",
            'description' => fake()->text(32)
        ]);
        $planet->blocks()->attach($block_fire, ['rate' => 100]);
        $planet->blocks()->attach($block_psn, ['rate' => 100]);
        $planet->blocks()->attach($block_iron, ['rate' => 70]);
        $planet->blocks()->attach($block_dark, ['rate' => 40]);
        $planet->blocks()->attach($block_zap, ['rate' => 10]);

        $planet = Planet::factory()->create([
            'name' => 'Daisangen',
            'user_id' => $user_fl->id,
            'bio' => "An idyllic planet covered in red mountain ranges.",
            'description' => "An mountainous idyllic planet covered in red mountain ranges. Legends tell stories of this planet being the culprit of apocalyptic events eons ago.",
        ]);
        $planet->blocks()->attach($block_fire, ['rate' => 100]);
        $planet->blocks()->attach($block_herb, ['rate' => 100]);
        $planet->blocks()->attach($block_soil, ['rate' => 100]);
        $planet->blocks()->attach($block_ice, ['rate' => 70]);
        $planet->blocks()->attach($block_glow, ['rate' => 70]);
        $planet->blocks()->attach($block_iron, ['rate' => 30]);
        $planet->blocks()->attach($block_dark, ['rate' => 10]);
    }
}
