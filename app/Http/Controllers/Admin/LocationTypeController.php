<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResponseController;
use App\Http\Helpers;
use App\Repositories\LocationRepository;
use App\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LocationTypeController extends ResponseController
{
    private $pageName = 'location.types';
    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * LocationTypeController constructor.
     * @param LocationRepository $locationRepository
     */
    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function index()
    {
        return view('admin.location.type', [
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
        $types = $this->locationRepository->locationTypes();

        return view('admin.location.ajax.types', [
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
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseWithError($validator->errors()
                                                      ->first());
        }

        if (!Type::create($request->all())) {
            return $this->responseWithError('Error creating the type.');
        }

        return $this->responseWithSuccess('Type has been created successfully.');
    }

    public function editType(Request $request)
    {
        if (!$type = Type::find($request->input('id'))) {
            return $this->responseWithError('Error retrieving type.');
        }

        return $this->response([
            'status' => 'OK',
            'type'   => $type
        ]);
    }

    public function updateType(Request $request)
    {
        $type = Type::find($request->input('id'));
        $type->fill($request->all());
        $type->save();

        return $this->responseWithSuccess('Type has been updated.');
    }

    public function deleteType(Request $request)
    {
        $type = Type::find($request->input('id'));
        $type->delete();

        return $this->responseWithSuccess('Type has been deleted.');
    }
}
