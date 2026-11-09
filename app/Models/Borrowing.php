<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $primaryKey = 'borrowing_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }

    public function book()
    {
        return $this->belongsTo(
            Book::class,
            'book_id',
            'book_id'
        );
    }
}
