<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class LoginController extends ResponseController
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required',
            'password' => 'required'
        ]);

        // Failed validation
        if ($validator->fails()) {
            return $this->responseWithError('Invalid username or password');
        }

        // Check login attempts
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse();
        }

        if ($this->attemptLogin($request)) {

            $user = Auth::user();

            if (strpos($user->avatar, 'http') === false)
                $user->avatar = URL::to('/').'/uploads/avatars/'.$user->avatar;

            return $this->response([
                'code'    => 200,
                'token'   => $user->api_token,
                'profile' => [
                    'user_id' => $user->id,
                    'avatar' => (isset($user->avatar_social)) ? $user->avatar_social : $user->avatar,
                    'name'   => $user->profile->first_name . ' ' . $user->profile->last_name,
                    'email'  => $user->email
                ]
            ]);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->responseWithError('Invalid username or password');
    }

    protected function authenticated(Request $request, $user)
    {
        //
    }
    
    /**
     * Redirect the user after determining they are locked out.
     */
    protected function sendLockoutResponse()
    {
        return $this->responseWithError('Too many login attempts. You have been lockout. Please try again later.');
    }
    
    /**
     * Overwrite credentials method
     *
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        // Allow login with username or email
        $field = filter_var($request->input($this->username()), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$field => $request->input($this->username())]);

        return $request->only($field, 'password');
    }


    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::guard()->logout();
        return $this->responseWithSuccess('Logout successful.');
    }
}
