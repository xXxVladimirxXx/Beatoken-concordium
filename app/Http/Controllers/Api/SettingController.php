<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        return response()->json(Setting::get()->pluck('value', 'key'), 200);
    }

    public function store(Request $request) {
        $settings = $request->all();
        if (!empty($settings)) {
            foreach ($settings as $key => $value) {
                $setting = Setting::where('key', $key)->first();
                if (empty($setting)) {
                     Setting::create([
                        'key'   => $key,
                        'value' => $value
                    ]);
                } else {
                    $setting->value = $value;
                    $setting->save();
                }
            }
        }
        return response()->json(Setting::get()->pluck('value', 'key'), 200);
    }

    public static function get($key) {
        $setting = Setting::where('key', $key)->first();
        return (!empty($setting)) ? $setting->value : null;
    }
}
