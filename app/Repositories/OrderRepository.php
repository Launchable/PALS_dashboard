<?php namespace App\Repositories;

use App\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    /**
     * @var Order
     */
    private $order;

    /**
     * OrderRepository constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Show order by location of for user
     * @param $locationId
     * @param $subDay
     * @return
     */
    public function getDayByLocation($locationId, $subDay)
    {
        $startDate = Carbon::now()
                           ->subDay($subDay)
                           ->format('Y-m-d');
        $endDate   = Carbon::now()
                           ->format('Y-m-d');

        return $this->order->where('orders.location_id', $locationId)
                           ->whereBetween('orders.created_at', [
                               $startDate . " 00:00:00",
                               $endDate . " 23:59:59"
                           ])
                           ->leftJoin('drinks', 'orders.drink_id', '=', 'drinks.id')
                           ->leftJoin('covers', 'orders.cover_id', '=', 'covers.id')
                           ->select('drinks.title as drink', 'orders.id', 'orders.drink_id', 'orders.cover_id',
                               'covers.title as cover', 'orders.price',
                               'orders.created_at', 'orders.is_redeemed')
                           ->orderBy('created_at', 'desc')
                           ->get();
    }
    
    /**
     * Get total sales fo the day by location
     *
     * @param $locationId
     * @return array
     */
    public function salesTodayByLocation($locationId)
    {
        $results = DB::table('orders')
                     ->select(
                         DB::raw("DATE_FORMAT(orders.created_at, '%H:%i') as date"),
                         DB::raw('SUM(orders.price) as price')
                     )
                     ->where('orders.location_id', $locationId)
                     ->whereRaw('DATE(orders.created_at) = CURDATE()')
                     ->groupBy('date')
                     ->orderBy('orders.created_at')
                     ->get();

        $items = [];

        foreach ($results as $item) {
            $items[] = [
                Carbon::parse($item->date)
                      ->format('H:i'),
                floatval(number_format($item->price, 2, '.', '')),
                '$' . floatval(number_format($item->price, 2, '.', ''))
            ];
        }

        return $items;
    }

    /**
     * @param $locationId
     * @return mixed
     */
    public function totalOrdersAndSalesToday($locationId)
    {
        $results = DB::table('orders')
                     ->select(
                         DB::raw("COUNT(orders.id) as total"),
                         DB::raw('SUM(orders.price) as sale')
                     )
                     ->whereRaw('DATE(orders.created_at) = CURDATE()')
                     ->where('orders.location_id', $locationId)
                     ->first();

        return $results;
    }

    /**
     * Retrieve redeemed orders for the location today
     *
     * @param $locationId
     * @return mixed
     */
    public function ordersRedeemedToday($locationId)
    {
        $results = DB::table('orders')
                     ->select(
                         DB::raw("COUNT(orders.id) as total")
                     )
                     ->whereRaw('DATE(orders.created_at) = CURDATE()')
                     ->where('orders.location_id', $locationId)
                     ->where('orders.is_redeemed', 1)
                     ->first();

        return $results;
    }

    /**
     * Get drink orders today
     *
     * @param $locationId
     * @param $size
     * @return mixed
     */
    public function drinksOrderedToday($locationId, $size)
    {
        $results = DB::table('orders')
                     ->select('orders.id', 'orders.price', 'drinks.title', 'orders.created_at', 'orders.is_redeemed')
                     ->join('drinks', 'orders.drink_id', '=', 'drinks.id')
                     ->whereRaw('DATE(orders.created_at) = CURDATE()')
                     ->where('orders.location_id', $locationId)
                     ->take($size)
                     ->orderBy('orders.created_at')
                     ->get();

        return $results;
    }

    /**
     * Get covers orders today
     *
     * @param $locationId
     * @param $size
     * @return mixed
     */
    public function coversOrderedToday($locationId, $size)
    {
        $results = DB::table('orders')
                     ->select('orders.id', 'orders.price', 'covers.title', 'orders.created_at', 'orders.is_redeemed')
                     ->join('covers', 'orders.cover_id', '=', 'covers.id')
                     ->whereRaw('DATE(orders.created_at) = CURDATE()')
                     ->where('orders.location_id', $locationId)
                     ->orderBy('orders.created_at')
                     ->take($size)
                     ->get();

        return $results;
    }

}