<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rating;
use App\Models\Planet;
use App\Models\User;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_loader = User::where('name', 'loader')->first();
        $user_fl = User::where('name', 'Flor1450')->first();
        $user_lsm = User::where('name', 'Lastarman123')->first();
        $user_ksh = User::where('name', 'Koishie Berigoo')->first();

        $planet_lastar = Planet::where('name','Lastar')->first();
        $planet_caustix = Planet::where('name','Caustix')->first();

        $rating = Rating::factory()->create([
            'user_id' => $user_fl->id,
            'planet_id' => $planet_lastar->id,
            'score' => 5
        ]);
        $rating = Rating::factory()->create([
            'user_id' => $user_ksh->id,
            'planet_id' => $planet_lastar->id,
            'score' => 5
        ]);

        $rating = Rating::factory()->create([
            'user_id' => $user_ksh->id,
            'planet_id' => $planet_caustix->id,
            'score' => 5
        ]);
        $rating = Rating::factory()->create([
            'user_id' => $user_lsm->id,
            'planet_id' => $planet_caustix->id,
            'score' => 3
        ]);
        $rating = Rating::factory()->create([
            'user_id' => $user_loader->id,
            'planet_id' => $planet_caustix->id,
            'score' => 4
        ]);
    }
}
