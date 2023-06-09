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
}
