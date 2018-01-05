<?php namespace App\Http\Controllers\Registered;


use App\Http\Controllers\ResponseController;
use App\Repositories\UserRepository;
use App\User;
use Hootlex\Friendships\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxFriendController extends ResponseController
{
    /**
     * @var Friendship
     */
    private $friendship;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * AjaxFriendController constructor.
     * @param Friendship     $friendship
     * @param UserRepository $userRepository
     */
    public function __construct(Friendship $friendship, UserRepository $userRepository)
    {
        $this->friendship     = $friendship;
        $this->userRepository = $userRepository;
    }

    /**
     * Confirm a friend request
     *
     * @param Request $request
     * @return mixed
     */
    public function confirmRequest(Request $request)
    {
        if (!$request->input('senderId')) {
            return $this->responseWithError('Sender id is required!');
        }

        $sender = $this->userRepository->find($request->input('senderId'));

        Auth::user()
            ->acceptFriendRequest($sender);

        return $this->responseWithSuccess('Friend request has been confirmed!');
    }
    
    /**
     * Delete friend request
     *
     * @param Request $request
     * @return mixed
     */
    public function deleteRequest(Request $request)
    {
        $friend = $this->friendship->find($request->input('requestId'));

        if (!$friend->delete()) {
            return $this->responseWithError('Error deleting friend request. Please contact the administrator!');
        }

        return $this->responseWithSuccess('Friend request has been delete!');
    }
}
