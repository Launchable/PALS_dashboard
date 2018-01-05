<?php

namespace App\Http\Controllers\Admin;

use App\AppSetting;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppSetting\AppSettingRequest;
use App\Repositories\AppSettingRepository;

class AppController extends Controller
{
    private $settingRepository;

    private $pageName = 'App Settings';

    public function __construct(AppSettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * Show add user page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('admin.settings.edit', [
            'pageName' => $this->pageName,
            'appSetting' => AppSetting::first()
        ]);
    }

    /**
     * Save a user record
     *
     * @param AppSettingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AppSettingRequest $request)
    {
        // Create new user record
        $this->settingRepository->update($request);

        flash('Setting has been updated successfully', 'success');

        return redirect()->back();
    }
}
