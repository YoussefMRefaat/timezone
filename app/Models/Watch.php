<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable= [
        'name',
        'description',
        'img',
        'price',
        'quantity',
    ];

    /**
     * Assign the relationship between watches and orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Order::class , 'order_watch')->withPivot(['price_in_order']);
    }

    /**
     * Assign the relationship between watches and cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cart(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Cart::class , 'cart_watch')->withPivot(['quantity']);
    }

}
