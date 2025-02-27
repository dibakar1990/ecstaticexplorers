<?php

namespace App\Http\Controllers;

use App\YoutubeVideoResponseTrait;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    use YoutubeVideoResponseTrait;

    public function index()
    {
        $videos = $this->videoLists();
        return view('watch',compact('videos'));
    }
}
