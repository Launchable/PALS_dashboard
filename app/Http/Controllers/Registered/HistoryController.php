<?php

namespace App\Http\Controllers\Registered;

use App\Repositories\HistoryRepository;
use App\UserHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
    private $pageName = 'history';
    /**
     * @var HistoryRespository
     */
    private $historyRespository;

    public function __construct(HistoryRepository $historyRepository)
    {
        $this->historyRespository = $historyRepository;
    }

    public function index()
    {
        // Get today's history for drinks
        $drinksToday = $this->drinkHistory('DATE(history.created_at) = CURDATE()');
        // Get yesterdays history for drinks
        $drinksYesterday = $this->drinkHistory('DATE(history.created_at) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))');
        // Get other days drink history
        $drinksPast = $this->drinkHistory('DATE(history.created_at) < DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))');

        // Get today's history for covers
        $coversToday = $this->coverHistory('DATE(history.created_at) = CURDATE()');
        // Get yesterdays history for covers
        $coversYesterday = $this->coverHistory('DATE(history.created_at) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))');
        // Get other days drink history
        $coversPast = $this->coverHistory('DATE(history.created_at) < DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))');

        return view('registered.history', [
            'pageName'        => $this->pageName,
            'drinksToday'     => $drinksToday,
            'drinksYesterday' => $drinksYesterday,
            'drinksPast'      => $drinksPast,
            'coversToday'     => $coversToday,
            'coversYesterday' => $coversYesterday,
            'coversPast'      => $coversPast,
        ]);
    }

    /**
     * @param $where
     * @return array
     */
    private function drinkHistory($where)
    {
        $results = $this->historyRespository->drinks($where);
        $drinks  = [];

        foreach ($results as $item) {
            $drinks[$item->name]['drinks'][] = $item;
        }

        return $drinks;
    }

    /**
     * @param $where
     * @return array
     */
    private function coverHistory($where)
    {
        $results = $this->historyRespository->covers($where);
        $covers  = [];

        foreach ($results as $item) {
            $covers[$item->name]['covers'][] = $item;
        }

        return $covers;
    }
}
