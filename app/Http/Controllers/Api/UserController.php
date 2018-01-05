<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\UpdateLocationRequest;
use App\Location;
use App\LocationUsers;
use App\Order;
use App\User;
use App\UserLocation;
use App\UserProfile;
use Hootlex\Friendships\Models\Friendship;
use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Stripe\Error\Card;
use Mockery\CountValidator\Exception;

class UserController extends ResponseController
{
    /**
     * Get account detail
     *
     * @return mixed
     */
    public function getAccountDetail()
    {
        $user = auth()->user();
        $user->load('profile:user_id,first_name,last_name,phone');
        $user->notification = [
            'friend_request' => Friendship::where('recipient_id', $user->id)->get(),
            'drink_sent_request' => Order::where('friend_id', $user->id)->whereNotNull('drink_id')->where('is_redeemed',0)->get(),
            'cover_sent_request' => Order::where('friend_id', $user->id)->whereNotNull('cover_id')->where('is_redeemed',0)->get()
        ];
        if (strpos($user->avatar, 'http') === false)
            $user->avatar = URL::to('/').'/uploads/avatars/'.$user->avatar;

        return $this->response([
            'code'      => 200,
            'user' => $user
        ]);
    }

    /**
     * Get account detail
     *
     * @return mixed
     */
    public function getAllUsers()
    {
        $users_with_status = [];
        $users = User::where('id', '<>', auth()->id())->get();
        foreach ($users as $user)
        {
            $user_profile = UserProfile::where('user_id',$user->id)->get()->toArray();
            $invitation_sent = Friendship::where('sender_id', $user->id)->where('status',0)->get(['recipient_id']);
            $invitation_received = Friendship::where('recipient_id', $user->id)->get(['sender_id']);
            $invitation_accepted = Friendship::where('sender_id', $user->id)->where('status',1)->get(['sender_id']);
            $friendship_status = "";
            $recipient = User::find($user->id);
            if($this->guard()->user()->isFriendWith($recipient))
                $friendship_status = 'Friends';
            elseif($this->guard()->user()->hasFriendRequestFrom($recipient))
                $friendship_status = 'Pending';
            else
                $friendship_status = "Not friends";
            $user->complete_name = $user_profile[0]['first_name'].' '.$user_profile[0]['last_name'];
            if (strpos($user->avatar, 'http') === false)
                $user->avatar = URL::to('/').'/uploads/avatars/'.$user->avatar;
            $user->phone = $user_profile[0]['phone'];
            $user->friendship_status = $friendship_status;
            $user->invite_by_this_user = Friendship::where('sender_id', $user->id)->where('recipient_id', auth()->id())->count() > 0 ? "Yes" : "No";
            $user->invitation_sent = $invitation_sent->isEmpty() ? [] : $invitation_sent;
            $user->invitation_received = $invitation_received->isEmpty() ? [] : $invitation_received;
            $user->invitation_accepted = $invitation_accepted->isEmpty() ? [] : $invitation_accepted;
            $users_with_status[] = $user;
        }

        return $this->response([
            'code' => 200,
            'users' => $users_with_status
        ]);
    }

    /**
     * Update user account's email/phone
     *
     * @param Request $request
     * @return mixed
     */
    public function updateAccountDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required_without_all:email,phone|email|unique:users,email,' . auth()->id(),
            'phone' => 'required_without_all:email,phone' // depends on country, is mob is unique
        ]);

        if ($validator->fails()) {
            return $this->responseWithError($validator->errors()
                ->first());
        }

        $user = auth()->user();

        if($request->has('email')) {
            $user->email = $request->get('email');
            $user->save();
        }

        if($request->has('phone')) {
            $profile = $user->profile;
            $profile->phone = $request->get('phone');
            $profile->save();
        }

        return $this->responseWithSuccess('User account detail has been updated');
    }

    /**
     * Get old orders with pagination
     * @return mixed
     */
    public function getUserOrder()
    {
        $user = auth()->user();

        return $user->orders()->paginate();
    }

    public function userLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        if ($validator->fails())
            return $this->responseWithError($validator->errors()->first());

        //check a valid latitude
        if(!preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', $request->latitude))
            return $this->responseWithError("Invalid latitude.");

        //check a valid longitude
        if(!preg_match('/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $request->latitude))
            return $this->responseWithError("Invalid longitude.");

        $user = auth()->user();

        if($user->userLocation)
            $userLocation = $user->userLocation;
        else
        {
            $userLocation = new UserLocation();
            $userLocation->user_id = $user->id;
        }
        $userLocation->fill($request->all())->save();
        return $this->responseWithSuccess('User location detail has been updated');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPaymentWithStripe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_no' => 'required',
            'ccExpiryMonth' => 'required',
            'ccExpiryYear' => 'required',
            'cvvNumber' => 'required',
            'amount' => 'required',
            'name'  => 'required'
        ]);
        if ($validator->fails())
            return $this->responseWithError($validator->errors()->first());

        $input = $request->all();
        if ($validator->passes()) {
            $input = array_except($input,array('_token'));
            $stripe = Stripe::make('sk_test_SN4cUlf3yhS46ZmlaXe3Ej8m');
            try {
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number'    => $request->card_no,
                        'exp_month' => $request->ccExpiryMonth,
                        'exp_year'  => $request->ccExpiryYear,
                        'cvc'       => $request->cvvNumber,
                        'name'      => $request->name,
                    ],
                ]);
                if (!isset($token['id'])) {
                    return $this->responseWithError('The Stripe Token was not generated correctly.');
                }
                $charge = $stripe->charges()->create([
                    'card' => $token['id'],
                    'currency' => 'USD',
                    'amount'   => $request->amount,
                    'description' => $request->description ?: 'Add in wallet'
                ]);
                if($charge['status'] == 'succeeded') {
                    /**
                     * Write Here Your Database insert logic.
                     */
                    return $this->responseWithSuccess('Payment transaction successfully completed.');
                } else {
                    $this->responseWithError('Money not add in wallet!!');
                }
            } catch (Exception $e) {
                $this->responseWithError($e->getMessage());
            } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
                $this->responseWithError($e->getMessage());
            } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                $this->responseWithError($e->getMessage());
            }
        }
        $this->responseWithError($e->getMessage());
    }

    public function register_device(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails())
            return $this->responseWithError($validator->errors()->first());

        $user = auth()->user();
        $user->update(['device_token' => $request->token]);

        return $this->response([
            'code'    => 200,
            'message' => 'Device has been registered',
            'device_token'   => $user->device_token
        ]);
    }

}
