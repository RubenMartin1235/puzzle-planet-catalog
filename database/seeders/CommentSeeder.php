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

        $comment = Comment::factory()->make([
            'user_id' => $user_fl->id,
            'message' => fake()->text(32)
        ]);
        $comment->commentable()->associate($planet_lastar)->save();

        $comment = Comment::factory()->make([
            'user_id' => $user_ksh->id,
            'message' => "berigoo!"
        ]);
        $comment->commentable()->associate($planet_lastar)->save();

        $comment = Comment::factory()->make([
            'user_id' => $user_ksh->id,
            'message' => "berigoo!"
        ]);
        $comment->commentable()->associate($planet_caustix)->save();

    }
}
