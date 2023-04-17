<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Block;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $block = Block::factory()->create([
            'name'=>'Air',
            'color'=>'#EFF3F3',
        ]);
        $block = Block::factory()->create([
            'name'=>'Fire',
            'color'=>'#FF0000',
        ]);
        $block = Block::factory()->create([
            'name'=>'H2O',
            'color'=>'#00C9FF',
        ]);
        $block = Block::factory()->create([
            'name'=>'Soil',
            'color'=>'#FF7000',
        ]);
        $block = Block::factory()->create([
            'name'=>'Iron',
            'color'=>'#8300FF',
        ]);
        $block = Block::factory()->create([
            'name'=>'Zap',
            'color'=>'#FFE000',
        ]);
        $block = Block::factory()->create([
            'name'=>'Herb',
            'color'=>'#028B00',
        ]);
        $block = Block::factory()->create([
            'name'=>'Zoo',
            'color'=>'#FF43FF',
        ]);
        $block = Block::factory()->create([
            'name'=>'Glow',
            'color'=>'#B6FFB6',
        ]);
        $block = Block::factory()->create([
            'name'=>'Dark',
            'color'=>'#230079',
        ]);
        $block = Block::factory()->create([
            'name'=>'Ice',
            'color'=>'#C4FEFF',
        ]);
        $block = Block::factory()->create([
            'name'=>'Poison',
            'color'=>'#530079',
        ]);
    }
}
