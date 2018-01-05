<?php

namespace App\Http\Controllers\Api;

use App\Cover;
use App\Drink;
use App\Location;
use App\LocationUsers;
use App\Order;
use App\UserDrink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DrinkController extends ResponseController
{
    /**
     * Get all drinks for the user
     *
     * @return mixed
     */
    public function userDrinks()
    {
        $results = UserDrink::with([
            'drink',
            'drink.type',
            'drink.location',
            'sender'
        ])
                            ->where('user_id', $this->guard()
                                                    ->id())
                            ->get();

        $drinks = [];

        foreach ($results as $key => $data) {
            $drinks[$key]['id']                 = $data->drink->id;
            $drinks[$key]['code']               = $data->drink->code;
            $drinks[$key]['name']               = $data->drink->title;
            $drinks[$key]['type']               = $data->drink->type->name;
            $drinks[$key]['color']              = $data->drink->type->color;
            $drinks[$key]['location']['code']   = $data->drink->location->code;
            $drinks[$key]['location']['name']   = $data->drink->location->name;
            $drinks[$key]['sender']['username'] = $data->sender->username;
            $drinks[$key]['sender']['avatar']   =
                isset($data->sender->avatar) ? $data->sender->avatar : $data->sender->avatar_social;
            $drinks[$key]['message']            = $data->message;
            $drinks[$key]['price']              = $data->price;
            $drinks[$key]['is_redeemed']        = ($data->is_redeemed == 0) ? 'NO' : 'YES';
        }

        return $this->response([
            'code'   => 200,
            'drinks' => [
                $drinks
            ]
        ]);
    }

    /**
     * Order Drink
     *
     * @param Request $request
     * @return mixed
     */
    public function orderDrink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'friendId' => 'exists:users,id', // Not sure what do, is it for gift to friend?
            'locationId' => 'required|exists:locations,id',
            'drinkId' => 'exists:drinks,id',
            'coverId' => 'exists:covers,id',
            'quantity' => 'required|numeric',
            'message'  => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseWithError($validator->errors()
                ->first());
        }

        $data = $request->all();

        if($order = Order::create([
            'user_id'     => auth()->id(),
            'friend_id'   => $request->friendId,
            'cover_id'    => $request->coverId,
            'drink_id'    => $request->drinkId,
            'price'       => $request->drinkId ? Drink::find($data['drinkId'])->price : Cover::find($data['coverId'])->price,
            'total_amount'       => ($request->drinkId ? Drink::find($data['drinkId'])->price : Cover::find($data['coverId'])->price * $data['quantity']),
            'location_id' => $data['locationId'],
            'message'       => $data['message'],
            'quantity'       => $data['quantity'],
            'is_redeemed' => 0
        ]))  {

            if($request->drinkId)
            {
                $drink = Drink::find($request->drinkId);
                Drink::find($request->drinkId)->update(['stocks'=> ($drink->stocks-$data['quantity'])]);
            }

            $recipient = \App\User::find($request->friendId);
            $sender = auth()->user();
            $recipient_tokens = $recipient->device_token;
            $message = array("message" => $sender->first_name." ".$sender->last_name." sent you a drink.");
            if($recipient_tokens)
                $sender->send_notification(array($recipient_tokens), $message);

            return $this->response([
                'code'   => 200,
                'message'=> 'Your order has been placed',
                'order' => $order
            ]);
        }

        return $this->responseWithError("Something went wrong please try again..");
    }

    /**
     * Redeem Drink/Cover
     *
     * @param Request $request
     * @return mixed
     */
    public function redeemDrink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'drink_id' => 'exists:drinks,id',
            'cover_id' => 'exists:covers,id',
            'location_code' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError($validator->errors()
                ->first());
        }

        if(!$request->drink_id && !$request->cover_id)
            return $this->responseWithError('Please select drink/cover to redeem.');

        $user = auth()->user();
        $location = Location::where('code', $request->location_code)->get();
        if($location->isEmpty())
            return $this->responseWithError('Location not found.');
        $location_user = LocationUsers::where('location_id',$location[0]->id)->get();
        if($location_user->isEmpty())
            return $this->responseWithError('Location is not assign with certain user.');

        if($request->drink_id)
        {
            $drinks = Drink::where('location_id',$location[0]->id)->where('id',$request->drink_id)->get();
            if($drinks->isEmpty())
                return $this->responseWithError('Drink is not belong to this location.');
            else
            {
                $order = Order::where('drink_id', $request->drink_id)->where('friend_id', $user->id)->get();
                if($order->isEmpty())
                    return $this->responseWithError('Drink is not sold yet.');
                Order::find($order[0]->id)->update(['is_redeemed'=>1]);
                return $this->response([
                    'code'   => 200,
                    'message'=> 'Drink successfully redeemed.',
                ]);
            }
        }
        else
        {
            $cover = Cover::where('location_id',$location[0]->id)->where('id',$request->cover_id)->get();
            if($cover->isEmpty())
                return $this->responseWithError('Cover is not belong to this location.');
            else
            {
                $order = Order::where('cover_id', $request->cover_id)->where('friend_id', $user->id)->get();
                if($order->isEmpty())
                    return $this->responseWithError('Cover is not sold yet.');
                Order::find($order[0]->id)->update(['is_redeemed'=>1]);
                return $this->response([
                    'code'   => 200,
                    'message'=> 'Cover successfully redeemed.',
                ]);
            }
        }
    }

    /**
     * Get all drinks
     *
     * @return mixed
     */
    public function getAllDrinks()
    {
        return $this->response([
            'code'   => 200,
            'drinks' => Drink::all()
        ]);
    }

    /**
     * Get all covers
     *
     * @return mixed
     */
    public function getAllCovers()
    {
        return $this->response([
            'code'   => 200,
            'covers' => Cover::all()
        ]);
    }
}
