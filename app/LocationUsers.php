<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationUsers extends Model
{

    /**
     * @var string
     */
    protected $table = 'location_users';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'location_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
