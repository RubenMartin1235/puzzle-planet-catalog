<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'planet_id',
        'score',
    ];

    function planet(){
        return $this->belongsTo(Planet::class);
    }
    function user(){
        return $this->belongsTo(User::class);
    }
}
