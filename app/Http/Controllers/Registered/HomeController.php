<?php

namespace App\Http\Controllers\Registered;

use App\Http\Controllers\Controller;
use App\Repositories\FriendsRepository;
use App\UserCover;
use App\UserDrink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    
    private $pageName = 'home';
    /**
     * @var FriendsRepository
     */
    private $friendsRepository;

    /**
     * HomeController constructor.
     * @param FriendsRepository $friendsRepository
     */
    public function __construct(FriendsRepository $friendsRepository)
    {
        $this->friendsRepository = $friendsRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drinks        = $this->userDrinks();
        $covers        = $this->userCovers();
        $friendRequest = $this->friendsRepository->getFriendRequests();

        return view('registered.home', [
            'pageName'      => $this->pageName,
            'drinks'        => $drinks,
            'covers'        => $covers,
            'friendRequest' => $friendRequest
        ]);
    }
    
    private function userDrinks()
    {
        $drinks = UserDrink::with([
            'drink',
            'drink.location',
            'sender'
        ])
                           ->ForCurrentUser()
                           ->NotRedeemed()
                           ->get();

        return $drinks;
    }

    private function userCovers()
    {
        $covers = UserCover::with([
            'cover',
            'cover.location',
            'sender'
        ])
                           ->ForCurrentUser()
                           ->NotRedeemed()
                           ->get();

        return $covers;
    }
    
}
