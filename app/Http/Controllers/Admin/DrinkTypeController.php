<?php

namespace App\Http\Controllers\Admin;

use App\DrinkType;
use App\Http\Controllers\ResponseController;
use App\Repositories\DrinkRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DrinkTypeController extends ResponseController
{
    private $pageName = 'drink.types';
    private $drinkRepository;
    
    public function __construct(DrinkRepository $drinkRepository)
    {
        $this->drinkRepository = $drinkRepository;
    }

    public function index()
    {
        return view('admin.drink.type', [
            'pageName' => $this->pageName
        ]);
    }

    /**
     * Display all types
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showTypes()
    {
        $types = $this->drinkRepository->drinkTypes();

        return view('admin.drink.ajax.types', [
            'types' => $types
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function addType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'color' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseWithError($validator->errors()
                                                      ->first());
        }

        if (!DrinkType::create($request->all())) {
            return $this->responseWithError('Error creating the type.');
        }

        return $this->responseWithSuccess('Type has been created successfully.');
    }

    public function editType(Request $request)
    {
        if (!$type = DrinkType::find($request->input('id'))) {
            return $this->responseWithError('Error retrieving type.');
        }

        return $this->response([
            'status' => 'OK',
            'type'   => $type
        ]);
    }

    public function updateType(Request $request)
    {
        $type = DrinkType::find($request->input('id'));
        $type->fill($request->all());
        $type->save();

        return $this->responseWithSuccess('Type has been updated.');
    }

    public function deleteType(Request $request)
    {
        $type = DrinkType::find($request->input('id'));
        $type->delete();

        return $this->responseWithSuccess('Type has been deleted.');
    }
}
