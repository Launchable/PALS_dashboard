<?php namespace App\Repositories;

use App\Event;
use Illuminate\Support\Facades\Auth;

class EventRepository
{
    private $event;
    private $pageLimit = 10;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get records for main page view
     *
     * @return mixed
     */
    public function index()
    {
        return $this->event->with([
            'location'
        ])
                           ->latest()
                           ->get();
    }

    /**
     * Store event
     *
     * @param $request
     * @return static
     */
    public function create($request)
    {
        return $this->event->create([
            'location_id' => $request->input('location_id'),
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
            'date'        => date('Y-m-d H:i:s', strtotime($request->input('date')))
        ]);
    }

    /**
     * Update a event object
     *
     * @param $request
     * @return mixed
     */
    public function update($request)
    {
        $event              = $this->find($request->input('id'));
        $event->location_id = $request->input('location_id');
        $event->title       = $request->input('title');
        $event->description = $request->input('description');
        $event->date        = date('Y-m-d H:i:s', strtotime($request->input('date')));
        $event->save();

        return $event;
    }
    
    /**
     * Find a single record by id
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->event->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findByOwner($id)
    {
        return $this->event->join('locations', 'events.location_id', '=', 'locations.id')
                           ->where('events.id', $id)
                           ->where('locations.user_id', Auth::user()->id)
            ->select('events.*')
                           ->first();
    }

    /**
     * Get events for current logged in user
     * 
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUserEvents($userId)
    {
        return $this->event->with([
            'location'
        ])
                           ->whereHas('Location', function ($q) use ($userId) {
                               $q->where('user_id', $userId)
                                 ->select('id', 'name');
                           })
                           ->get();
    }

    /**
     * Find all event of location
     *
     * @param $id
     * @return mixed
     */
    public function findByLocationId($id)
    {
        return $this->event->where('location_id', $id)
                           ->get();
    }
}