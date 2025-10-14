<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'category',
        'tags',
        'stock_quantity',
        'image',
        'user_id' 
    ];
    public function seller()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
