<?php

namespace App\Http\Controllers\Admin\Pakage;

use App\FileService;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Language;
use App\Models\Pakage;
use App\Models\PakageCity;
use App\Models\PakageFeature;
use App\Models\PakageImage;
use App\Models\PakageItinerary;
use App\Models\PakagePrice;
use App\Models\PakageTag;
use App\Models\State;
use App\Models\Theme;
use App\Models\Type;
use App\Models\TourItinerary; 
use App\Models\HotelImage;
use App\Models\PakageDo;
use App\Models\PakageDont;
use App\Models\PakageItineraryDescription;
use App\ResponseTrait; 
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class PakageController extends Controller
{
    use ResponseTrait;
    public $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(Request $request)
    {
        $categories = Category::orderBy('name','ASC')->get();
        $states =  State::orderBy('name','ASC')->get();
        if ($request->ajax()) {
             $data = Pakage::with('pakage_images','category','state')
                ->with('pakage_images', function($query){
                    $query->where('default_status', 1);
                });
            return DataTables::of($data)
                ->setRowId('id') 
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $showUrl = route('admin.pakages.show',['pakage' => Crypt::encrypt($row->id) ]);
                    $editUrl = route('admin.pakages.edit',['pakage' => Crypt::encrypt($row->id) ]);
                    // $itineraryUrl = route('admin.package.itinerary', ['id' => Crypt::encrypt($row->id)]);  
                    $deleteUrl = route('admin.pakages.destroy',['pakage' => $row->id]);
                    $imageUrl = route('admin.pakage.image',['id' => $row->id]);
                    $actionButton ='<div class="d-flex">
                        <a href="javascript:;" class="btn btn-sm btn-outline-success px-1 openPopup" data-action-url="'.$imageUrl.'" data-title="Package Images" data-bs-toggle="modal"><i class="bx bx-images"></i></a>&nbsp;
                        <a href="' .$showUrl. '" class="btn btn-sm btn-outline-primary px-1"><i class="bx bx-show"></i></a>&nbsp;
                        <a href="' .$editUrl. '" class="btn btn-sm btn-outline-success px-1"><i class="bx bxs-edit"></i></a>&nbsp;
                        
                        <a href="javascript:;" class="ms-1 btn btn-sm btn-outline-danger px-1" data-bs-target="#deleteConfirm" data-bs-toggle="modal" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure, want to delete?\', \'Delete Package Confirmation\')"><i class="bx bxs-trash"></i></a>
                    </div>';
                    return $actionButton;
                })
                ->addColumn('checkbox', function ($row) {
                    $checkbox ='<div class="form-check form-check-primary">
                        <input class="form-check-input single_check" type="checkbox" value="'.$row->id.'" name="single_check" id="single_check_"'.$row->id.'">
                        <label class="form-check-label" for="single_check_"'.$row->id.'"></label>
                    </div>';
                    return $checkbox;
                })
                ->addColumn('file_path_url', function ($row) {
                    
                    if($row->pakage_images->first()->file_path != ''){
                        $file_path_url = '<img height="50px" src='. $row->pakage_images->first()->file_path_url .' id="image_preview" alt="">';
                    }else{
                        $file_path_url = '<img height="50px" src='.asset('backend/assets/images/no-image.jpg').' id="image_preview" alt="">';
                    }
                    return $file_path_url;
                })
                ->addColumn('category', function ($row) {
                   
                    return $row->category->name;
                })
                ->addColumn('state', function ($row) {
                   
                    return $row->state->name;
                })
                ->addColumn('status', function ($row) {
                    if($row->status == 1){
                        $itemStatus = '<div class="form-check form-switch form-check-success" id="check_id_'.$row->id.'">
                        <input class="form-check-input changeStatus" type="checkbox" data-value="0" data-id="'.$row->id.'" role="switch" id="flexSwitchCheckSuccess_'.$row->id.'" checked>
                        <label class="form-check-label" for="flexSwitchCheckSuccess_'.$row->id.'"></label>
                      </div>';
                    }
                    if($row->status == 0){
                        $itemStatus = '<div class="form-check form-switch form-check-danger" id="check_id_'.$row->id.'">
                        <input class="form-check-input changeStatus" type="checkbox" data-value="1" data-id="'.$row->id.'" role="switch" id="flexSwitchCheckSuccess_'.$row->id.'" checked>
                        <label class="form-check-label" for="flexSwitchCheckSuccess_'.$row->id.'"></label>
                      </div>';
                    }
                    
                    return $itemStatus;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request['status'] == '1' || $request['status'] == '0') {
                        $instance->where('status', $request['status']);
                    }
                    if ($request['category_id']) {
                        $instance->where('category_id', $request['category_id']);
                    }
                    if ($request['state_id']) {
                        $instance->where('state_id', $request['state_id']);
                    }
                    if (!empty($request['search'])) {
                        $instance->where(function($w) use($request){
                            $search = $request['search'];
                            $w->orWhere('title', 'LIKE', "%$search%")
                            ->orWhereHas('category', function ($queryHas) use ($search) {
                                $queryHas->where('name', 'LIKE', "%{$search}%");
                            })
                            ->orWhereHas('state', function ($queryHas) use ($search) {
                                $queryHas->where('name', 'LIKE', "%{$search}%");
                            });
                        });
                    }
                })
            ->rawColumns(['action','checkbox','file_path_url','category','state','status'])
            ->toJson();
        }
        return view('admin.pakage.index',compact(
            'categories',
            'states'
        ));
    }

    public function create()
    {
        $months = [];

         for ($m = 1; $m <= 12; $m++) {
            $month_name = date('F', mktime(0,0,0,$m, 1, date('Y')));
            array_push($months, array(
                'name' => $month_name,
                'id' => $m
            ));
         }
        $tags = Theme::where('status',1)->orderBy('name','asc')->get();
        $categories = Category::where('status',1)->orderBy('name','asc')->get();
        $states = State::where('status',1)->orderBy('name','asc')->get();
        $languages = Language::where('status',1)->orderBy('name','asc')->get();
        $types = Type::where('status',1)->latest()->get();
        $cities = City::where('status',1)->orderBy('name','asc')->get();
        return view('admin.pakage.create',compact(
            'tags',
            'categories',
            'states',
            'languages',
            'months',
            'types',
            'cities'
        ));
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'state_id' => 'required',
            'language_id' => 'required',
            'tag_id.*' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'files.*' => 'required'
        ]); 

        if($request->top_selling){
            $top_selling = $request->top_selling;
        }else{
            $top_selling = 0;
        }

        $pakage = new Pakage();
        $pakage->title = $request->title;
        $pakage->slug = Str::slug($request->title,'-');
        $pakage->state_id = $request->state_id;
        $pakage->category_id = $request->category_id;
        $pakage->language_id = $request->language_id;
        $pakage->duration = $request->duration;
        $pakage->lowest_price = $request->lowest_price;
        $pakage->total_price = $request->total_price;
        $pakage->description = $request->description;
        $pakage->short_description = $request->short_description;
        $pakage->tour_inclusion = $request->inclusion;
        $pakage->tour_exclusion = $request->exclusion;
        $pakage->booking_policy = $request->booking_policy;
        $pakage->top_selling = $top_selling;
        $pakage->rated = $request->rated;
        $pakage->review = $request->review;
        $pakage->cancellation_policy = $request->cancellation_policy;
        $pakage->summary = $request->summary; 
        $pakage->save(); 

        if($request->cities){
            foreach($request->cities as $city){
                $pakageCity = new PakageCity();
                $pakageCity->pakage_id = $pakage->id;
                $pakageCity->city_id = $city['city_id'];
                $pakageCity->duration = $city['city_duration'];
                $pakageCity->save();
            }
        }
        if($request->tag_id){
            foreach($request->tag_id as $tag){
                $pakageTag = new PakageTag();
                $pakageTag->theme_id = $tag;
                $pakageTag->pakage_id = $pakage->id;
                $pakageTag->save();
            }
        }
        
        $types = Type::where('status',1)->get();
        foreach($request->price as $key => $prices){
            foreach($types as $type){
                if($type->slug == $key){
                    foreach($prices as $row){
                        $pakagePrice = new PakagePrice();
                        $pakagePrice->pakage_id = $pakage->id;
                        $pakagePrice->month = $row['month'];
                        $pakagePrice->price = $row['price'];
                        $pakagePrice->type_id = $row['type_id'];
                        $pakagePrice->save();
                    }
                }
            }
        }
        foreach($request->itineraries as $key => $itinerary){
            foreach($types as $type){
                if($type->slug == $key){
                    foreach($itinerary as $val){
                        $pakageItinerary = new PakageItinerary();
                        $pakageItinerary->pakage_id = $pakage->id;
                        $pakageItinerary->tour_itinerary = $val['tour_itinerary'];
                        $pakageItinerary->type_id = $val['type_id'];
                        $pakageItinerary->save();
                    }
                }
            }
        }
       //dd($request->itinerary_descriptions);
        foreach($request->itinerary_descriptions as $key => $row){
            foreach($types as $type){
                if($type->slug == $key){
                    foreach($row as $rowVal){
                        $pakageItineraryDescription = new PakageItineraryDescription();
                        $pakageItineraryDescription->pakage_id = $pakage->id;
                        $pakageItineraryDescription->tour_itinerary_description = $rowVal['tour_itinerary_description'];
                        $pakageItineraryDescription->type_id = $rowVal['type_id'];
                        $pakageItineraryDescription->save();
                    }
                }
            }
        }
        if($request->pakage_feature){
            foreach($request->pakage_feature as $feature){
                $pakageFeature = new PakageFeature();
                $pakageFeature->name = $feature;
                $pakageFeature->pakage_id = $pakage->id;
                $pakageFeature->save();
            }
        }
        if($request->pakage_do){
            foreach($request->pakage_do as $do){
                $pakageDo = new PakageDo();
                $pakageDo->title = $do;
                $pakageDo->pakage_id = $pakage->id;
                $pakageDo->save();
            }
        }
        if($request->pakage_dont){
            foreach($request->pakage_dont as $dont){
                $pakageDont = new PakageDont();
                $pakageDont->title = $dont;
                $pakageDont->pakage_id = $pakage->id;
                $pakageDont->save();
            }
        }
        if ($request->hasFile('file')) {
            $files = $request->file('file');
            foreach($files as $key => $file){
                if($key == 0){
                    $default_status = 1;
                }else{
                    $default_status = 0;
                }
                $file_path = $this->fileService->store($file, '/pakages');
                $pakageImage = new PakageImage();
                $pakageImage->file_path = $file_path;
                $pakageImage->pakage_id = $pakage->id;
                $pakageImage->default_status = $default_status;
                $pakageImage->save();
            }
        }
       
        if($request->tour_itineraries){
            foreach($request->tour_itineraries as $rowItinery){
                $tourItinerary = new TourItinerary();
                $tourItinerary->package_id = $pakage->id;
                $tourItinerary->day_no = $rowItinery['day_no'];
                $tourItinerary->title = $rowItinery['title'];
                $tourItinerary->check_in = $rowItinery['check_in'];
                $tourItinerary->sight_seeing = $rowItinery['sight_seeing'];
                $tourItinerary->text = $rowItinery['title_text'];
                $tourItinerary->stay_at = $rowItinery['stay_at'];
                $tourItinerary->save();
            }
        }

        if($request->hotels){
           
            foreach($request->hotels as $hkey => $hotel){
                $file = $hotel['hotel_file'];
                $file_path = $this->fileService->store($file, '/pakages');
                $hotelImage = new HotelImage();
                $hotelImage->pakage_id = $pakage->id;
                $hotelImage->type_id = $hotel['type_id'];
                $hotelImage->title = $hotel['hotel_text'];
                $hotelImage->file_path = $file_path;
                $hotelImage->save();
            }
        }

        $redirect = route('admin.pakages.index');
        return $this->success($redirect, 'Pakage Created successfully');
    }

    public function show(string $id)
    {
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $month_name = date('F', mktime(0,0,0,$m, 1, date('Y')));
            array_push($months, array(
                'name' => $month_name,
                'id' => $m
            ));
        }

        $blog_id = Crypt::decrypt($id);
        $item = Pakage::with(
            'state',
            'language',
            'category',
            'pakage_tags',
            'pakage_cities',
            'pakage_itineraries',
            'pakage_prices',
            'pakage_features',
            'pakage_images'
            )
        ->findOrFail($blog_id);
        //dd($item);
        $types = Type::where('status',1)->latest('id')->get();
        return view('admin.pakage.show',compact(
            'item',
            'types',
            'months'
        ));
    }

    public function edit(string $id)
    {
        $pakage_id = Crypt::decrypt($id);
        $item = Pakage::with('pakage_tags','pakage_cities','pakage_itineraries','pakage_itinerary_descriptions','pakage_prices','pakage_features','pakage_do','pakage_dont','pakage_images','pakage_tour_itineraries','pakage_itinerary_hotels')->findOrFail($pakage_id);
         //dd($item);
        $months = [];

         for ($m = 1; $m <= 12; $m++) {
            $month_name = date('F', mktime(0,0,0,$m, 1, date('Y')));
            array_push($months, array(
                'name' => $month_name,
                'id' => $m
            ));
         }
        $tags = Theme::where('status',1)->orderBy('name','asc')->get();
        $categories = Category::where('status',1)->orderBy('name','asc')->get();
        $states = State::where('status',1)->orderBy('name','asc')->get();
        $languages = Language::where('status',1)->orderBy('name','asc')->get();
        $types = Type::where('status',1)->latest()->get();
        $cities = City::where('status',1)->orderBy('name','asc')->get();
        return view('admin.pakage.edit',compact(
            'item',
            'tags',
            'categories',
            'states',
            'languages',
            'months',
            'types',
            'cities'
        ));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'state_id' => 'required',
            'language_id' => 'required',
            'tag_id.*' => 'required',
            'short_description' => 'required',
            'description' => 'required',
        ]);

        $pakage = Pakage::findOrFail($id);
        $pakage->title = $request->title;
        $pakage->state_id = $request->state_id;
        $pakage->category_id = $request->category_id;
        $pakage->language_id = $request->language_id;
        $pakage->duration = $request->duration;
        $pakage->lowest_price = $request->lowest_price;
        $pakage->total_price = $request->total_price;
        $pakage->description = $request->description;
        $pakage->short_description = $request->short_description;
        $pakage->tour_inclusion = $request->inclusion;
        $pakage->tour_exclusion = $request->exclusion;
        $pakage->booking_policy = $request->booking_policy;
        $pakage->cancellation_policy = $request->cancellation_policy;
        $pakage->summary = $request->summary; 
        $pakage->top_selling = $request->top_selling;
        $pakage->rated = $request->rated;
        $pakage->review = $request->review;
        $pakage->save();

        if($request->cities){
            PakageCity::where('pakage_id',$id)->delete();
            foreach($request->cities as $city){
                $pakageCity = new PakageCity();
                $pakageCity->pakage_id = $id;
                $pakageCity->city_id = $city['city_id'];
                $pakageCity->duration = $city['city_duration'];
                $pakageCity->save();
            }
        }

        if($request->tag_id){
            PakageTag::where('pakage_id',$id)->delete();
            foreach($request->tag_id as $tag){
                $pakageTag = new PakageTag();
                $pakageTag->theme_id = $tag;
                $pakageTag->pakage_id = $id;
                $pakageTag->save();
            }
        }

        $types = Type::where('status',1)->get();
        foreach($request->price as $key => $prices){
            foreach($types as $type){
                if($type->slug == $key){
                    PakagePrice::where('pakage_id',$id)->where('type_id',$type->id)->delete();
                    foreach($prices as $row){
                        $pakagePrice = new PakagePrice();
                        $pakagePrice->pakage_id = $id;
                        $pakagePrice->month = $row['month'];
                        $pakagePrice->price = $row['price'];
                        $pakagePrice->type_id = $row['type_id'];
                        $pakagePrice->save();
                    }
                }
            }
        }
        foreach($request->itineraries as $key => $itinerary){
            foreach($types as $type){
                if($type->slug == $key){
                    PakageItinerary::where('pakage_id',$id)->where('type_id',$type->id)->delete();
                    foreach($itinerary as $val){
                        $pakageItinerary = new PakageItinerary();
                        $pakageItinerary->pakage_id = $id;
                        $pakageItinerary->tour_itinerary = $val['tour_itinerary'];
                        $pakageItinerary->type_id = $val['type_id'];
                        $pakageItinerary->save();
                    }
                }
            }
        }

        foreach($request->itinerary_descriptions as $key => $row){
            foreach($types as $type){
                if($type->slug == $key){
                    PakageItineraryDescription::where('pakage_id',$id)->where('type_id',$type->id)->delete();
                    foreach($row as $rowVal){
                        $pakageItineraryDescription = new PakageItineraryDescription();
                        $pakageItineraryDescription->pakage_id = $pakage->id;
                        $pakageItineraryDescription->tour_itinerary_description = $rowVal['tour_itinerary_description'];
                        $pakageItineraryDescription->type_id = $rowVal['type_id'];
                        $pakageItineraryDescription->save();
                    }
                }
            }
        }

        if($request->pakage_feature){
            PakageFeature::where('pakage_id',$id)->delete();
            foreach($request->pakage_feature as $feature){
                $pakageFeature = new PakageFeature();
                $pakageFeature->name = $feature;
                $pakageFeature->pakage_id = $id;
                $pakageFeature->save();
            }
        }

        if($request->pakage_do){
            PakageDo::where('pakage_id',$id)->delete();
            foreach($request->pakage_do as $do){
                $pakageDo = new PakageDo();
                $pakageDo->title = $do;
                $pakageDo->pakage_id = $id;
                $pakageDo->save();
            }
        }

        if($request->pakage_dont){
            PakageDont::where('pakage_id',$id)->delete();
            foreach($request->pakage_dont as $dont){
                $pakageDont = new PakageDont();
                $pakageDont->title = $dont;
                $pakageDont->pakage_id = $id;
                $pakageDont->save();
            }
        }

        if ($request->hasFile('file')) {
            $files = $request->file('file');
            foreach($files as $key => $file){
                $file_path = $this->fileService->store($file, '/pakages');
                $pakageImage = new PakageImage();
                $pakageImage->file_path = $file_path;
                $pakageImage->pakage_id = $id;
                $pakageImage->save();
            }
        }

        if($request->tour_itineraries){
            TourItinerary::where('package_id',$id)->delete();
            foreach($request->tour_itineraries as $rowItinery){
                $tourItinerary = new TourItinerary();
                $tourItinerary->package_id = $pakage->id;
                $tourItinerary->day_no = $rowItinery['day_no'];
                $tourItinerary->title = $rowItinery['title'];
                $tourItinerary->check_in = $rowItinery['check_in'];
                $tourItinerary->sight_seeing = $rowItinery['sight_seeing'];
                $tourItinerary->text = $rowItinery['title_text'];
                $tourItinerary->stay_at = $rowItinery['stay_at'];
                $tourItinerary->save();
            }
        }
       
        if($request->hotels){
           
            foreach($request->hotels as $hkey => $hotel){
                    $file = $hotel['hotel_file'];
                    $file_path = $this->fileService->store($file, '/pakages');
                    $hotelImage = new HotelImage();
                    $hotelImage->pakage_id = $pakage->id;
                    $hotelImage->type_id = $hotel['type_id'];
                    $hotelImage->title = $hotel['hotel_text'];
                    $hotelImage->file_path = $file_path;
                    $hotelImage->save();
               
                
            }
        }

        $redirect = route('admin.pakages.index');
        return $this->success($redirect, 'Pakage updated successfully');
    }

    public function destroy(string $id)
    {
        $pakageImages = PakageImage::where('pakage_id',$id)->get();
        foreach($pakageImages as $image){
            if($image->file_path!='') {
                if(Storage::exists($image->file_path)){
                    Storage::delete($image->file_path);
                }
            }
        }
        Pakage::destroy($id);
        $redirect = route('admin.pakages.index');
        return $this->success($redirect, 'Pakage deleted successfully');
    }

    public function status(Request $request)
    {
        $response = Pakage::findOrFail($request->id);
        $response->status = $request->status;
        $response->save();
        if($response){
            return $this->ajaxSuccess($response, 'Pakage status has been changed successfully');
        }else{
            return $this->ajaxError([]);
        }
    }

    public function action(Request $request)
    {
        if($request->action_value == 'is_delete'){
            foreach($request->ids as $id){
                $pakageImages = PakageImage::where('pakage_id',$id)->get();
                foreach($pakageImages as $image){
                    if($image->file_path!='') {
                        if(Storage::exists($image->file_path)){
                            Storage::delete($image->file_path);
                        }
                    }
                }
                $pakage = Pakage::findOrFail($id);
                $pakage->delete();
            }
            $redirect = route('admin.pakages.index');
            return $this->ajaxSuccess(['response' => $redirect, 'success_msg' => 'Pakage deleted successfully','status' => true]);
        }
    }

    public function image(string $id)
    {
        $item = Pakage::with('pakage_images')->findOrFail($id);
        $returnHTML = view('admin.pakage.image', ['item' => $item])->render();
      
        return Response::json(['status'=>true,'html'=>$returnHTML]);
    }

    public function image_store(Request $request,string $id)
    {
        $request->validate([
            'files.*' => 'required|image'
        ]);
        if ($request->hasFile('file')) {
            $files = $request->file('file');
            foreach($files as $key => $file){
                $file_path = $this->fileService->store($file, '/pakages');
                $pakageImage = new PakageImage();
                $pakageImage->file_path = $file_path;
                $pakageImage->pakage_id = $id;
                $pakageImage->save();
            }
        }

        $redirect = route('admin.pakages.index');
        return $this->success($redirect, 'Pakage image added successfully');
    }

    public function set_default_image(Request $request,string $id)
    {
       $pakage_id = $id;
       $defaultStatus = PakageImage::where('pakage_id',$pakage_id)->where('default_status',1)->first();
       
       $defaultStatus->default_status = 0;
       $defaultStatus->save();

       $pakageImage = PakageImage::findOrFail($request->id);
       $pakageImage->default_status = 1;
       $pakageImage->save();
       return $this->ajaxSuccess(['title' => 'Set Default!', 'success_msg' => 'Your default image has been set.','status' => true]);
    }

    public function delete_image(Request $request,string $id)
    {
       $pakageImage = PakageImage::findOrFail($id);
       if($pakageImage->default_status == 1){
            return $this->ajaxSuccess(['title' => 'Delete Error!', 'error_msg' => 'This image can not be deleted because is a default image.','status' => false]);
       }else{
        
        if($pakageImage->file_path!='') {
            if(Storage::exists($pakageImage->file_path)){
                Storage::delete($pakageImage->file_path);
            }
        }
        PakageImage::destroy($id);
        $pakageImages = PakageImage::where('pakage_id',$request->pakage_id)->get();
        $html = '';
        
        foreach($pakageImages as $key => $rowImage){
            $deleteUrl = route('admin.pakage.delete.image',['id'=> $rowImage->id]);
            $setUrl = route('admin.pakage.default.image.set',['id'=> $request->pakage_id]);
            if($rowImage->default_status == 1){
                $check = 'checked';
            }else{
                $check = '';
            }
            $html .='<div class="col">
                    <img src="'.$rowImage->file_path_url.'" width="100" height="100" class="border rounded cursor-pointer" alt="">
                    <a href="javascript:;" class="delete-image" data-pakage-id="'.$request->pakage_id.'" data-action-url="'.$deleteUrl.'"><span class="icon"><i class="fas fa-trash-alt" style="color: red"></i></span></a>
                    <div class="form-check">
                        <input class="form-check-input default-image" type="radio" data-action-url="'.$setUrl.'" name="default_status" value="'.$rowImage->id.'" id="flexRadioDefault'.$rowImage->id.'" '.$check.'>
                        <label class="form-check-label" for="flexRadioDefault'.$rowImage->id.'">
                          Main Image
                        </label>
                      </div>
                </div>';
        }
        
        return $this->ajaxSuccess(['html' => $html ,'title' => 'Delete!', 'success_msg' => 'Your image has been deleted.','status' => true]);
       }

       
    }
    
    public function itinerary($id)
    {
        $id = decrypt($id); 
        $type = Type::get(); 
        $itinerary = TourItinerary::where('package_id', $id)->orderBy('day_no')->get(); 
        return view('admin.pakage.itinerary',compact('id', 'type', 'itinerary'));   
    }  
    
    public function addItinerary($id)
    {
        $id = decrypt($id); 
        $type = Type::get();  
        return view('admin.pakage.add-itinerary',compact('id', 'type'));   
    }   
    
    public function itineraryPost(Request $request, $id)
    {
        $id = decrypt($id); 
        $itinerary = new TourItinerary(); 
        $itinerary->package_id = $id; 
        $itinerary->type_id = $request->type_id;
        $itinerary->day_no = $request->day_no;
        $itinerary->title = $request->title;
        $itinerary->check_in = $request->check_in;
        $itinerary->sight_seeing = $request->sight_seeing;
        $itinerary->text = $request->text;
        $itinerary->stay_at = $request->stay_at;
        $itinerary->save();  
        for($i = 0; $i < count($request->data_title); $i++)  
        { 
            $image = $request->file('data_file')[$i]; 
            $file_path = $this->fileService->store($image, '/pakages');
            $data = new HotelImage(); 
            $data->tour_itinerary_id = $itinerary->id;  
            $data->title = $request->data_title[$i];   
            $data->file_path = $file_path; 
            $data->save(); 
        }    
        return redirect('admin/package/itinerary/'.encrypt($id));   
    }
    
    public function updateItinerary($id)
    {
        $id = decrypt($id); 
        $type = Type::get(); 
        $itinerary = TourItinerary::find($id); 
        return view('admin.pakage.update-itinerary',compact('id', 'type', 'itinerary'));   
    }  
    
    public function itineraryUpdatePost(Request $request, $id)
    { 
        $id = decrypt($id); 
        $itinerary = TourItinerary::find($id);  
        $itinerary->type_id = $request->type_id;
        $itinerary->day_no = $request->day_no;
        $itinerary->title = $request->title;
        $itinerary->check_in = $request->check_in;
        $itinerary->sight_seeing = $request->sight_seeing;
        $itinerary->text = $request->text;
        $itinerary->stay_at = $request->stay_at;
        $itinerary->save();  
        // for($i = 0; $i < count($request->data_title); $i++)  
        // { 
        //     $image = $request->file('data_file')[$i]; 
        //     $file_path = $this->fileService->store($image, '/pakages');
        //     $data = new HotelImage(); 
        //     $data->tour_itinerary_id = $itinerary->id;  
        //     $data->title = $request->data_title[$i];   
        //     $data->file_path = $file_path; 
        //     $data->save(); 
        // }     
        return redirect('admin/package/itinerary/'.encrypt($itinerary->package_id)); 
    }   
    
    public function itineraryDelete($id)
    {
        $id = decrypt($id); 
        $itinerary = TourItinerary::find($id);
        $itinerary->delete(); 
        return redirect()->back(); 
    }
}
