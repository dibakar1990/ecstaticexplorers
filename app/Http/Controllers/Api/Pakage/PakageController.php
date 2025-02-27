<?php

namespace App\Http\Controllers\Api\Pakage;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\CmsDo;
use App\Models\CmsDont;
use App\Models\Gallery;
use App\Models\Pakage;
use App\Models\PakageImage;
use App\Models\State;
use App\Models\PakageCity; 
use App\Models\Theme;
use App\Models\TourItinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class PakageController extends Controller
{
    use ApiResponseTrait;

    public function getTrendingStates()
    { 
        $states_collections = State::select('id', 'name', 'slug', 'trending_image')->where('trending', 1)->where('status', 1)->orderBy('sl_no')->get();
        $states = $states_collections->map(function ($item) { 
            if($item->trending_image != '')
            {
                $item->trending_image = URL::to('/').'/storage/'.$item->trending_image;
            } 
            return $item;
        });
        return $this->sendSuccessResponse($states, 'success');
    }   
    
    public function getExploreByStates()
    {  
        $states_collections = State::select('id', 'name', 'slug', 'starting_price', 'file_path')->where('explore_state', 1)->where('status', 1)->orderBy('sl_no')->get();
        $states = $states_collections->map(function ($item) {  
            if($item->file_path != '')
            {
                $item->file_path = $item->file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($states, 'success');
    } 
    
    public function getExploreTheUnexploredStates()
    {   
        $states_collections = State::select('id', 'name', 'slug', 'starting_price', 'file_path')->where('explore_unexplore', 1)->where('status', 1)->orderBy('sl_no')->get();
        $states = $states_collections->map(function ($item) {  
            if($item->file_path != '')
            {
                $item->file_path = $item->file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($states, 'success');
    }   
    
    public function get_category()
    {
        $categories = Category::where('status',1)->with('pakages')->latest()->get();
        return $this->sendSuccessResponse($categories,'success');
    }

    public function get_city()
    {
        $cities = City::select('id','name','slug')->where('status',1)->with('package')->latest()->get();
        return $this->sendSuccessResponse($cities,'success'); 
    }

    public function get_top_city(Request $request)
    {
        $query = City::where('status',1)->where('top_destination',1);
        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
            
        }
        $cityCollection = $query->latest()->get();
        $cities = $cityCollection->map(function($item) {
            if($item->file_path != ''){
                $item->file_path = $item->file_path_url;
            }
            if($item->top_destination_file_path != ''){
                $item->top_destination_file_path = $item->top_destination_file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($cities,'success');
    }

    public function get_state()
    {
        
        $stateCollection = State::select('id','name','starting_price','slug','file_path','trending','type')->where('status',1)->latest()->get();
        $states = $stateCollection->map(function($item) {
            if($item->file_path != ''){
                $item->file_path = $item->file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($states,'success');
    }

    public function top_selling()
    {
        $dataCollection = Pakage::select(
            'id',
            'title',
            'slug',
            'state_id',
            'duration',
            'summary',
            'rated',
            'review'
            )
            ->latest()
            ->get();
        $pakages = $dataCollection->map(function($item) {
            $pakageImage = PakageImage::where('pakage_id',$item->id)->where('default_status',1)->first();
            if($pakageImage->file_path != ''){
                $item->pakage_file_path = $pakageImage->file_path_url;
            }
            $state = State::where('id',$item->state_id)->first();
            if($state->name != ''){
                $item->state_name = $state->name;
            }
            if($state->file_path != ''){
                $item->state_file_path = $state->file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($pakages,'success');
    }

    public function get_theme()
    {
        $themes = Theme::where('status',1)->with('package')->latest()->get();
        return $this->sendSuccessResponse($themes,'success');
    } 

    public function get_pakage()
    {
        $pakageCollection = Pakage::select('id','title','slug','category_id','description','summary','total_price','lowest_price')->with('pakage_cities')->with('pakage_tags')->with('pakage_features')->where('status',1)->latest()->get();
        $pakages = $pakageCollection->map(function($item) {
            $pakageImage = PakageImage::where('pakage_id',$item->id)->where('default_status',1)->first();
            if($pakageImage->file_path != ''){
                $item->file_path = $pakageImage->file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($pakages,'success');
    }
    
    public function get_pakage_with_category($id) 
    { 
        $pakageCollection = Pakage::select('id','title','slug','category_id','description','summary','rated','review','total_price','lowest_price')->with('pakage_cities')->with('pakage_tags')->with('pakage_features')->where('category_id',$id)->where('status',1)->latest()->get();
        $pakages = $pakageCollection->map(function($item) {
            $pakageImage = PakageImage::where('pakage_id',$item->id)->where('default_status',1)->first();
            if($pakageImage->file_path != ''){
                $item->file_path = $pakageImage->file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($pakages,'success');
    }  

    public function show($id)
    {
        $pakage = Pakage::with(
            'category', 
            'pakage_images',
            'pakage_prices',
            'state',
            'language',
            'pakage_cities',
            'pakage_features',
            'pakage_itineraries',
            'pakage_itinerary_descriptions',
            'pakage_tour_itineraries',
            'pakage_itinerary_hotels',
            'pakage_do',
            'pakage_dont'
        )
        ->findOrFail($id);
        return $this->sendSuccessResponse($pakage,'success');
    }

    public function get_do()
    {
        $do = CmsDo::where('status',1)->latest()->get();
        return $this->sendSuccessResponse($do,'success');
    }

    public function get_dont()
    {
        $dont = CmsDont::where('status',1)->latest()->get();
        return $this->sendSuccessResponse($dont,'success');
    }

    public function search_pakage(Request $request)
    {
       //dd($request->all());
        $query = Pakage::select(
            'id',
            'title',
            'slug',
            'category_id',
            'description',
            'total_price',
            'lowest_price',
            'summary',
            'rated',
            'review'
            )
        ->with('pakage_tags','pakage_cities')->where('status',1);

        
        if ($request->filled('category_id')) {
            $query->whereIn('category_id', $request->category_id);
            
        }
        if ($request->filled('city_id')) {
            $query->whereHas('pakage_cities', function ($cityQuery) use($request) {
                $cityQuery->whereIn('city_id', $request->city_id);
            });
        }
        if($request->theme_id){
            $query->whereHas('pakage_tags', function ($themeQuery) use($request) {
                $themeQuery->whereIn('theme_id', $request->theme_id);
            });
        }
       
        $search = $query->latest()->get();
        return $this->sendSuccessResponse($search,'success');
    }
    
    public function tourItinerary($id, $type)
    {
        $itinerary = TourItinerary::where('package_id', $id)->where('type_id', $type)->with('hotel')->orderBy('day_no')->get();  
        return $this->sendSuccessResponse($itinerary, 'success');   
    } 
    
    public function packageWithCity($id)  
    { 
        $pakageCollection = Pakage::select('id','title','slug','category_id','description','summary','rated','review','total_price','lowest_price')->with('pakage_cities')->with('pakage_tags')->with('pakage_features')->whereHas('pakage_cities', function($q) use($id) {
                $q->where('city_id', $id); 
}           )->where('status',1)->latest()->get();
        $pakages = $pakageCollection->map(function($item) {
            $pakageImage = PakageImage::where('pakage_id',$item->id)->where('default_status',1)->first();
            if($pakageImage->file_path != ''){
                $item->file_path = $pakageImage->file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($pakages,'success');   
    }   
    
    public function packageWithTheme($id)  
    {  
        $pakageCollection = Pakage::select('id','title','slug','category_id','description','summary','rated','review','total_price','lowest_price')->with('pakage_cities')->with('pakage_tags')->with('pakage_features')->whereHas('pakage_tags', function($q) use($id) {
                $q->where('theme_id', $id); 
}           )->where('status',1)->latest()->get();
        $pakages = $pakageCollection->map(function($item) {
            $pakageImage = PakageImage::where('pakage_id',$item->id)->where('default_status',1)->first();
            if($pakageImage->file_path != ''){
                $item->file_path = $pakageImage->file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($pakages,'success');   
    }
    
    public function packageWithPrice($data) 
    { 
        $price = explode('-', $data); 
        $pakageCollection = Pakage::select('id','title','slug','category_id','description','summary','rated','review','total_price','lowest_price')->with('pakage_cities')->with('pakage_tags')->with('pakage_features')->whereBetween('lowest_price', [$price[0], $price[1]])->where('status',1)->latest()->get();
        $pakages = $pakageCollection->map(function($item) {
            $pakageImage = PakageImage::where('pakage_id',$item->id)->where('default_status',1)->first();
            if($pakageImage->file_path != ''){
                $item->file_path = $pakageImage->file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($pakages,'success');
    } 
    
    public function packageWithState($id)  
    { 
        $pakageCollection = Pakage::select('id','title','slug','category_id','description','summary','rated','review','total_price','lowest_price')->with('pakage_cities')->with('pakage_tags')->with('pakage_features')->whereHas('pakage_cities', function($q) use($id) {
                $q->where('state_id', $id); 
}           )->where('status',1)->latest()->get();
        $pakages = $pakageCollection->map(function($item) {
            $pakageImage = PakageImage::where('pakage_id',$item->id)->where('default_status',1)->first();
            if($pakageImage->file_path != ''){
                $item->file_path = $pakageImage->file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($pakages,'success');   
    }
    
    public function packageWithDuration($data) 
    {  
        $duration = explode('-', $data); 
        $pakageCollection = Pakage::select('id','title','slug','category_id','description','summary','rated','review','total_price','lowest_price')->with('pakage_cities')->with('pakage_tags')->with('pakage_features')->whereBetween('duration', [$duration[0], $duration[1]])->where('status',1)->latest()->get();
        $pakages = $pakageCollection->map(function($item) {
            $pakageImage = PakageImage::where('pakage_id',$item->id)->where('default_status',1)->first();
            if($pakageImage->file_path != ''){
                $item->file_path = $pakageImage->file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($pakages,'success');
    }

    public function get_package_with_city($id) 
    {  
        $packageID = $id;
        $pakageCities = PakageCity::where('pakage_id',$packageID)->pluck('city_id');
        $pakageIDs = PakageCity::whereIn('city_id',$pakageCities)
                    ->where('pakage_id','!=',$packageID)
                    ->groupBy('pakage_id')
                    ->pluck('pakage_id');
        
        $pakageCollection = Pakage::select('id','title','slug','category_id','description','summary','rated','review','total_price','lowest_price')
                        ->whereIn('id',$pakageIDs)
                        ->with('pakage_cities')->with('pakage_tags')->with('pakage_features')->where('status',1)->latest()->get();
        
        $pakages = $pakageCollection->map(function($item) {
            $pakageImage = PakageImage::where('pakage_id',$item->id)->where('default_status',1)->first();
            if($pakageImage->file_path != ''){
                $item->file_path = $pakageImage->file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($pakages,'success');
    }

    public function get_package_with_state($id) 
    {  
        $packageID = $id;
        $stateID= Pakage::where('id',$packageID)->value('state_id');
        
        $pakageCollection = Pakage::select('id','title','slug','category_id','state_id','description','summary','rated','review','total_price','lowest_price')
                        ->where('state_id',$stateID)
                        ->where('id','!=',$packageID)
                        ->with('pakage_cities')->with('pakage_tags')->with('pakage_features')->where('status',1)->latest()->get();
        
        $pakages = $pakageCollection->map(function($item) {
            $pakageImage = PakageImage::where('pakage_id',$item->id)->where('default_status',1)->first();
            if($pakageImage->file_path != ''){
                $item->file_path = $pakageImage->file_path_url;
            }
            return $item;
        });

        return $this->sendSuccessResponse($pakages,'success');
    }

    public function get_state_info(Request $request)
    {
       
        $query = State::where('status',1);
        if ($request->filled('state_id')) {
            $query->where('id', $request->state_id);
        }
       
        $statesInfo = $query->latest()->get();
        $result = collect($statesInfo)->reduce(function ($total, $item) {
            $total['destination'] += $item['destination'];
            $total['hotels'] += $item['hotels'];
            $total['tourist'] += $item['tourist'];
            $total['tour'] += $item['tour'];
            $total['is_home_stay'] = $item['is_home_stay'];
            return $total;
        }, ['destination' => 0, 'hotels' => 0,'tourist' => 0, 'tour' => 0]);
        return $this->sendSuccessResponse($result,'success');
    }

    public function get_gallery(Request $request)
    {
       
        $query = Gallery::with('gallery_images')->where('status',1);
        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
            
        }
       
        $galleryCollection = $query->latest()->get();
        $galleries = $galleryCollection->map(function($item) {
            foreach($item->gallery_images as $row){
                if($row->file_path != ''){
                    $row->file_path = $row->file_path_url;
                }
            }
            
            return $item;
        });
        return $this->sendSuccessResponse($galleries,'success');
    }

    public function get_city_details($id)
    { 
        $city = City::where('status', 1)->where('id',$id)->first();
        
        if($city->file_path != '')
        {
            $city->file_path = $city->file_path_url;
        } 
        if($city->top_destination_file_path != '')
        {
            $city->top_destination_file_path = $city->top_destination_file_path_url;
        } 
        return $this->sendSuccessResponse($city, 'success');
    }
    
    public function get_city_with_pakage()
    {
        $city_id = null;
        $pakageCities = Pakage::select(
            'id',
            'title',
            'category_id',
            'city_id',
            'description',
            'image'
        )->with('category')->where('city_id',$city_id)->where('status',1)->get();
        $pakages = $pakageCities->map(function($item) {
            $pakageImage = PakageImage::where('pakage_id',$item->id)->where('default_status',1)->first();
            if($pakageImage->file_path != ''){
                $item->file_path = $pakageImage->file_path_url;
            }
            return $item;
        });
        return $this->sendSuccessResponse($pakages,'success');
    }
}   
