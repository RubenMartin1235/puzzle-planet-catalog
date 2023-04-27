<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
    ];

    public function planets(){
        return $this->belongsToMany(Planet::class, 'planet_block')->withPivot('rate')->withTimestamps();
    }
}
