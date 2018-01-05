<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    protected $table = 'drinks';

    protected $fillable = [
        'location_id',
        'type_id',
        'title',
        'description',
        'price',
        'start_time',
        'end_time',
        'timed_price',
        'promo_code',
        'stocks',
        'is_limited',
        'is_available'
    ];

    /**
     * A drink belongs to a type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(DrinkType::class);
    }

    /**
     * A drink belongs to a location
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function userDrinks()
    {
        return $this->hasMany(UserDrink::class);
    }
}
