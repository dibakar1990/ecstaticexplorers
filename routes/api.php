<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\Banner\BannerController;
use App\Http\Controllers\Api\Blog\BlogController;
use App\Http\Controllers\Api\Contact\ContactController;
use App\Http\Controllers\Api\Homestay\HomeStayController;
use App\Http\Controllers\Api\Page\PageController;
use App\Http\Controllers\Api\Pakage\PakageController;
use App\Http\Controllers\Api\Setting\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');
Route::post('registration',[RegistrationController::class,'register'])->name('register');
Route::post('login',[LoginController::class,'login'])->name('login');

Route::get('get-trending-states', [PakageController::class, 'getTrendingStates']); 
Route::get('get-explore-by-states', [PakageController::class, 'getExploreByStates']); 
Route::get('get-explore-the-unexplored-states', [PakageController::class, 'getExploreTheUnexploredStates']);
  
Route::get('banners',[BannerController::class,'index']);
Route::get('blogs',[BlogController::class,'index']);
Route::get('blog/{id}',[BlogController::class,'show']);
Route::get('blog-category',[BlogController::class,'get_category']);
Route::get('setting',[SettingController::class,'index']);
Route::get('social-link',[SettingController::class,'social_link']);

Route::get('categories',[PakageController::class,'get_category']);
Route::get('cities',[PakageController::class,'get_city']);
Route::get('city-details/{id}',[PakageController::class,'get_city_details']);
Route::get('top-destination',[PakageController::class,'get_top_city']);
Route::get('states',[PakageController::class,'get_state']);
Route::get('state-info',[PakageController::class,'get_state_info']);
Route::get('gallery',[PakageController::class,'get_gallery']);
Route::get('top-selling-pakages',[PakageController::class,'top_selling']);
Route::get('themes',[PakageController::class,'get_theme']);
Route::get('pakages',[PakageController::class,'get_pakage']);
Route::get('pakages-with-category/{id}',[PakageController::class,'get_pakage_with_category']);
Route::get('pakage/details/{id}',[PakageController::class,'show']); 
Route::get('related-package-with-city/{id}',[PakageController::class,'get_package_with_city']);
Route::get('related-package-with-state/{id}',[PakageController::class,'get_package_with_state']);
Route::get('cities',[PakageController::class,'get_city_with_pakage']);

Route::get('pakages-with-city/{id}', [PakageController::class,'packageWithCity']);
Route::get('pakages-with-theme/{id}', [PakageController::class,'packageWithTheme']);
Route::get('pakages-with-price/{data}', [PakageController::class,'packageWithPrice']);
Route::get('pakages-with-state/{id}', [PakageController::class,'packageWithState']);
Route::get('pakages-with-duration/{data}', [PakageController::class,'packageWithDuration']);
    
Route::get('pakage/itinerary/{id}/{type}', [PakageController::class, 'tourItinerary']); 

Route::get('search/pakage',[PakageController::class,'search_pakage']);

Route::get('do',[PakageController::class,'get_do']);
Route::get('dont',[PakageController::class,'get_dont']);

Route::get('about-us',[PageController::class,'about_us']);
Route::get('privacy-policy',[PageController::class,'privacy_policy']);
Route::get('terms-and-condition',[PageController::class,'terms']);


Route::post('contact-us',[ContactController::class,'store']);
Route::post('news-letter',[ContactController::class,'news_letter_store']);

Route::get('state-wise-homestay/{state_id}',[HomeStayController::class,'index']);
Route::get('location-wise-homestay/{location_id}',[HomeStayController::class,'location_wise_homestay']);
Route::get('locations',[HomeStayController::class,'get_location']);
Route::get('homestay/details/{id}',[HomeStayController::class,'homestay_details']);

Route::middleware('auth:api')->group( function () {
    Route::get('/profile', [LoginController::class, 'profile']);
    Route::get('/logout', [LoginController::class, 'logout']);
});
