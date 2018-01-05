<?php

namespace App\Http\Controllers\Admin;

use App\Drink;
use App\DrinkType;
use App\Http\Requests\Drink\CreateDrinkRequest;
use App\Http\Requests\Drink\UpdateDrinkRequest;
use App\Location;
use App\Repositories\DrinkRepository;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DrinkController extends Controller
{
    private $pageName = 'drink';
    private $drinkRepository;
    private $locationRepository;

    public function __construct(DrinkRepository $drinkRepository, LocationRepository $locationRepository)
    {
        $this->drinkRepository    = $drinkRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * Display main drink page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $drinks = $this->drinkRepository->index();

        return view('admin.drink.index', [
            'pageName' => $this->pageName,
            'drinks'   => $drinks
        ]);
    }
    
    /**
     * Display add page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $locations = $this->locationRepository->all();
        $types     = $this->drinkRepository->drinkTypes();

        return view('admin.drink.add', [
            'pageName'  => $this->pageName,
            'locations' => $locations,
            'types'     => $types
        ]);
    }

    /**
     * Store a drink object
     *
     * @param CreateDrinkRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateDrinkRequest $request)
    {
        $drink = $this->drinkRepository->create($request);
        // Save product code
        $drink->code = 'drink-' . $drink->id;
        $drink->save();

        flash('Drink has been created successfully.', 'success');

        return redirect()->route('admin.drink.edit', $drink->id);
    }

    /**
     * Display drink edit page
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $drink     = $this->drinkRepository->find($id);
        $locations = $this->locationRepository->all();
        $types     = $this->drinkRepository->drinkTypes();

        return view('admin.drink.edit', [
            'pageName'  => $this->pageName,
            'drink'     => $drink,
            'locations' => $locations,
            'types'     => $types
        ]);
    }

    /**
     * Update a drink record
     *
     * @param UpdateDrinkRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateDrinkRequest $request)
    {
        $drink = $this->drinkRepository->update($request);

        flash('Drink has been updated successfully.', 'success');

        return redirect()->route('admin.drink.edit', $drink->id);

    }

    /**
     * Remove a drink
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $drink = $this->drinkRepository->find($request->input('id'));
        $drink->delete();

        flash('The drink has been deleted successfully.', 'success');

        return redirect()->route('admin.drink.index');
    }

}
