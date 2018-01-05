<?php

namespace App;

use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class User extends Authenticatable
{
    use Notifiable;
    use Friendable;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    public $appends = [
        'avatar_url'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'api_token',
        'role',
        'avatar',
        'avatar_social',
        'device_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAvatarUrlAttribute()
    {
        return $this->getAvatar();
    }

    /**
     * A user a one user profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Social login association
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function social()
    {
        return $this->hasOne(SocialLogin::class);
    }

    /**
     * User has a location
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne(Location::class);
    }

    /**
     * User New Location
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userLocation()
    {
        return $this->hasOne(UserLocation::class);
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'location_users', 'user_id', 'location_id')
                    ->withTimestamps();
    }

    /**
     * Get Users orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function orders()
    {
        return $this->hasOne(Order::class);
    }

    /**
     * Check if user has a role
     *
     * @param $name
     * @return bool
     */
    public function hasRole($name)
    {
        return ($this->role == $name) ? true : false;
    }

    /**
     * Get user avatar
     *
     * @return mixed
     */
    public function getAvatar()
    {
        if ($this->avatar != 'default.jpg') {
            return strpos($this->avatar, 'http') === false ? ('/uploads/avatars/' . $this->avatar) : $this->avatar;
        }

        if (!empty($this->avatar_social)) {
            return $this->avatar_social;
        }

        return 'https://robohash.org/' . $this->username . '.jpg';
    }

    /**
     * Accessor to combine first and last name of a user
     *
     * @param $value
     * @return string
     */
    public function getFullNameAttribute($value)
    {
        return $this->profile->first_name . ' ' . $this->profile->last_name;
    }

    public function send_notification($token = null, $message = null)
    {
        $url = "https://fcm.googleapis.com/fcm/send";
        $fields = array(
            'registration_ids' => $token,
            'data' => $message
        );

        $headers = array(
            'Authorization:key = AIzaSyB5e1_zxvtW0dQNEf2D5HVViJv3LzsraLo',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec ($ch);
        curl_close ($ch);
        return $result;
    }

}
