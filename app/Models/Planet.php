<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'bio',
        'description',
        'image'
    ];

    function user(){
        return $this->belongsTo(User::class);
    }
    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function ratings() {
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function blocks(){
        return $this->belongsToMany(Block::class, 'planet_block')->withPivot('rate')->withTimestamps();
    }

    public function hasBlock($block) {
        if ($this->blocks()->where('name', $block)->first()) {
            return true;
        }
        return false;
    }
    public function hasAnyBlock($blocks) {
        if (is_array($blocks)) {
            foreach ($blocks as $block) {
                if ($this->hasBlock($block)) {
                    return true;
                }
            }
        } else {
            if ($this->hasBlock($blocks)) {
                return true;
            }
        }
        return false;
    }
}
