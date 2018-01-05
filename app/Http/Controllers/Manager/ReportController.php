<?php

namespace App\Http\Controllers\Manager;

use App\Repositories\ReportRepository;
use App\Repositories\UserRepository;
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
     * @var UserRepository
     */
    private $userRepository;
    
    /**
     * ReportController constructor.
     * @param ReportRepository $reportRepository
     * @param UserRepository   $userRepository
     */
    public function __construct(ReportRepository $reportRepository, UserRepository $userRepository)
    {
        $this->reportRepository = $reportRepository;
        $this->userRepository   = $userRepository;
    }
    
    public function index(Request $request)
    {
        $startDate = Carbon::now()
                           ->subDay(10)
                           ->format('Y-m-d');
        $endDate   = Carbon::now()
                           ->format('Y-m-d');

        $userLocations = $this->userRepository->getUserLocations();
        $locationId    =
            ($request->isMethod('post')) ? request('location') : $userLocations->locations[0]->id;

        // If we have a submitted form
        if ($request->isMethod('post')) {
            $startDate = $request->input('from');
            $endDate   = $request->input('to');
        }


        // Switch between report
        switch ($request->input('report')) {
            case 'totalOrders':
                $data    = $this->reportRepository->totalOrders($locationId, $startDate, $endDate);
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
                $data    = $this->reportRepository->avgPerDay($locationId, $startDate, $endDate);
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
                $data    = $this->reportRepository->topPurchased($locationId, $startDate, $endDate);
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
                $data    = $this->reportRepository->totalPurchased($locationId, $startDate, $endDate);
                $options = [
                    'title'  => 'Total Purchased',
                    'colors' => [
                        '#51179e',
                        '#2961bc'
                    ],
                    'vAxis'  => [
                        'minValue' => 0,
                        'title'    => 'Total'
                    ]
                ];
                break;
            case 'totalRedeemed':
                $data    = $this->reportRepository->totalRedeemed($locationId, $startDate, $endDate);
                $options = [
                    'title'  => 'Total Redeemed',
                    'colors' => [
                        '#51179e',
                        '#2961bc'
                    ],
                    'vAxis'  => [
                        'minValue' => 0,
                        'title'    => 'Total'
                    ]
                ];
                break;
            case 'busiestDay';
                $data    = $this->reportRepository->busiestDay($locationId, $startDate, $endDate);
                $options = [
                    'title'  => 'Busiest Day',
                    'colors' => [
                        '#51179e',
                        '#2961bc'
                    ],
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

        return view('manager.report.index', [
            'pageName'   => $this->pageName,
            'start'      => $startDate,
            'end'        => $endDate,
            'locationId' => $locationId,
            'locations'  => $userLocations->locations,
            'data'       => json_encode($data),
            'options'    => json_encode($options),
            'orders'     => $orders
        ]);
    }
}
