<?php

namespace App\Http\Controllers\Api;

use App\UserCover;
use Illuminate\Http\Request;

class CoverController extends ResponseController
{
    /**
     * Get all drinks for the user
     *
     * @return mixed
     */
    public function userCovers()
    {
        $results = UserCover::with([
            'cover',
            'cover.location',
            'sender'
        ])
                            ->where('user_id', $this->guard()->id())
                            ->get();

        $covers = [];

        foreach ($results as $key => $data) {
            $covers[$key]['id']               = $data->cover->id;
            $covers[$key]['code']               = $data->cover->code;
            $covers[$key]['name']               = $data->cover->title;
            $covers[$key]['location']['code']   = $data->cover->location->code;
            $covers[$key]['location']['name']   = $data->cover->location->name;
            $covers[$key]['sender']['username'] = $data->sender->username;
            $covers[$key]['sender']['avatar']   =
                isset($data->sender->avatar) ? $data->sender->avatar : $data->sender->avatar_social;
            $covers[$key]['message'] = $data->message;
            $covers[$key]['price'] = $data->price;
            $covers[$key]['is_redeemed'] = ($data->is_redeemed == 0) ? 'NO' : 'YES';
        }

        return $this->response([
            'code'   => 200,
            'drinks' => [
                $covers
            ]
        ]);
    }
}
