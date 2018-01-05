<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\DocBlock\Tags\Covers;

class Location extends Model
{
    protected $table    = 'locations';
    protected $fillable = [
        'user_id',
        'code',
        'name',
        'address',
        'description',
        'phone',
        'latitude',
        'longitude',
        'image'
    ];

    /**
     * A location belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Location hours association
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hours()
    {
        return $this->hasOne(LocationOperation::class);
    }

    /**
     * A location has many types
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function types()
    {
        return $this->belongsToMany(Type::class, 'location_types', 'location_id', 'type_id')
                    ->withTimestamps();
    }

    /**
     * Location belongs to many users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'location_users', 'location_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * A Location has many drink
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function drinks()
    {
        return $this->hasMany(Drink::class);
    }
    
    /**
     * A location has many operation hours
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operations()
    {
        return $this->hasMany(LocationOperation::class);
    }

    /**
     * A location has many covers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function covers()
    {
        return $this->hasMany(Cover::class);
    }

    /**
     * A location has many events
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
