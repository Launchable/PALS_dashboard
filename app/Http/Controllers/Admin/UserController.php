<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Repositories\UserRepository;
use App\User;
use App\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    private $pageName = 'user';
    private $limit    = 10;
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $users = $this->userRepository->index();

        return view('admin.user.index', [
            'pageName' => $this->pageName,
            'users'    => $users
        ]);
    }

    public function search(Request $request)
    {
        dd($request);
    }

    /**
     * Show add user page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('admin.user.add', [
            'pageName' => $this->pageName
        ]);
    }

    /**
     * Save a user record
     *
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserRequest $request)
    {
        // Create new user record
        $user = $this->userRepository->create($request);

        // Upload image
        $user = $this->uploadImage($request, $user);

        // Save profile information
        $profile = new UserProfile([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'phone'      => $request->input('phone'),
            'age'        => $request->input('age'),
            'gender'     => $request->input('gender'),
        ]);

        $user->profile()
             ->save($profile);

        flash('User has been added successfully', 'success');

        return redirect()->back();
    }

    public function edit($id)
    {
        $user = $this->userRepository->getUserInformationById($id);

        return view('admin.user.edit', [
            'pageName' => $this->pageName,
            'user'     => $user
        ]);
    }

    /**
     * Update a user avatar
     *
     * @param UpdateAvatarRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateAvatar(UpdateAvatarRequest $request)
    {
        $user = $this->userRepository->find($request->input('id'));
        $user = $this->uploadImage($request, $user);

        flash('Profile image has been updated successfully.', 'success');

        return redirect()->route('admin.user.edit', [$user->id]);
    }

    /**
     * Update user profile
     *
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $this->userRepository->getUserInformationById($request->input('id'));

        // Update the related user profile record
        $user->profile->first_name = $request->input('first_name');
        $user->profile->last_name  = $request->input('last_name');
        $user->profile->phone      = $request->input('phone');
        $user->profile->age        = $request->input('age');
        $user->profile->gender     = $request->input('gender');

        $user->profile->save();

        flash('Profile has been updated successfully.', 'success');

        return redirect()->route('admin.user.edit', [$request->input('id')]);
    }

    /**
     * Update user password
     *
     * @param UpdatePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user           = $this->userRepository->getUserInformationById($request->input('id'));
        $user->role     = $request->input('role');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        flash('Login credential has been updated.', 'success');

        return redirect()->route('admin.user.edit', [$request->input('id')]);
    }

    /**
     * Delete a user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $user = $this->userRepository->find($request->input('id'));
        $user->delete();

        return redirect()->route('admin.user.index');
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

        Image::make($avatar)
             ->resize(300, 300)
             ->save(public_path('/uploads/avatars/' . $filename));

        $user         = $this->userRepository->find($user->id);
        $user->avatar = $filename;
        $user->save();

        return $user;
    }
}
