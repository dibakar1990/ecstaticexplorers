<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Banner\BannerController;
use App\Http\Controllers\Admin\Blog\BlogCategoryController;
use App\Http\Controllers\Admin\Blog\BlogController;
use App\Http\Controllers\Admin\Blog\TagController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\City\CityController;
use App\Http\Controllers\Admin\CMS\DoController;
use App\Http\Controllers\Admin\CMS\DontController;
use App\Http\Controllers\Admin\CMS\PageController;
use App\Http\Controllers\Admin\Contact\ContactController;
use App\Http\Controllers\Admin\Contact\NewsLetterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Gallery\GalleryController;
use App\Http\Controllers\Admin\Language\LanguageController;
use App\Http\Controllers\Admin\Location\LocationController;
use App\Http\Controllers\Admin\Pakage\PakageController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\Setting\SocialController;
use App\Http\Controllers\Admin\State\StateController;
use App\Http\Controllers\Admin\Stay\HomeStayController;
use App\Http\Controllers\Admin\Theme\ThemeController;
use App\Http\Controllers\Admin\Type\TypeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'admin.guest'],function () {
    Route::match(['get', 'head'], 'login', [LoginController::class,'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class,'login'])->name('login.submit');

    Route::match(['get', 'head'], 'password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
    Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
    Route::match(['get', 'head'], 'password/reset', [ForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');
    Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');
});

Route::group(['middleware' => 'admin.auth'],function () {
    Route::get('logout', [LoginController::class,'logout'])->name('logout');
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');

    Route::resource('profile',ProfileController::class)->only('index','update');
    Route::get('change/password',[ProfileController::class,'change_password'])->name('change.password');
    Route::post('update/password/{id}',[ProfileController::class,'update_password'])->name('update.password');
    Route::post('theme/style/store',[ProfileController::class,'theme_style_store'])->name('theme.style.store');
    //Banner Manage
    Route::resource('banners',BannerController::class)->only('index','create','store','edit','update','destroy');
    Route::post('banner/status',[BannerController::class,'status'])->name('banner.status');
    Route::post('banner/action',[BannerController::class,'action'])->name('banner.action');
    //Blog Manage
    Route::resource('blogs',BlogController::class);
    Route::post('blog/status',[BlogController::class,'status'])->name('blog.status');
    Route::post('blog/action',[BlogController::class,'action'])->name('blog.action');

    Route::resource('tags',TagController::class)->only('index','create','store','edit','update','destroy');
    Route::post('tag/status',[TagController::class,'status'])->name('tag.status');
    Route::post('tag/action',[TagController::class,'action'])->name('tag.action');

    Route::resource('blog/category',BlogCategoryController::class)->only('index','create','store','edit','update','destroy');
    Route::post('blog/category/status',[BlogCategoryController::class,'status'])->name('blog.category.status');
    Route::post('blog/category/action',[BlogCategoryController::class,'action'])->name('blog.category.action');    
    
    //Setting manage
    Route::get('/application-setting',[SettingController::class,'index'])->name('application.setting.index');
    Route::put('application-settings/update/{id}',[SettingController::class,'update'])->name('application.setting.update');

    Route::resource('socials',SocialController::class)->only('index','create','store','edit','update','destroy');
    Route::post('social/status',[SocialController::class,'status'])->name('social.status');

    //pakage manage
    Route::resource('categories',CategoryController::class);
    Route::post('category/status',[CategoryController::class,'status'])->name('category.status');
    Route::post('category/action',[CategoryController::class,'action'])->name('category.action');

    Route::resource('cities',CityController::class);
    Route::post('city/status',[CityController::class,'status'])->name('city.status');
    Route::post('city/action',[CityController::class,'action'])->name('city.action');
    Route::post('state-wise-city',[CityController::class,'fetch_city'])->name('state-wise-city');

    Route::resource('states',StateController::class);
    Route::post('state/status',[StateController::class,'status'])->name('state.status');
    Route::post('state/action',[StateController::class,'action'])->name('state.action');

    Route::resource('pakage/tag',ThemeController::class)->only('index','create','store','edit','update','destroy');
    Route::post('pakage/tag/status',[ThemeController::class,'status'])->name('pakage.tag.status');
    Route::post('pakage/tag/action',[ThemeController::class,'action'])->name('pakage.tag.action');

    Route::resource('language',LanguageController::class)->only('index','create','store','edit','update','destroy');
    Route::post('language/status',[LanguageController::class,'status'])->name('language.status');
    Route::post('language/action',[LanguageController::class,'action'])->name('language.action');

    Route::resource('types',TypeController::class)->only('index','create','store','edit','update','destroy');
    Route::post('type/status',[TypeController::class,'status'])->name('type.status');
    Route::post('type/action',[TypeController::class,'action'])->name('type.action');

    Route::resource('pakages',PakageController::class);
    Route::post('pakage/status',[PakageController::class,'status'])->name('pakage.status');
    Route::post('pakage/action',[PakageController::class,'action'])->name('pakage.action');
    Route::get('pakage/image/{id}',[PakageController::class,'image'])->name('pakage.image');
    Route::post('pakage/image/store/{id}',[PakageController::class,'image_store'])->name('pakage.image.store');
    Route::post('pakage/default/image/set/{id}',[PakageController::class,'set_default_image'])->name('pakage.default.image.set');
    Route::post('pakage/delete/image/{id}',[PakageController::class,'delete_image'])->name('pakage.delete.image');
    
    Route::get('package/itinerary/{id}', [PakageController::class, 'itinerary'])->name('package.itinerary');
    Route::get('package/itinerary/add/{id}', [PakageController::class, 'addItinerary'])->name('package.itinerary.add'); 
    Route::post('package/itinerary/{id}', [PakageController::class, 'itineraryPost'])->name('package.itinerary.post');
    Route::get('package/itinerary/update/{id}', [PakageController::class, 'updateItinerary'])->name('package.itinerary.update'); 
    Route::post('package/itinerary/update/{id}', [PakageController::class, 'itineraryUpdatePost'])->name('package.itinerary.update.post');
    Route::get('package/itinerary/delete/{id}', [PakageController::class, 'itineraryDelete'])->name('package.itinerary.delete'); 

    Route::resource('galleries',GalleryController::class);
    Route::post('gallery/status',[GalleryController::class,'status'])->name('gallery.status');
    Route::post('gallery/action',[GalleryController::class,'action'])->name('gallery.action');
    Route::get('gallery/image/{id}',[GalleryController::class,'image'])->name('gallery.image');
    Route::post('gallery/image/store/{id}',[GalleryController::class,'image_store'])->name('gallery.image.store');
    Route::post('gallery/default/image/set/{id}',[GalleryController::class,'set_default_image'])->name('gallery.default.image.set');
    Route::post('gallery/delete/image/{id}',[GalleryController::class,'delete_image'])->name('gallery.delete.image');

    Route::resource('do',DoController::class);
    Route::post('do/status',[DoController::class,'status'])->name('do.status');
    Route::post('do/action',[DoController::class,'action'])->name('do.action');

    Route::resource('dont',DontController::class);
    Route::post('dont/status',[DontController::class,'status'])->name('dont.status');
    Route::post('dont/action',[DontController::class,'action'])->name('dont.action');

    Route::resource('pages',PageController::class);
    Route::post('page/action',[PageController::class,'action'])->name('page.action');
    
    //Contact Manage
    Route::resource('contacts',ContactController::class)->only('index','store','update','show','destroy');
    Route::post('contact/action',[ContactController::class,'action'])->name('contact.action');
    Route::get('contact/send/mail/{id}',[ContactController::class,'send_mail'])->name('contact.send.mail');
    Route::get('contact/send/bluk-mail',[ContactController::class,'bluk_mail'])->name('contact.send.bluk-mail');

    Route::resource('newsletter',NewsLetterController::class)->only('index','store','show','update','destroy');
    Route::post('newsletter/action',[NewsLetterController::class,'action'])->name('newsletter.action');
    Route::get('newsletter/send/mail',[NewsLetterController::class,'bluk_mail'])->name('newsletter.send.mail');
    
    Route::get('users', [DashboardController::class, 'users'])->name('users');
    Route::get('user/add', [DashboardController::class, 'userAdd'])->name('user.add');  
    Route::post('user/add', [DashboardController::class, 'userAddPost'])->name('user.add.post'); 
    Route::get('user/update/{id}', [DashboardController::class, 'userUpdate'])->name('user.update');  
    Route::post('user/update/{id}', [DashboardController::class, 'userUpdatePost'])->name('user.update.post');  
    Route::get('user/delete/{id}', [DashboardController::class, 'userDelete'])->name('user.delete');
    
    Route::get('quotes', [DashboardController::class, 'quotes'])->name('quotes'); 
    Route::get('quote/add', [DashboardController::class, 'quoteAdd'])->name('quote.add');  
    Route::post('quote/add', [DashboardController::class, 'quoteAddPost'])->name('quote.add.post'); 
    Route::get('quote/update/{id}', [DashboardController::class, 'quoteUpdate'])->name('quote.update');  
    Route::post('quote/update/{id}', [DashboardController::class, 'quoteUpdatePost'])->name('quote.update.post');  
    Route::get('quote/delete/{id}', [DashboardController::class, 'quoteDelete'])->name('quote.delete');
    Route::get('quote/detail/{id}', [DashboardController::class, 'quoteDetail'])->name('quote.detail');

    Route::resource('locations',LocationController::class);
    Route::post('location/status',[LocationController::class,'status'])->name('location.status');
    Route::post('location/action',[LocationController::class,'action'])->name('location.action');
    Route::post('state-wise-location',[LocationController::class,'fetch_location'])->name('state-wise-location');

    Route::resource('homestays',HomeStayController::class);
    Route::post('homestay/status',[HomeStayController::class,'status'])->name('homestay.status');
    Route::post('homestay/action',[HomeStayController::class,'action'])->name('homestay.action');
    Route::get('homestay/image/{id}',[HomeStayController::class,'image'])->name('homestay.image');
    Route::post('homestay/image/store/{id}',[HomeStayController::class,'image_store'])->name('homestay.image.store');
    Route::post('homestay/default/image/set/{id}',[HomeStayController::class,'set_default_image'])->name('homestay.default.image.set');
    Route::post('homestay/delete/image/{id}',[HomeStayController::class,'delete_image'])->name('homestay.delete.image');
}); 
