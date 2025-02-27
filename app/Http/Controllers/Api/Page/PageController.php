<?php

namespace App\Http\Controllers\Api\Page;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use ApiResponseTrait;

    public function about_us()
    {
        $about = Page::where('slug','about-us')->first();
        return $this->sendSuccessResponse($about,'success');
    }

    public function privacy_policy()
    {
        $policy = Page::where('slug','privacy-policy')->first();
        return $this->sendSuccessResponse($policy,'success');
    }

    public function terms()
    {
        $terms = Page::where('slug','terms-and-condition')->first();
        return $this->sendSuccessResponse($terms,'success');
    }
}
