<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationOperation extends Model
{
    protected $table = 'location_operations';
    protected $fillable = [
        'location_id',
        'week_day',
        'opens_at',
        'closes_at',
    ];

    /**
     * Hours belongs to a location
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
