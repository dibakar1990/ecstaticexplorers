<?php

namespace App\Http\Controllers\Api\Blog;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $blogCollection = Blog::with('user','blog_tags','blog_category')->where('status',1)->latest()->get();
        $blogs = $blogCollection->map(function($item) {
            if($item->file_path != ''){
                $item->file_path = $item->file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($blogs,'success');
    }

    public function show($id)
    {
        $blog = Blog::with('user','blog_tags','blog_category')->findOrFail($id);
        return $this->sendSuccessResponse($blog,'success');
    }

    public function get_category()
    {
        $categoryCollection = BlogCategory::where('status',1)->latest()->get();
        $category = $categoryCollection->map(function($item) {
            if($item->file_path != ''){
                $item->file_path = $item->file_path_url;
            }
            $blogCount = Blog::where('blog_category_id',$item->id)->where('status',1)->count();
            $item->blog_count = $blogCount;
            return $item;
        });
        return $this->sendSuccessResponse($category,'success');
    }
}
