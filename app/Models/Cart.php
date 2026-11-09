<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = 'cart_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'created_at',
    ];
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }

    public function cartItems()
    {
        return $this->hasMany(
            CartItem::class,
            'cart_id',
            'cart_id'
        );
    }
}
