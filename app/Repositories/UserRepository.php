<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    private $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function index()
    {
        return User::select('id', 'username', 'email', 'role', 'last_logged_in_at')
                   ->orderBy('created_at', 'desc')
                   ->get();
    }
    
    public function create($request)
    {
        return User::create([
            'username' => $request->input('username'),
            'email'    => $request->input('email'),
            'role'     => $request->input('role'),
            'password' => bcrypt($request->input('password')),
        ]);
    }
    
    public function find($id)
    {
        return User::find($id);
    }
    
    /**
     * Get the user information including the user profile
     * by the user id
     *
     * @param $userId
     * @return mixed
     */
    public function getUserInformationById($userId)
    {
        return $this->user->where('id', $userId)
                          ->with('profile')
                          ->first();
    }
    
    /**
     * Get all users by their role
     *
     * @param $role
     * @return mixed
     */
    public function getUserByRole($role)
    {
        return $this->user->where('role', $role)
                          ->with('profile')
                          ->get();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getManagers()
    {
        return $this->user->with('profile')
                          ->where('role', 'manager')
                          ->get();
    }
    
    /**
     * Get all the locations of the user
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUserLocations()
    {
        return $this->user->with([
            'locations' => function ($query) {
                $query->select('locations.id', 'locations.name', 'locations.description', 'locations.phone',
                    'locations.created_at as created', 'locations.updated_at as updated')
                      ->orderBy('id', 'asc');
            }
        ])
                          ->select('id', 'username')
                          ->where('id', Auth::user()->id)
                          ->first();
    }

    /**
     * Check if user is owner of location
     *
     * @param $locationId
     * @return bool
     */
    public function isOwner($locationId)
    {
        return DB::table('location_users')
                 ->whereLocationId($locationId)
                 ->whereUserId(Auth::user()->id)
                 ->exists();
    }

}