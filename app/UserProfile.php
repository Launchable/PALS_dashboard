<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table    = 'user_profiles';
    protected $guarded  = ['id'];
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'age',
        'gender'
    ];

    /**
     * A profile belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
