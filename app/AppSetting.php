<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'user_id',
        'is_notification',
        'help_faq',
        'terms',
        'privacy'
    ];
}
