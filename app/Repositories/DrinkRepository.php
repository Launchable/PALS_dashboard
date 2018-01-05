<?php namespace App\Repositories;

use App\Drink;
use App\DrinkType;
use Illuminate\Support\Facades\Auth;

class DrinkRepository
{
    private $drink;
    private $drinkType;
    private $pageLimit = 10;

    public function __construct(Drink $drink, DrinkType $drinkType)
    {
        $this->drink     = $drink;
        $this->drinkType = $drinkType;
    }

    public function index()
    {
        return $this->drink->with([
            'type',
            'location'
        ])
                           ->latest()
                           ->get();
    }

    public function create($request)
    {
        $isLimited   = isset($request->is_limited) ? 1 : 0;
        $isAvailable = isset($request->is_available) ? 1 : 0;

        return $this->drink->create([
            'location_id'  => $request->input('location_id'),
            'type_id'      => $request->input('type_id'),
            'title'        => $request->input('title'),
            'description'  => $request->input('description'),
            'price'        => $request->input('price'),
            'start_time'   => !empty($request->input('start_time')) ?
                date('H:i:s', strtotime($request->input('start_time'))) : null,
            'end_time'     => !empty($request->input('end_time')) ?
                date('H:i:s', strtotime($request->input('end_time'))) : null,
            'timed_price'  => !empty($request->input('timed_price')) ? $request->input('timed_price') : null,
            'promo_code'   => !empty($request->input('promo_code')) ? $request->input('promo_code') : null,
            'stocks'       => !empty($request->input('stocks')) ? $request->input('stocks') : null,
            'is_limited'   => $isLimited,
            'is_available' => $isAvailable,
        ]);
    }

    /**
     * Update a drink object
     *
     * @param $request
     * @return mixed
     */
    public function update($request)
    {
        $isLimited   = isset($request->is_limited) ? 1 : 0;
        $isAvailable = isset($request->is_available) ? 1 : 0;

        $drink               = $this->find($request->input('id'));
        $drink->location_id  = $request->input('location_id');
        $drink->type_id      = $request->input('type_id');
        $drink->title        = $request->input('title');
        $drink->description  = $request->input('description');
        $drink->price        = $request->input('price');
        $drink->start_time   = !empty($request->input('start_time')) ? $request->input('start_time') : null;
        $drink->end_time     = !empty($request->input('end_time')) ? $request->input('end_time') : null;
        $drink->timed_price  = !empty($request->input('timed_price')) ? $request->input('timed_price') : null;
        $drink->promo_code   = $request->input('promo_code');
        $drink->stocks       = !empty($request->input('stocks')) ? $request->input('stocks') : null;
        $drink->is_limited   = $isLimited;
        $drink->is_available = $isAvailable;
        $drink->save();

        return $drink;
    }

    /**
     * Find a drink with its id
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->drink->find($id);
    }

    public function findByOwner($id)
    {
        return $this->drink->join('locations', 'drinks.location_id', '=', 'locations.id')
                           ->where('drinks.id', $id)
                           ->where('locations.user_id', Auth::user()->id)
                           ->first();
    }

    /**
     * Return all drink types
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function drinkTypes()
    {
        return $this->drinkType->all();
    }

    /**
     * Get drinks for current login manager
     *
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUserDrinks($userId)
    {
        return $this->drink->with([
            'type',
            'location'
        ])
                           ->whereHas('Location', function ($q) use ($userId) {
                               $q->where('user_id', $userId)
                                 ->select('id', 'name');
                           })
                           ->get();
        
    }

    /**
     * Find all drinks of location
     * 
     * @param $id
     * @return mixed
     */
    public function findByLocationId($id)
    {
        return $this->drink->where('location_id', $id)
                           ->get();
    }

}