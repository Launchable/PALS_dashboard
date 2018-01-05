<?php

namespace App\Http\Controllers\Auth;

use App\UserProfile;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\SocialLogin;
use App\User;

class SocialController extends Controller
{
    public function getSocialRedirect($provider)
    {
        $providerKey = Config::get('services.' . $provider);

        if (empty($providerKey)) {

            flash('No such provider', 'danger');

            return redirect('/login');

        }

        return Socialite::driver($provider)
                        ->redirect();

    }

    public function getSocialHandle($provider)
    {
        if (Input::get('denied') != '') {

            flash('You did not share your profile data with our social app.', 'danger');

            return redirect('/login');

        }

        $user = Socialite::driver($provider)
                         ->user();

        $socialUser = null;
        $userCheck  = User::where('email', '=', $user->email)
                          ->first();
        $email      = $user->email;

        if (!$user->email) {
            $email = 'missing' . str_random(10);
        }

        if (!empty($userCheck)) {
            $socialUser = $userCheck;
        } else {

            $sameSocialId = SocialLogin::where('social_id', '=', $user->id)
                                       ->where('provider', '=', $provider)
                                       ->first();

            // There is no combination of this social id and provider, so create new one

            if (empty($sameSocialId)) {

                // Create user record
                $newSocialUser                = new User;
                $newSocialUser->username      = $email;
                $newSocialUser->email         = $email;
                $newSocialUser->password      = bcrypt(str_random(16));
                $newSocialUser->role          = 'registered';
                $newSocialUser->avatar_social = $user->avatar;

                $newSocialUser->save();

                // Create user profile record
                $name = explode(' ', $user->name);

                $newSocialUser->profile()
                              ->save(new UserProfile([
                                  'gender'     => $user->user['gender'],
                                  'first_name' => (count($name) >= 1) ? $name[0] : null,
                                  'last_name'  => (count($name) >= 2) ? $name[1] : null,
                              ]));

                // Create social login record
                $newSocialUser->social()
                              ->save(new SocialLogin([
                                  'provider'  => $provider,
                                  'social_id' => $user->id
                              ]));

                $socialUser = $newSocialUser;

            } else {

                //Load this existing social user
                $socialUser = $sameSocialId->user;

            }

        }

        auth()->login($socialUser, true);

        if (auth()->user()->role != 'registered') {
            return redirect('/' . auth()->user()->role . '/dashboard');
        }

        if (auth()->user()->role == 'registered') {
            return redirect('/home');
        }

        return abort(500,
            'User has no Role assigned, role is obligatory! You did not seed the database with the roles.');

    }
}
