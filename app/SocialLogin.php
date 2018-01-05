<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialLogin extends Model
{
    protected $table = 'social_logins';
    
    protected $fillable = [
        'user_id',
        'provider',
        'social_id'
    ];

    /**
     * Social login belongs to a user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
