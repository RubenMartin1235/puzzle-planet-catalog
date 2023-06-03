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

        $rating = Rating::factory()->make([
            'user_id' => $user_fl->id,
            'score' => 5
        ]);
        $rating->rateable()->associate($planet_lastar)->save();
        $rating = Rating::factory()->make([
            'user_id' => $user_ksh->id,
            'score' => 5
        ]);
        $rating->rateable()->associate($planet_lastar)->save();

        $rating = Rating::factory()->make([
            'user_id' => $user_ksh->id,
            'score' => 5
        ]);
        $rating->rateable()->associate($planet_caustix)->save();
        $rating = Rating::factory()->make([
            'user_id' => $user_lsm->id,
            'score' => 3
        ]);
        $rating->rateable()->associate($planet_caustix)->save();
        $rating = Rating::factory()->make([
            'user_id' => $user_loader->id,
            'score' => 4
        ]);
        $rating->rateable()->associate($planet_caustix)->save();
    }
}
