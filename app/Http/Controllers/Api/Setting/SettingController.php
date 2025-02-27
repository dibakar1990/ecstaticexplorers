<?php

namespace App\Http\Controllers\Api\Setting;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SocialMediaLink;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $setting = Setting::first();
        if($setting->file_path !=''){
            $setting->file_path = $setting->file_path_url;
        }
        if($setting->file_path_fav_icon != ''){
            $setting->file_path_fav_icon = $setting->file_path_fav_url;
        }

        return $this->sendSuccessResponse($setting,'success');
    }

    public function social_link()
    {
        $socials = SocialMediaLink::where('status',1)->latest()->get();
        return $this->sendSuccessResponse($socials,'success');
    }
}
