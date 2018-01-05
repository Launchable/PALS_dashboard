<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\LocationRepository;
use App\Repositories\ReportRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    private $pageName = 'report';
    /**
     * @var ReportRepository
     */
    private $reportRepository;
    /**
     * @var LocationRepository
     */
    private $locationRepository;
    
    /**
     * ReportController constructor.
     * @param ReportRepository   $reportRepository
     * @param LocationRepository $locationRepository
     */
    public function __construct(ReportRepository $reportRepository, LocationRepository $locationRepository)
    {
        $this->reportRepository   = $reportRepository;
        $this->locationRepository = $locationRepository;
    }
    
    public function index(Request $request)
    {
        $startDate = Carbon::now()
                           ->subDay(10)
                           ->format('Y-m-d');
        $endDate   = Carbon::now()
                           ->format('Y-m-d');

        $locationId = 1; // Set location to 1
        // If we have a submitted form
        if ($request->isMethod('post')) {
            $location   = $this->locationRepository->find($request->input('location'));
            $startDate  = $request->input('from');
            $endDate    = $request->input('to');
            $locationId = $location->id;
        }

        $locations = $this->locationRepository->all();

        // Switch between report
        switch ($request->input('report')) {
            case 'totalOrders':
                $data = $this->reportRepository->totalOrders($locationId, $startDate, $endDate);
                $options = [
                    'title'  => 'Total Orders',
                    'colors' => ['#51179e'],
                    'vAxis'  => [
                        'minValue' => 0,
                        'title'    => 'Total'
                    ]
                ];
                break;
            case 'averageSpent':
                $data = $this->reportRepository->avgPerDay($locationId, $startDate, $endDate);
                $options = [
                    'title'  => 'Average Spent',
                    'colors' => ['#51179e'],
                    'vAxis'  => [
                        'minValue' => 0,
                        'title'    => 'Dollars (USD)'
                    ]
                ];
                break;
            case 'mostPurchaseDrinks':
                $data = $this->reportRepository->topPurchased($locationId, $startDate, $endDate);
                $options = [
                    'title'  => 'Most Purchase Drinks',
                    'colors' => ['#51179e'],
                    'vAxis'  => [
                        'minValue' => 0,
                        'title'    => 'Total'
                    ]
                ];
                break;
            case 'totalPurchase';
                $data = $this->reportRepository->totalPurchased($locationId, $startDate, $endDate);
                $options = [
                    'title'  => 'Total Purchased',
                    'colors' => ['#51179e', '#2961bc'],
                    'vAxis'  => [
                        'minValue' => 0,
                        'title'    => 'Total'
                    ]
                ];
                break;
            case 'totalRedeemed':
                $data = $this->reportRepository->totalRedeemed($locationId, $startDate, $endDate);
                $options = [
                    'title'  => 'Total Redeemed',
                    'colors' => ['#51179e', '#2961bc'],
                    'vAxis'  => [
                        'minValue' => 0,
                        'title'    => 'Total'
                    ]
                ];
                break;
            case 'busiestDay';
                $data = $this->reportRepository->busiestDay($locationId, $startDate, $endDate);
                $options = [
                    'title'  => 'Busiest Day',
                    'colors' => ['#51179e', '#2961bc'],
                    'vAxis'  => [
                        'minValue' => 0,
                        'title'    => 'Total'
                    ]
                ];
                break;
            default:
                $data    = $this->reportRepository->totalSales($locationId, $startDate, $endDate);
                $options = [
                    'title'  => 'Total Sales',
                    'colors' => ['#51179e'],
                    'vAxis'  => [
                        'minValue' => 0,
                        'title'    => 'Dollars (USD)'
                    ]
                ];
                break;
        }

        $orders = $this->reportRepository->ordersByDateRange($locationId, $startDate, $endDate);

        return view('admin.report.index', [
            'pageName'   => $this->pageName,
            'start'      => $startDate,
            'end'        => $endDate,
            'locations'  => $locations,
            'locationId' => $locationId,
            'data'       => json_encode($data),
            'options'    => json_encode($options),
            'orders'     => $orders
        ]);
    }
}
