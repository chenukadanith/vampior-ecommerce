<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'user_id',
        'total',
        'status',
        'shipping_name',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
    ];

    public function items()
{
    return $this->hasMany(OrderItem::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}
}
