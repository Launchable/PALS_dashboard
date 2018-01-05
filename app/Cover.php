<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cover extends Model
{
    protected $table = 'covers';
    protected $fillable = [
        'location_id',
        'code',
        'title',
        'description',
        'price'
    ];

    /**
     * A cover belongs to a location
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    
    public function userCovers()
    {
        return $this->hasMany(UserCover::class);
    }
}
