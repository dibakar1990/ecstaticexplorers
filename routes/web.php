<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   //return view('admin.auth.login');
    return redirect()->to('admin/login');
});


    
Route::get('storage-link', function () {
    
    \Artisan::call('storage:link');
   
});