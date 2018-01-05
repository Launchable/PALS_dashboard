<?php namespace App\Repositories;

use Hootlex\Friendships\Models\Friendship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendsRepository
{
    /**
     * Retrieve the friend request for the current logged in user
     *
     * @return mixed
     */
    public function getFriendRequests()
    {
        $requests = DB::table('friendships as friend')
                      ->join('users as user', 'friend.sender_id', '=', 'user.id')
                      ->join('user_profiles as profile', 'user.id', '=', 'profile.user_id')
                      ->select(
                          'user.avatar',
                          'user.avatar_social',
                          'profile.first_name',
                          'profile.last_name',
                          'friend.created_at',
                          'friend.sender_id',
                          'friend.id')
                      ->where('friend.recipient_id', Auth::user()->id)
                      ->where('friend.status', 0)
                      ->get();

        return $requests;
    }

    /**
     * Retrived all friends of the current logged in user
     *
     * @return mixed
     */
    public function getAllFriends()
    {
        $friends = DB::table('friendships as friend')
                     ->join('users as user', 'friend.sender_id', '=', 'user.id')
                     ->join('user_profiles as profile', 'user.id', '=', 'profile.user_id')
                     ->select(
                         'user.avatar',
                         'user.avatar_social',
                         'user.email',
                         'profile.first_name',
                         'profile.last_name',
                         'profile.phone',
                         'profile.gender',
                         'profile.age',
                         'friend.created_at',
                         'friend.sender_id',
                         'friend.id')
                     ->where('friend.recipient_id', Auth::user()->id)
                     ->where('friend.status', 1)
                     ->get();

        return $friends;
    }
}