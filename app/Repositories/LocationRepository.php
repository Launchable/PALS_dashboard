<?php namespace App\Repositories;

use App\Location;
use App\Type;
use Illuminate\Support\Facades\Auth;

class LocationRepository
{
    private $location;
    private $type;

    public function __construct(Location $location, Type $type)
    {
        $this->location = $location;
        $this->type     = $type;
    }

    /**
     * Returns the location records with users, used in index page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return $this->location->with([
            'users.profile'
        ])
                              ->latest()
                              ->get();
    }

    /**
     * Store a location object
     *
     * @param $request
     * @return static
     */
    public function create($request)
    {
        return $this->location->create([
            'name'        => $request->input('name'),
            'address'     => $request->input('address'),
            'description' => $request->input('description'),
            'phone'       => $request->input('phone'),
            'latitude'    => $request->input('latitude'),
            'longitude'   => $request->input('longitude'),
        ]);
    }

    /**
     * Update a location object
     *
     * @param $request
     * @return mixed
     */
    public function update($request)
    {
        $location              = $this->find($request->input('id'));
        $location->name        = $request->input('name');
        $location->address     = $request->input('address');
        $location->description = $request->input('description');
        $location->phone       = $request->input('phone');
        $location->latitude    = $request->input('latitude');
        $location->longitude   = $request->input('longitude');
        $location->save();

        return $location;
    }

    /**
     * Get data needed for view page
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function view($id)
    {
        return $this->location->with([
            'users.profile',
            'drinks.type',
        ])
                              ->find($id);
    }

    public function viewByOwner($id)
    {
        return $this->location->with([
            //'user',
            //'user.profile',
            //'drinks',
            //'drinks.type',
            //'covers',
            //'events'
        ])
                              ->where('user_id', Auth::user()->id)
                              ->find($id);
    }

    /**
     * Find a location by id
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->location->find($id);
    }

    /**
     * Find By owner
     *
     * @param $id
     * @return mixed
     */
    public function findByOwner($id)
    {
        return $this->location->where('user_id', Auth::user()->id)
                              ->find($id);
    }

    /**
     * Get all locations
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->location->all();
    }

    /**
     * Get all location types
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function locationTypes()
    {
        return $this->type->all();
    }
    
    /**
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUserLocations($userId)
    {
        return $this->location->where('user_id', $userId)
                              ->get();
    }

    public function getUserLocationsFirst($userId)
    {
        return $this->location->where('user_id', $userId)
                              ->first();
    }
}