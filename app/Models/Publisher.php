<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $primaryKey = 'publisher_id';

    public $timestamps = false;

    protected $fillable = [
        'publisher_name',
        'address',
        'phone',
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'publisher_id', 'publisher_id');
    }
}
