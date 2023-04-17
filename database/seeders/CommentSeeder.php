<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Planet;
use App\Models\User;


class CommentSeeder extends Seeder
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

        $comment = Comment::factory()->create([
            'user_id' => $user_fl->id,
            'planet_id' => $planet_lastar->id,
            'message' => fake()->text(32)
        ]);
        $comment = Comment::factory()->create([
            'user_id' => $user_ksh->id,
            'planet_id' => $planet_lastar->id,
            'message' => "berigoo!"
        ]);

        $comment = Comment::factory()->create([
            'user_id' => $user_ksh->id,
            'planet_id' => $planet_caustix->id,
            'message' => "berigoo!"
        ]);
    }
}
