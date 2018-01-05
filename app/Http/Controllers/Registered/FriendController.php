<?php

namespace App\Http\Controllers\Registered;

use App\Repositories\FriendsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    private $pageName = 'friends';
    /**
     * @var FriendsRepository
     */
    private $friendsRepository;

    /**
     * FriendController constructor.
     * @param FriendsRepository $friendsRepository
     */
    public function  __construct(FriendsRepository $friendsRepository)
    {
        $this->friendsRepository = $friendsRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $friends = $this->friendsRepository->getAllFriends();

        return view('registered.friend.index', [
            'pageName' => $this->pageName,
            'friends'  => $friends
        ]);
    }
}
