<?php

namespace App\Http\Controllers\Api;

use App\Drink;
use App\Event;
use App\Location;
use App\Repositories\LocationRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends ResponseController
{
    /**
     * Show all locations
     *
     * @return mixed
     */
    public function locations()
    {
        $result = [];
        $locations = Location::latest()->get();
        if(!$locations->isEmpty())
        {
            foreach ($locations as $location)
            {
                $location->image =  URL::to('/').'/uploads/locations/'.$location->image;
                $result[] =  $location;
            }
        }

        return $this->response([
            'code'      => 200,
            'locations' => $result
        ]);
    }

    /**
     * Get events of a location
     *
     * @return $this|mixed
     */
    public function eventsByLocationId()
    {
        $validator = Validator::make(request()->all(), [
            'id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return $this->responseWithError($validator->errors()
                                                      ->first());
        }

        $result = Event::with([
            'location' => function ($query) {
                $query->select('id', 'name', 'address');
            }
        ])
                       ->select('id', 'title', 'description', 'image', 'location_id', 'date')
                       ->where('location_id', request('id'))
                       ->get();

        $events = [];

        foreach ($result as $key => $data) {
            $events[$key]['title']       = $data->title;
            $events[$key]['description'] = $data->description;
            $events[$key]['date']        = $data->date;
            $events[$key]['image']       = URL::to('/').'/uploads/locations/'.$data->image;
            $events[$key]['location']    = $data->location->name;
            $events[$key]['address']     = $data->location->address;
        }

        return $this->response([
            'code' => 200,
            'events' => $events
        ]);
    }

    public function drinksByLocation(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'location_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return $this->responseWithError($validator->errors()
                ->first());
        }
        $result = Drink::join('locations', 'drinks.location_id', '=', 'locations.id')->where('location_id', $request->location_id)->get();
        return $this->response([
            'code'      => 200,
            'locations' => $result
        ]);

    }
}
