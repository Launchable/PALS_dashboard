<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrinkType extends Model
{
    protected $table   = 'drink_types';
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Type has many drinks
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function drinks()
    {
        return $this->hasMany(Drink::class);
    }
}
