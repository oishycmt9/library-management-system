<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $primaryKey = 'book_id';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'isbn',
        'category_id',
        'author_id',
        'publisher_id',
        'description',
        'price',
        'stock_quantity',
        'image',
        'status',
        'created_at'
    ];

    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_id',
            'category_id'
        );
    }

    public function author()
    {
        return $this->belongsTo(
            Author::class,
            'author_id',
            'author_id'
        );
    }

    public function publisher()
    {
        return $this->belongsTo(
            Publisher::class,
            'publisher_id',
            'publisher_id'
        );
    }
}
