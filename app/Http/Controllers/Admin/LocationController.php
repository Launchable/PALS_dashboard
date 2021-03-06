<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Location\CreateLocationRequest;
use App\Http\Requests\Location\UpdateImageRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Location;
use App\LocationOperation;
use App\Repositories\LocationRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class LocationController extends Controller
{
    private $pageName = 'location';
    private $userRepository;
    private $locationRepository;
    private $limit    = 20;
    
    public function __construct(UserRepository $userRepository, LocationRepository $locationRepository)
    {
        $this->userRepository     = $userRepository;
        $this->locationRepository = $locationRepository;
    }
    
    /**
     * Display all locations
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $locations = $this->locationRepository->index($this->limit);
        
        return view('admin.location.index', [
            'pageName'  => $this->pageName,
            'locations' => $locations
        ]);
    }
    
    /**
     * Display location page
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id)
    {
        $location = $this->locationRepository->view($id);
        
        return view('admin.location.view', [
            'pageName' => $this->pageName,
            'location' => $location
        ]);
    }

    /**
     * Display edit location page
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $location = $this->locationRepository->find($id);
        $users    = $this->userRepository->getManagers();
        $types    = $this->locationRepository->locationTypes();

        $operations = [];

        foreach ($location->operations as $operation) {
            $operations[] = $operation;
        }

        return view('admin.location.edit', [
            'pageName'   => $this->pageName,
            'location'   => $location,
            'users'      => $users,
            'types'      => $types,
            'operations' => $operations
        ]);
    }

    /**
     * Update a location
     *
     * @param UpdateLocationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateLocationRequest $request)
    {
        $location = $this->locationRepository->update($request);

        // Sync location types
        $location->types()
                 ->sync($request->input('types'));
        // Sync location users
        $location->users()
                 ->sync($request->input('users'));

        // Insert operation hours
        foreach ($request->input('days') as $day) {

            if (empty($day['opens_at']) OR empty($day['closes_at'])) {
                $day['opens_at']  = null;
                $day['closes_at'] = null;
            } else {
                $day['opens_at']  = date('H:i:s', strtotime($day['opens_at']));
                $day['closes_at'] = date('H:i:s', strtotime($day['closes_at']));
            }

            $operation            = LocationOperation::find($day['id']);
            $operation->opens_at  = $day['opens_at'];
            $operation->closes_at = $day['closes_at'];
            $operation->save();
        }

        flash('Location has been created successfully.', 'success');

        return redirect()->route('admin.location.edit', $location->id);
    }

    /**
     * Display add location page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $users = $this->userRepository->getManagers();
        $types = $this->locationRepository->locationTypes();

        return view('admin.location.add', [
            'pageName' => $this->pageName,
            'users'    => $users,
            'types'    => $types
        ]);
    }

    /**
     * Create a new location in database
     *
     * @param CreateLocationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateLocationRequest $request)
    {
        // Insert location information
        $location = $this->locationRepository->create($request);
        
        // Check if image is present and update the location
        $location = $this->uploadImage($request, $location);

        // Insert location types
        $location->types()
                 ->sync($request->input('types'));

        // Insert location users
        $location->users()
                 ->sync($request->input('users'));
        
        // Insert operation hours
        foreach ($request->input('days') as $day) {

            if (empty($day['opens_at']) OR empty($day['closes_at'])) {
                $day['opens_at']  = null;
                $day['closes_at'] = null;
            } else {
                $day['opens_at']  = date('H:i:s', strtotime($day['opens_at']));
                $day['closes_at'] = date('H:i:s', strtotime($day['closes_at']));
            }

            $location->operations()
                     ->create($day);
        }
        
        flash('Location has been created successfully.', 'success');
        
        return redirect()->route('admin.location.view', $location->id);
    }

    /**
     * Delete a location
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $location = $this->locationRepository->find($request->input('id'));
        $location->delete();

        flash('The location has been deleted successfully.', 'success')->important();

        return redirect()->route('admin.location.index');
    }

    /**
     * Update location image
     *
     * @param UpdateImageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateImage(UpdateImageRequest $request)
    {
        $location = $this->uploadImage($request, null, $request->input('id'));

        flash('Location image has been updated.', 'success');

        return redirect()->route('admin.location.edit', $request->input('id'));
    }

    /**
     * Upload image
     *
     * @param mixed           $request
     * @param                 $location
     * @param string          $id
     * @return mixed
     */
    private function uploadImage($request, $location = null, $id = '')
    {
        $locationId = ($location != null ? $location->id : $id);

        if ($request->hasFile('avatar')) {
            $avatar   = $request->file('avatar');
            $filename = $locationId . '.' . $avatar->getClientOriginalExtension();

            Image::make($avatar)
                 ->resize(300, 300)
                 ->save(public_path('/uploads/locations/' . $filename));

            $location        = $this->locationRepository->find($locationId);
            $location->code  = 'location-' . $locationId;
            $location->image = $filename;
            $location->save();

            return $location;
        }

        return $location;
    }
    
    
}
