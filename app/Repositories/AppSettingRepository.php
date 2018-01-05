<?php namespace App\Repositories;

use App\AppSetting;

class AppSettingRepository
{
    private $user;

    public function __construct(AppSetting $setting)
    {
        $this->setting = $setting;
    }

    public function update($request)
    {
        $setting = $this->setting->first();

        if(!$setting) {
            $setting = New AppSetting();
        }

        $setting->fill([
            'is_notification' => $request->has('is_notification'),
            'help_faq'    => $request->get('help_faq'),
            'terms'     => $request->get('terms'),
            'privacy' => $request->get('privacy')
        ])->save();
    }
}