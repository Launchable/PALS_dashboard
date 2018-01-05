<?php

namespace App\Http\Controllers\Manager;

use App\Drink;
use App\DrinkType;
use App\Http\Requests\Drink\CreateDrinkRequest;
use App\Http\Requests\Drink\UpdateDrinkRequest;
use App\Location;
use App\Repositories\DrinkRepository;
use App\Repositories\LocationRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DrinkController extends Controller
{
    private $pageName = 'drink';
    private $drinkRepository;
    private $locationRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    
    /**
     * DrinkController constructor.
     * @param DrinkRepository    $drinkRepository
     * @param LocationRepository $locationRepository
     * @param UserRepository     $userRepository
     */
    public function __construct(DrinkRepository $drinkRepository, LocationRepository $locationRepository,
        UserRepository $userRepository)
    {
        $this->drinkRepository    = $drinkRepository;
        $this->locationRepository = $locationRepository;
        $this->userRepository     = $userRepository;
    }
    
    /**
     * Display main drink page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $userLocations = $this->userRepository->getUserLocations();
        $locationId    =
            ($request->isMethod('post')) ? request('location') : $userLocations->locations[0]->id;
        $drinks        = $this->drinkRepository->findByLocationId($locationId);

        return view('manager.drink.index', [
            'pageName'   => $this->pageName,
            'locationId' => $locationId,
            'locations'  => $userLocations,
            'drinks'     => $drinks
        ]);
    }
    
    /**
     * Display add page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $userLocations = $this->userRepository->getUserLocations();
        $types         = $this->drinkRepository->drinkTypes();
        
        return view('manager.drink.add', [
            'pageName'  => $this->pageName,
            'locations' => $userLocations->locations,
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
        
        return redirect()->route('manager.drink.edit', $drink->id);
    }
    
    /**
     * Display drink edit page
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (!$drink = $this->drinkRepository->find($id)) {
            return redirect()->back();
        }

        $userLocations = $this->userRepository->getUserLocations();
        $types         = $this->drinkRepository->drinkTypes();
        
        return view('manager.drink.edit', [
            'pageName'  => $this->pageName,
            'drink'     => $drink,
            'locations' => $userLocations->locations,
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
        
        return redirect()->route('manager.drink.edit', $drink->id);
        
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
        
        return redirect()->route('manager.drink.index');
    }
    
}
