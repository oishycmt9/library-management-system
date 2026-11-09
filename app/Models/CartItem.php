<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $primaryKey = 'cart_item_id';

    public $timestamps = false;

    protected $fillable = [
        'cart_id',
        'book_id',
        'quantity',
        'price',
    ];
    public function book()
    {
        return $this->belongsTo(
            Book::class,
            'book_id',
            'book_id'
        );
    }
}
