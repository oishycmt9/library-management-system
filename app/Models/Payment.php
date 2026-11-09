<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'payment_id';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'payment_method',
        'transaction_id',
        'amount',
        'payment_status',
        'payment_date',
    ];

    public function order()
    {
        return $this->belongsTo(
            Order::class,
            'order_id',
            'order_id'
        );
    }
}
