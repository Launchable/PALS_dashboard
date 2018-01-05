<?php namespace App\Repositories;

use App\UserHistory;
use Illuminate\Support\Facades\DB;

class HistoryRepository
{
    private $history;

    /**
     * HistoryRespository constructor.
     * @param UserHistory $history
     */
    public function __construct(UserHistory $history)
    {
        $this->history = $history;
    }

    public function drinks($whereRaw)
    {
        return DB::table('user_histories as history')
                 ->join('drinks', 'history.drink_id', '=', 'drinks.id')
                 ->join('locations', 'drinks.location_id', '=', 'locations.id')
                 ->select('drinks.title', 'locations.name', 'history.price', 'history.created_at')
                 ->orderBy('history.created_at', 'DESC')
                 ->whereRaw($whereRaw)
                 ->where('history.drink_id', '<>', 0)
                 ->get();
    }

    public function covers($whereRaw)
    {
        return DB::table('user_histories as history')
                 ->join('covers', 'history.cover_id', '=', 'covers.id')
                 ->join('locations', 'covers.location_id', '=', 'locations.id')
                 ->select('covers.title', 'locations.name', 'history.price', 'history.created_at')
                 ->orderBy('history.created_at', 'DESC')
                 ->whereRaw($whereRaw)
                 ->where('history.cover_id', '<>', 0)
                 ->get();
    }

}