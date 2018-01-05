<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserDrink extends Model
{
    protected $table = 'user_drinks';
    protected $fillable = [
        'user_id',
        'sender_id',
        'drink_id',
        'price',
        'message'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function drink()
    {
        return $this->belongsTo(Drink::class);
    }

    /**
     * Scope for non-redeemed items
     *
     * @param $query
     * @return mixed
     */
    public function scopeNotRedeemed($query)
    {
        return $query->where('is_redeemed', 0);
    }

    /**
     * Scope to get current user items
     *
     * @param $query
     * @return mixed
     */
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }
}
