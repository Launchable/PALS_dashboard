<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table    = 'types';
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * A type has many locations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'location_types', 'type_id', 'location_id')
                    ->withTimestamps();
    }
}
