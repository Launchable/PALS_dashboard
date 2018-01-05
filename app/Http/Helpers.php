<?php namespace App\Http;

class Helpers
{
    /**
     * Blade helper to get avatar of user
     *
     * @param $avatar
     * @param $avatar_social
     * @return string
     */
    public static function getAvatar($avatar, $avatar_social)
    {
        if ($avatar != 'default.jpg') {
            return '/uploads/avatars/' . $avatar;
        }

        if (!empty($avatar_social)) {
            return $avatar_social;
        }

        return 'https://robohash.org/' . $avatar;
    }

    /**
     * Function to check if request is ajax
     * 
     * @param $request
     * @return bool
     */
    public static function checkAjaxRequest($request)
    {
        if (!$request->ajax()) {
            return false;
        }

        return true;
    }
}