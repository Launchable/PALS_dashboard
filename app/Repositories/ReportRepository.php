<?php namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class  ReportRepository
{
    public function ordersByDateRange($locationId, $startDate, $endDate)
    {
        $results = DB::table('orders')
                     ->where('orders.location_id', $locationId)
                     ->whereBetween('orders.created_at', [
                         $startDate . " 00:00:00",
                         $endDate . " 23:59:59"
                     ])
                     ->leftJoin('drinks', 'orders.drink_id', '=', 'drinks.id')
                     ->leftJoin('covers', 'orders.cover_id', '=', 'covers.id')
                     ->join('users', 'orders.user_id', '=', 'users.id')
                     ->select('users.username', 'drinks.title as drink', 'orders.id', 'orders.drink_id',
                         'orders.cover_id',
                         'covers.title as cover', 'orders.price',
                         'orders.created_at', 'orders.is_redeemed')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return $results;
    }

    /**
     * Get the total drinks and covers sold and total daily sales
     *
     * @param $locationId
     * @param $startDate
     * @param $endDate
     * @return array
     */
    public function totalSales($locationId, $startDate, $endDate)
    {
        $results = DB::table('orders')
                     ->select(
                         DB::raw('DATE(orders.created_at) as date'),
                         #DB::raw('count(orders.id) as total'),
                         DB::raw('SUM(orders.price) as price')
                     #DB::raw('AVG(orders.price) as average')
                     )
                     ->where('orders.location_id', $locationId)
                     ->whereBetween('orders.created_at', [
                         $startDate . " 00:00:00",
                         $endDate . " 23:59:59"
                     ])
                     ->groupBy('date')
                     ->orderBy('orders.created_at')
                     ->get();

        $items = [];

        foreach ($results as $item) {
            $items[]['c'] = [
                [
                    'v' => Carbon::parse($item->date)
                                 ->format('M. d'),
                    'f' => null
                ],
                [
                    'v' => floatval(number_format($item->price, 2, '.', '')),
                    'f' => null
                ]
            ];
        }

        $labels = [
            'Date'   => 'string',
            'Sale $' => 'number',
        ];

        return $this->formatData($items, $labels);
    }

    /**
     * Get total orders
     *
     * @param $locationId
     * @param $startDate
     * @param $endDate
     * @return array
     */
    public function totalOrders($locationId, $startDate, $endDate)
    {
        $results = DB::table('orders')
                     ->select(
                         DB::raw('DATE(orders.created_at) as date'),
                         DB::raw('COUNT(orders.id) as total')
                     )
                     ->where('orders.location_id', $locationId)
                     ->whereBetween('orders.created_at', [
                         $startDate . " 00:00:00",
                         $endDate . " 23:59:59"
                     ])
                     ->groupBy('date')
                     ->orderBy('orders.created_at')
                     ->get();

        $items = [];

        foreach ($results as $item) {
            $items[]['c'] = [
                [
                    'v' => Carbon::parse($item->date)
                                 ->format('M. d'),
                    'f' => null
                ],
                [
                    'v' => intval($item->total),
                    'f' => null
                ]
            ];
        }

        $labels = [
            'Date'  => 'string',
            'Total' => 'number',
        ];

        return $this->formatData($items, $labels);

    }

    /**
     * Get average spent
     *
     * @param $locationId
     * @param $startDate
     * @param $endDate
     * @return array
     */
    public function avgPerDay($locationId, $startDate, $endDate)
    {
        $results = DB::table('orders')
                     ->select(
                         DB::raw('DATE(orders.created_at) as date'),
                         DB::raw('AVG(orders.price) as average')
                     )
                     ->where('orders.location_id', $locationId)
                     ->whereBetween('orders.created_at', [
                         $startDate . " 00:00:00",
                         $endDate . " 23:59:59"
                     ])
                     ->groupBy('date')
                     ->orderBy('orders.created_at')
                     ->get();

        $items = [];

        foreach ($results as $item) {
            $items[]['c'] = [
                [
                    'v' => Carbon::parse($item->date)
                                 ->format('M. d'),
                    'f' => null
                ],
                [
                    'v' => floatval(number_format($item->average, 2, '.', '')),
                    'f' => null
                ]
            ];
        }

        $labels = [
            'Date'      => 'string',
            'Average $' => 'number',
        ];

        return $this->formatData($items, $labels);

    }

    /**
     * Get top most purchased drinks
     *
     * @param     $locationId
     * @param     $startDate
     * @param     $endDate
     * @param int $limit
     * @return array
     */
    public function topPurchased($locationId, $startDate, $endDate, $limit = 10)
    {
        $results = DB::table('orders')
                     ->select(
                         'drinks.title',
                         DB::raw('count(orders.drink_id) as total')
                     )
                     ->join('drinks', 'orders.drink_id', '=', 'drinks.id')
                     ->where('orders.location_id', $locationId)
                     ->whereBetween('orders.created_at', [
                         $startDate . " 00:00:00",
                         $endDate . " 23:59:59"
                     ])
                     ->groupBy('drinks.title')
                     ->orderBy('drinks.title')
                     ->take($limit)
                     ->get();

        $items = [];
        
        foreach ($results as $item) {
            $items[]['c'] = [
                [
                    'v' => $item->title,
                    'f' => null
                ],
                [
                    'v' => intval($item->total),
                    'f' => null
                ]
            ];
        }

        $labels = [
            'Drink' => 'string',
            'Total' => 'number',
        ];

        return $this->formatData($items, $labels);

    }

    /**
     * Get total drinks and covers purchased
     *
     * @param $locationId
     * @param $startDate
     * @param $endDate
     * @return array
     */
    public function totalPurchased($locationId, $startDate, $endDate)
    {
        $results = DB::table('orders')
                     ->select(
                         DB::raw('DATE(orders.created_at) as date'),
                         DB::raw('count(orders.drink_id) as drinkTotal'),
                         DB::raw('count(orders.cover_id) as coverTotal')
                     )
                     ->where('orders.location_id', $locationId)
                     ->whereBetween('orders.created_at', [
                         $startDate . " 00:00:00",
                         $endDate . " 23:59:59"
                     ])
                     ->groupBy('date')
                     ->orderBy('orders.created_at')
                     ->get();

        $items = [];

        foreach ($results as $item) {
            $items[]['c'] = [
                [
                    'v' => Carbon::parse($item->date)
                                 ->format('M. d'),
                    'f' => null
                ],
                [
                    'v' => intval($item->drinkTotal),
                    'f' => null
                ],
                [
                    'v' => intval($item->coverTotal),
                    'f' => null
                ]

            ];
        }

        $labels = [
            'Date'   => 'string',
            'Drinks' => 'number',
            'Covers' => 'number',
        ];

        return $this->formatData($items, $labels);
    }

    /**
     * @param $locationId
     * @param $startDate
     * @param $endDate
     * @return array
     */
    public function totalRedeemed($locationId, $startDate, $endDate)
    {
        $results = DB::table('orders')
                     ->select(
                         DB::raw('DATE(orders.created_at) as date'),
                         DB::raw('count(orders.drink_id) as drinkTotal'),
                         DB::raw('count(orders.cover_id) as coverTotal')
                     )
                     ->where('orders.location_id', $locationId)
                     ->where('orders.is_redeemed', 1)
                     ->whereBetween('orders.created_at', [
                         $startDate . " 00:00:00",
                         $endDate . " 23:59:59"
                     ])
                     ->groupBy('date')
                     ->orderBy('orders.created_at')
                     ->get();

        $items = [];

        foreach ($results as $item) {
            $items[]['c'] = [
                [
                    'v' => Carbon::parse($item->date)
                                 ->format('M. d'),
                    'f' => null
                ],
                [
                    'v' => intval($item->drinkTotal),
                    'f' => null
                ],
                [
                    'v' => intval($item->coverTotal),
                    'f' => null
                ]

            ];
        }

        $labels = [
            'Date'   => 'string',
            'Drinks' => 'number',
            'Covers' => 'number',
        ];

        return $this->formatData($items, $labels);
    }


    public function busiestDay($locationId, $startDate, $endDate)
    {
        $results = DB::table('orders')
                     ->select(
                         DB::raw('DAYNAME(orders.created_at) as day'),
                         DB::raw('count(orders.id) as total')
                     )
                     ->where('orders.location_id', $locationId)
                     ->whereBetween('orders.created_at', [
                         $startDate . " 00:00:00",
                         $endDate . " 23:59:59"
                     ])
                     ->groupBy('day')
                     ->orderBy('day')
                     ->get();

        $items = [];

        foreach ($results as $item) {
            $items[$item->day] = $item->total;
        }

        $arr2     = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ];
        $newItems = [];

        foreach ($arr2 as $v) {
            if (array_key_exists($v, $items)) {
                $newItems[]['c'] = [
                    [
                        'v' => $v,
                        'f' => null
                    ],
                    [
                        'v' => $items[$v],
                        'f' => null
                    ]
                ];
            }
        }

        $labels = [
            'Day'   => 'string',
            'Total' => 'number',
        ];

        return $this->formatData($newItems, $labels);

    }


    /**
     * @param $items
     * @return array
     */
    private function formatData($items, $labels)
    {
        $cols = [];
        $i    = 0;

        foreach ($labels as $key => $type) {
            $cols[$i]['label'] = $key;
            $cols[$i]['type']  = $type;
            $i++;
        }

        return [
            'cols' => $cols,
            'rows' => $items
        ];
    }
}