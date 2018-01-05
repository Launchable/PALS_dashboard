<?php namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    public function totalSales()
    {
        $results = DB::table('orders')
                     ->select(
                         DB::raw("DATE_FORMAT(orders.created_at, '%H:%i') as date"),
                         DB::raw('SUM(orders.price) as total')
                     )
                     ->whereRaw('DATE(orders.created_at) = CURDATE()')
                     ->groupBy('date')
                     ->orderBy('orders.created_at')
                     ->get();

        $items = [];

        foreach ($results as $item) {
            $items[] = [
                Carbon::parse($item->date)
                      ->format('H:i'),
                floatval(number_format($item->total, 2, '.', '')),
                '$' . number_format($item->total, 2, '.', ''),
            ];
        }

        return $items;

    }

    /**
     * @param $locationId
     * @return mixed
     */
    public function totalOrdersAndSalesToday()
    {
        $results = DB::table('orders')
                     ->select(
                         DB::raw("COUNT(orders.id) as total"),
                         DB::raw('SUM(orders.price) as sale')
                     )
                     ->whereRaw('DATE(orders.created_at) = CURDATE()')
                     ->first();

        return $results;
    }

    /**
     * Retrieve redeemed orders for the location today
     *
     * @param $locationId
     * @return mixed
     */
    public function ordersRedeemedToday()
    {
        $results = DB::table('orders')
                     ->select(
                         DB::raw("COUNT(orders.id) as total")
                     )
                     ->whereRaw('DATE(orders.created_at) = CURDATE()')
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
    public function drinksOrderedToday()
    {
        $results = DB::table('orders')
                     ->select('orders.id', 'orders.price', 'drinks.title', 'orders.created_at', 'orders.is_redeemed')
                     ->join('drinks', 'orders.drink_id', '=', 'drinks.id')
                     ->whereRaw('DATE(orders.created_at) = CURDATE()')
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
    public function coversOrderedToday()
    {
        $results = DB::table('orders')
                     ->select('orders.id', 'orders.price', 'covers.title', 'orders.created_at', 'orders.is_redeemed')
                     ->join('covers', 'orders.cover_id', '=', 'covers.id')
                     ->whereRaw('DATE(orders.created_at) = CURDATE()')
                     ->orderBy('orders.created_at')
                     ->get();

        return $results;
    }

    /**
     * Get all the
     *
     * @param $locationId
     * @return array
     */
    public function dailyRegisteredUsers()
    {
        $results = DB::table('users')
                     ->select(
                         DB::raw("DATE(users.created_at) as date"),
                         DB::raw('COUNT(*) as total')
                     )
                     ->whereRaw('DATE(users.created_at) = CURDATE()')
                     ->groupBy('date')
                     ->orderBy('users.created_at')
                     ->get();

        $items = [];

        foreach ($results as $item) {
            $items[] = [
                Carbon::parse($item->date)
                      ->format('H:i'),
                (int)$item->total,
                $item->total . ' Users',
            ];
        }

        return $items;
    }

}