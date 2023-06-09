<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;
    protected $table = 'purchase_card';
    protected $fillable = [
        'amount',
    ];

    public function purchase() {
        return $this->belongsTo(Purchase::class);
    }
    public function card() {
        return $this->belongsTo(Card::class);
    }
}
