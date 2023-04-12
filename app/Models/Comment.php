<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'planet_id',
        'message',
    ];

    function planet(){
        return $this->belongsTo(Planet::class);
    }
    function user(){
        return $this->belongsTo(User::class);
    }
}
