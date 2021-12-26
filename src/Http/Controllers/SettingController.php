<?php

namespace Dawnstar\Core\Http\Controllers;


use Dawnstar\Core\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManagerStatic;

class SettingController extends BaseController
{
    public function index()
    {
        return view('Core::modules.setting.index');
    }

    public function modal(Request $request)
    {
        $groupKey = $request->get('group_key');
        $settings = Setting::where('group_key', $groupKey)->pluck('value', 'key')->toArray();

        return view('Core::modules.setting.modals.' . $groupKey, compact('settings'))->render();
    }

    public function update(Request $request)
    {
        $data = $request->except('_token', '_method', 'group_key');
        $groupKey = $request->get('group_key');

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                [
                    'website_id' => session('dawnstar.website.id'),
                    'group_key' => $groupKey,
                    'key' => $key
                ],
                [
                    'value' => $value
                ]
            );
        }

        Cache::forget('settings' . session('dawnstar.website.id'));

        return back();
    }

    public function imageQuality(Request $request)
    {
        $quality = $request->get('quality');

        $image = ImageManagerStatic::make(public_path("vendor/dawnstar/core/medias/sample.jpg"))->encode('jpg', $quality);
        $base64 = 'data:image/jpg;base64,' . base64_encode($image);
        $base64size = (int)(strlen(rtrim(('data:image/jpg;base64,' . base64_encode($base64)), '=')) * 3 / 4);
        return ['image' => $base64, 'size' => unitSizeForHuman($base64size * 190513 / 254058)];
    }
}
