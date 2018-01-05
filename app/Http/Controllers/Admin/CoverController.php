<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Cover\CreateCoverRequest;
use App\Http\Requests\Cover\UpdateCoverRequest;
use App\Repositories\CoverRepository;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;

class CoverController extends Controller
{
    private $pageName = 'cover';
    private $coverRepository;
    private $locationRepository;

    public function __construct(CoverRepository $coverRepository, LocationRepository $locationRepository)
    {
        $this->coverRepository    = $coverRepository;
        $this->locationRepository = $locationRepository;
    }

    public function index()
    {
        $covers = $this->coverRepository->index();

        return view('admin.cover.index', [
            'pageName' => $this->pageName,
            'covers'   => $covers
        ]);
    }

    /**
     * Display cover add page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $locations = $this->locationRepository->all();

        return view('admin.cover.add', [
            'pageName'  => $this->pageName,
            'locations' => $locations
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

        return redirect()->route('admin.cover.edit', $cover->id);
    }

    /**
     * Display cover edit page
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $cover     = $this->coverRepository->find($id);
        $locations = $this->locationRepository->all();

        return view('admin.cover.edit', [
            'pageName'  => $this->pageName,
            'cover'     => $cover,
            'locations' => $locations
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

        return redirect()->route('admin.cover.edit', $drink->id);
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

        return redirect()->route('admin.cover.index');
    }
}
