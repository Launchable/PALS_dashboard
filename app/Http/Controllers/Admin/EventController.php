<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Event\CreateEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Repositories\EventRepository;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class EventController extends Controller
{
    private $eventRepository;
    private $locationRepository;
    private $pageName = 'event';

    public function __construct(EventRepository $eventRepository, LocationRepository $locationRepository)
    {
        $this->eventRepository    = $eventRepository;
        $this->locationRepository = $locationRepository;
    }

    public function index()
    {
        $events = $this->eventRepository->index();

        return view('admin.event.index', [
            'pageName' => $this->pageName,
            'events'   => $events
        ]);
    }

    /**
     * Display add event page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $locations = $this->locationRepository->all();

        return view('admin.event.add', [
            'pageName'  => $this->pageName,
            'locations' => $locations
        ]);
    }
    
    /**
     * Store the event object in db
     *
     * @param CreateEventRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateEventRequest $request)
    {
        $event = $this->eventRepository->create($request);
        $event = $this->uploadImage($request, $event);

        flash('Event has been created successfully.', 'success');

        return redirect()->route('admin.event.edit', $event->id);

    }

    /**
     * Display edit page
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $event     = $this->eventRepository->find($id);
        $locations = $this->locationRepository->all();

        return view('admin.event.edit', [
            'pageName'  => $this->pageName,
            'event'     => $event,
            'locations' => $locations
        ]);
    }

    /**
     * Update an event
     *
     * @param UpdateEventRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateEventRequest $request)
    {
        $event = $this->eventRepository->update($request);

        flash('Event has been updated successfully.', 'success');

        return redirect()->route('admin.event.edit', $event->id);
    }

    /**
     * Remove a event
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $event = $this->eventRepository->find($request->input('id'));
        $event->delete();

        flash('The event has been deleted successfully.', 'success')->important();

        return redirect()->route('admin.event.index');
    }

    /**
     * Update the event image
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function imageUpdate(Request $request)
    {
        $event = $this->eventRepository->find($request->input('id'));
        $event = $this->uploadImage($request, $event);

        flash('Event image has been updated successfully.', 'success');

        return redirect()->route('admin.event.edit', $event->id);
    }

    /**
     * Upload Image
     *
     * @param $request
     * @param $event
     * @return mixed
     */
    private function uploadImage($request, $event)
    {
        $image    = $request->file('image');
        $filename = $event->id . '.' . $image->getClientOriginalExtension();

        Image::make($image)
             ->resize(300, 300)
             ->save(public_path('/uploads/events/' . $filename));

        $event        = $this->eventRepository->find($event->id);
        $event->image = $filename;
        $event->save();

        return $event;
    }
}
