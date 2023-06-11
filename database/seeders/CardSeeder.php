<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Card;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $card = Card::factory()->create([
            'name'=>'Last Stairway',
            'image'=>'cards/1.png',
            'description'=>"Is Lastar the last star there will ever be, or the last star one ever sees?",
            'price'=>2.99,
            'stock'=>12,
        ]);
        Storage::copy('resources/assets/cards/1.png', 'storage/cards/1.png');
        $card = Card::factory()->create([
            'name'=>'Ozzeans',
            'image'=>'cards/2.png',
            'description'=>"Oceans of caustic ooze are ever-present on Caustix.",
            'price'=>1.99,
            'stock'=>9,
        ]);
        Storage::copy('resources/assets/cards/2.png', 'storage/cards/2.png');
    }
}
