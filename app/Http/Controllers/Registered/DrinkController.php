<?php

namespace App\Http\Controllers\Registered;

use App\Repositories\DrinkRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class DrinkController extends Controller
{
	private $drinkRepository;

    public function __construct(DrinkRepository $drinkRepository)
    {
    	$this->$drinkRepository = $drinkRepository;	
    }
}
