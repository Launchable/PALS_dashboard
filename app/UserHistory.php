<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserHistory extends Model
{
    protected $table    = 'user_histories';
    protected $fillable = [
        'user_id',
        'drink_id',
        'cover_id',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function drink()
    {
        return $this->belongsTo(Drink::class);
    }
    
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }

    public function scopeToday($query)
    {
        return $query->whereRaw('DATE(created_at) = CURDATE()');
    }

    public function scopeYesterday($query)
    {
        return $query->whereRaw('DATE(created_at) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))');
    }
}
