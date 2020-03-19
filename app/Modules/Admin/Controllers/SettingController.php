<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Setting;

class SettingController extends AdminController
{

    public function index()
    {
        return view('Admin::setting.index');
    }

    public function indexStore(Request $request)
    {
        $settings = $request->input('settings', []);

        foreach ($settings as $setting => $value) {
            if (!is_null($value)) {
                setting([$setting => $value]);
            }
        }

        setting()->save();

        return back();
    }
}