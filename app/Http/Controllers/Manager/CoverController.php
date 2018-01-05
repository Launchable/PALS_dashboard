<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests\Cover\CreateCoverRequest;
use App\Http\Requests\Cover\UpdateCoverRequest;
use App\Repositories\CoverRepository;
use App\Repositories\LocationRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class CoverController extends Controller
{
    private $pageName = 'cover';
    private $coverRepository;
    private $locationRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * CoverController constructor.
     * @param CoverRepository    $coverRepository
     * @param LocationRepository $locationRepository
     * @param UserRepository     $userRepository
     */
    public function __construct(CoverRepository $coverRepository, LocationRepository $locationRepository,
UserRepository $userRepository)
    {
        $this->coverRepository    = $coverRepository;
        $this->locationRepository = $locationRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $userLocations = $this->userRepository->getUserLocations();
        $locationId    =
            ($request->isMethod('post')) ? request('location') : $userLocations->locations[0]->id;
        $covers        = $this->coverRepository->findByLocationId($locationId);

        return view('manager.cover.index', [
            'pageName'   => $this->pageName,
            'locationId' => $locationId,
            'locations'  => $userLocations,
            'covers'     => $covers
        ]);
    }

    /**
     * Display cover add page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $userLocations = $this->userRepository->getUserLocations();

        return view('manager.cover.add', [
            'pageName'  => $this->pageName,
            'locations' => $userLocations->locations
        ]);
    }
    
    /**
     * Store a cover
     *
     * @param CreateCoverRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCoverRequest $request)
    {
        $cover = $this->coverRepository->create($request);
        // Save product code
        $cover->code = 'cover-' . $cover->id;
        $cover->save();
        flash('Cover has been created successfully.', 'success');

        return redirect()->route('manager.cover.edit', $cover->id);
    }

    /**
     * Display cover edit page
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (!$cover = $this->coverRepository->find($id)) {
            return redirect()->back();
        }

        $userLocations = $this->userRepository->getUserLocations();

        return view('manager.cover.edit', [
            'pageName'  => $this->pageName,
            'cover'     => $cover,
            'locations' => $userLocations->locations
        ]);

    }
    
    /**
     * Update a cover
     *
     * @param UpdateCoverRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCoverRequest $request)
    {
        $drink = $this->coverRepository->update($request);

        flash('Cover has been updated successfully.', 'success');

        return redirect()->route('manager.cover.edit', $drink->id);
    }

    /**
     * Delete a cover
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $cover = $this->coverRepository->find($request->input('id'));
        $cover->delete();

        flash('Cover has been deleted successfully', 'success');

        return redirect()->route('manager.cover.index');
    }

}
