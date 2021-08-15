<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
    ];

    /**
     * Assign the relationship between cart and users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Assign the relationship between cart and watches
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function watch(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Watch::class , 'cart_watch')->withPivot(['quantity']);
    }
}
