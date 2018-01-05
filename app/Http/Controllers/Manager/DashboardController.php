<?php

namespace App\Http\Controllers\Manager;

use App\Location;
use App\Repositories\DashboardRepository;
use App\Repositories\LocationRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    private $pageName = 'dashboard';
    private $locationRepository;
    private $orderRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    
    /**
     * DashboardController constructor.
     * @param LocationRepository $locationRepository
     * @param OrderRepository    $orderRepository
     * @param UserRepository     $userRepository
     */
    public function __construct(LocationRepository $locationRepository,
        OrderRepository $orderRepository, UserRepository $userRepository)
    {
        $this->locationRepository = $locationRepository;
        $this->orderRepository    = $orderRepository;
        $this->userRepository     = $userRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard(Request $request)
    {
        $userLocations       = $this->userRepository->getUserLocations();
        $locationId          =
            ($request->isMethod('post')) ? request('location') : $userLocations->locations[0]->id;
        
        $salesToday          = $this->orderRepository->salesTodayByLocation($locationId);
        $totalSalesAndOrders = $this->orderRepository->totalOrdersAndSalesToday($locationId);
        $ordersRedeemed      = $this->orderRepository->ordersRedeemedToday($locationId);
        $drinksOrderedToday  = $this->orderRepository->drinksOrderedToday($locationId, 10);
        $coversOrderedToday  = $this->orderRepository->coversOrderedToday($locationId, 10);
        
        return view('manager.dashboard', [
            'pageName'           => $this->pageName,
            'locationId'         => $locationId,
            'locations'          => $userLocations,
            'salesToday'         => json_encode($salesToday),
            'totalSales'         => $totalSalesAndOrders->sale,
            'totalOrders'        => $totalSalesAndOrders->total,
            'ordersRedeemed'     => $ordersRedeemed->total,
            'drinksOrderedToday' => $drinksOrderedToday,
            'coversOrderedToday' => $coversOrderedToday
        ]);
    }
    
    private function topSaleToday()
    {
        
    }
}
