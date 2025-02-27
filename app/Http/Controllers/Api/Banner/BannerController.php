<?php

namespace App\Http\Controllers\Api\Banner;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        
        $bannerCollection = Banner::where('status',1)->latest()->get();
        $banners = $bannerCollection->map(function($item) {
            if($item->file_path != ''){
                $item->file_path = $item->file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($banners,'success');
    }
}
