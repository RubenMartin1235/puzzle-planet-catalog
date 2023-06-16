<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'description',
        'price',
        'stock',
    ];

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function ratings() {
        return $this->morphMany(Rating::class, 'rateable');
    }
    public function purchases() {
        return $this->hasManyThrough(Purchase::class, PurchaseItem::class);
    }

    public function collected_by_users() {
        return $this->belongsToMany(User::class, 'user_collects_card')->withPivot('amount');
    }
}
