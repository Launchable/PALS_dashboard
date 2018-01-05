<?php

namespace App\Http\Controllers\Api;

use App\AppSetting;
use App\User;
use App\UserProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Http\File;
use App\Repositories\UserRepository;

class RegisterController extends ResponseController
{
    use RegistersUsers, SendsPasswordResetEmails;

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|alpha_num|max:20|unique:users,username',
            'email'    => 'required|email|max:50|unique:users,email',
            'password' => 'required|min:6',
            'phone'   => '' // not sure if it compulsory
        ]);

        if ($validator->fails()) {
            return $this->responseWithError($validator->errors()
                                                      ->first());
        }

        event(new Registered($user = $this->create($request->all())));
        $user = $this->uploadImage($request, $user);

        return $this->response([
            'code'    => 200,
            'message' => 'User has been registered',
            'token'   => $user->api_token
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'username'  => $data['username'],
            'email'     => $data['email'],
            'password'  => bcrypt($data['password']),
            'api_token' => str_random(60)
        ]);

        $user->profile()
             ->create([
                 'phone' => array_get($data, 'phone')
             ]);

        return $user;
    }

    /**
     * Overwrite the reset link post
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ], [
            'passwords.user' => 'User does not exists.'
        ]);

        if ($validator->fails()) {
            return $this->responseWithError($validator->errors()->first());
        }
        $response = $this->broker()->sendResetLink($request->only('email'));
        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse('Password reset link has successfully sent to your email.')
            : $this->sendResetLinkFailedResponse($request, 'Email is not found in our database.');
    }

    /**
     * Overwrite the send password reponse success
     *
     * @param $response
     * @return mixed
     */
    public function sendResetLinkResponse($response)
    {
        return $this->responseWithSuccess($response);
    }

    /**
     * Overwrite failed response
     *
     * @param Request $request
     * @param         $response
     * @return $this
     */
    public function sendResetLinkFailedResponse(Request $request, $response)
    {
        return $this->responseWithError($response);
    }

    /**
     * @param                   $request
     * @param                   $user
     * @return mixed
     */
    private function uploadImage($request, $user)
    {
        $avatar   = $request->file('avatar');
        $filename = $user->id . '.' . $avatar->getClientOriginalExtension();
        $directory = public_path('uploads/avatars/');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $create_file = $directory . $filename;

        Image::make($avatar)
            ->resize(300, 300)
            ->save($create_file);

        $user         = $this->userRepository->find($user->id);
        $user->avatar = $filename;
        $user->save();

        return $user;
    }

    public function broker()
    {
        return Password::broker();
    }

    public function postFacebookAPI(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|alpha_num|max:20|unique:users,username',
            'email'    => 'required|email|max:50|unique:users,email',
        ]);

        if ($validator->fails() && $validator->errors()->first() == 'The email has already been taken.')
        {
            $user = User::where('email', $request['email'])->get();
            $user = User::find($user[0]->id);
            $user->profile = $user->profile()->get();
            if (strpos($user->avatar, 'http') === false)
                $user->avatar = URL::to('/').'/uploads/avatars/'.$user->avatar;
            return $this->response([
                'code'    => 200,
                'token'   => $user->api_token,
                'profile' => [
                    'user_id' => $user->id,
                    'avatar' => (isset($user->avatar_social)) ? $user->avatar_social : $user->avatar,
                    'name'   => $user->profile[0]->first_name . ' ' . $user->profile[0]->last_name,
                    'email'  => $user->email
                ]
            ]);
        }

        if ($validator->fails())
            return $this->responseWithError($validator->errors()->first());

        $user = User::create([
            'username' => $request['email'],
            'email' => $request['email'],
            'role' => 'registered',
            'password' => bcrypt(str_random(16)),
            'api_token' => str_random(60),
            'avatar' => $request['avatar'],
            'avatar_social' => $request['avatar_social']
        ]);

        $user->profile = $user->profile()->create([
            'phone' => $request['phone'],
            'gender' => $request['gender'],
            'first_name' => !empty($request['first_name']) ? $request['first_name'] : null,
            'last_name' => !empty($request['last_name']) ? $request['last_name'] : null,
        ]);

        return $this->response([
            'code'    => 200,
            'token' => $user->api_token,
            'profile' => [
                'avatar' => (isset($user->avatar_social)) ? $user->avatar_social : $user->avatar,
                'name'   => $user->profile->first_name . ' ' . $user->profile->last_name,
                'email'  => $user->email
            ]
        ]);
    }

    public function postAppSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'is_notification' => 'required',
            'help_faq'    => 'required',
            'terms'    => 'required',
            'privacy'    => 'required',
        ]);

        if ($validator->fails())
            return $this->responseWithError($validator->errors()->first());

        if(!$user = User::find($request['user_id']))
            return $this->responseWithError('User not found.');

        $data = [
            'user_id' => $request['user_id'],
            'is_notification' => $request['is_notification'],
            'help_faq'    => $request['help_faq'],
            'terms'    => $request['terms'],
            'privacy'    => $request['privacy'],
        ];

        $app_settings = new AppSetting();
        $exist_settings = $app_settings->where('user_id', $request['user_id'])->get()->toArray();
        if(empty($exist_settings[0]))
            $app_settings = $app_settings->create($data);
        else
            $app_settings = AppSetting::find($exist_settings[0]['id']);
        $app_settings->update($data);
        return $this->response([
            'code'    => 200,
            'message' => 'App settings successfully updated.',
            'app_settings'   => $app_settings
        ]);
    }
}
