<?php namespace App\Repositories;

use App\Cover;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoverRepository
{
    private $cover;
    private $pageLimit = 10;

    public function __construct(Cover $cover)
    {
        $this->cover = $cover;
    }

    /**
     * Get data for index view
     *
     * @return mixed
     */
    public function index()
    {
        return $this->cover->latest()
                           ->get();
    }

    /**
     * Store a cover object
     *
     * @param $request
     * @return static
     */
    public function create($request)
    {
        return $this->cover->create($request->all());
    }

    public function find($id)
    {
        return $this->cover->find($id);
    }

    public function findByOwner($id)
    {
        return $this->cover->join('locations', 'covers.location_id', '=', 'locations.id')
                           ->where('covers.id', $id)
                           ->where('locations.user_id', Auth::user()->id)
                           ->first();
    }

    /**
     * Update a cover object
     *
     * @param $request
     * @return mixed
     */
    public function update($request)
    {
        $cover              = $this->find($request->input('id'));
        $cover->location_id = $request->input('location_id');
        $cover->title       = $request->input('title');
        $cover->description = $request->input('description');
        $cover->price       = $request->input('price');
        $cover->save();

        return $cover;
    }
    
    /**
     * Get covers for a user
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUserCovers($userId)
    {
        return $this->cover->with([
            'location'
        ])
                           ->whereHas('Location', function ($q) use ($userId) {
                               $q->where('user_id', $userId)
                                 ->select('id', 'name');
                           })
                           ->get();
    }

    /**
     * Find all cover of location
     *
     * @param $id
     * @return mixed
     */
    public function findByLocationId($id)
    {
        return $this->cover->where('location_id', $id)
                           ->get();
    }
}