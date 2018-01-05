<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\DashboardRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $pageName = 'dashboard';
    /**
     * @var DashboardRepository
     */
    private $dashboardRepository;

    /**
     * DashboardController constructor.
     * @param DashboardRepository $dashboardRepository
     */
    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function dashboard()
    {
        $totalSales          = $this->dashboardRepository->totalSales();
        $totalSalesAndOrders = $this->dashboardRepository->totalOrdersAndSalesToday();
        $ordersRedeemed      = $this->dashboardRepository->ordersRedeemedToday();
        $drinksOrderedToday  = $this->dashboardRepository->drinksOrderedToday();
        $coversOrderedToday  = $this->dashboardRepository->coversOrderedToday();

        return view('admin.dashboard', [
            'pageName'           => $this->pageName,
            'salesToday'         => json_encode($totalSales),
            'totalSales'         => $totalSalesAndOrders->sale,
            'totalOrders'        => $totalSalesAndOrders->total,
            'ordersRedeemed'     => $ordersRedeemed->total,
            'drinksOrderedToday' => $drinksOrderedToday,
            'coversOrderedToday' => $coversOrderedToday
        ]);
    }
}
