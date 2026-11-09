<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $primaryKey = 'author_id';

    public $timestamps = false;

    protected $fillable = [
        'author_name',
        'biography',
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'author_id', 'author_id');
    }
}
