<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests\Event\CreateEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Repositories\EventRepository;
use App\Repositories\LocationRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class EventController extends Controller
{
    private $eventRepository;
    private $locationRepository;
    private $pageName = 'event';
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * EventController constructor.
     * @param EventRepository    $eventRepository
     * @param LocationRepository $locationRepository
     * @param UserRepository     $userRepository
     */
    public function __construct(EventRepository $eventRepository, LocationRepository $locationRepository,
        UserRepository $userRepository)
    {
        $this->eventRepository    = $eventRepository;
        $this->locationRepository = $locationRepository;
        $this->userRepository     = $userRepository;
    }

    public function index(Request $request)
    {
        $userLocations = $this->userRepository->getUserLocations();
        $locationId    =
            ($request->isMethod('post')) ? request('location') : $userLocations->locations[0]->id;
        $events        = $this->eventRepository->findByLocationId($locationId);

        return view('manager.event.index', [
            'pageName'   => $this->pageName,
            'locationId' => $locationId,
            'locations'  => $userLocations,
            'events'     => $events
        ]);
    }

    /**
     * Display add event page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $userLocations = $this->userRepository->getUserLocations();

        return view('manager.event.add', [
            'pageName'  => $this->pageName,
            'locations' => $userLocations->locations
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

        return redirect()->route('manager.event.edit', $event->id);

    }

    /**
     * Display edit page
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (!$event = $this->eventRepository->find($id)) {
            return redirect()->back();
        }

        $userLocations = $this->userRepository->getUserLocations();

        return view('manager.event.edit', [
            'pageName'  => $this->pageName,
            'event'     => $event,
            'locations' => $userLocations->locations
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

        return redirect()->route('manager.event.edit', $event->id);
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

        return redirect()->route('manager.event.index');
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

        return redirect()->route('manager.event.edit', $event->id);
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
