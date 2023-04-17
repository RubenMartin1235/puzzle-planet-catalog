<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'user_id',
        'bio',
        'description',
    ];

    function user(){
        return $this->belongsTo(User::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function ratings() {
        return $this->hasMany(Rating::class);
    }

    public function blocks(){
        return $this->belongsToMany(Block::class, 'planet_block');
    }
}
