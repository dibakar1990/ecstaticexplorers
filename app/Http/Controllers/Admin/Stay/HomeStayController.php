<?php

namespace App\Http\Controllers\Admin\Stay;

use App\FileService;
use App\Http\Controllers\Controller;
use App\Models\HomeStay;
use App\Models\HomeStayFacility;
use App\Models\HomeStayImage;
use App\Models\State;
use App\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class HomeStayController extends Controller
{
    use ResponseTrait;
    public $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(Request $request)
    {
        $states =  State::orderBy('name','ASC')->get();
        if ($request->ajax()) {
            $data = HomeStay::with('homestay_images','state')
               ->with('homestay_images', function($query){
                   $query->where('default_status', 1);
               });
           return DataTables::of($data)
               ->setRowId('id') 
               ->addIndexColumn()
               ->addColumn('action', function($row){
                   
                   $editUrl = route('admin.homestays.edit',['homestay' => Crypt::encrypt($row->id) ]);
                   $deleteUrl = route('admin.homestays.destroy',['homestay' => $row->id]);
                   $imageUrl = route('admin.homestay.image',['id' => $row->id]);
                   $actionButton ='<div class="d-flex">
                       <a href="javascript:;" class="btn btn-sm btn-outline-success px-1 openPopup" data-action-url="'.$imageUrl.'" data-title="Package Images" data-bs-toggle="modal"><i class="bx bx-images"></i></a>&nbsp;
                       
                       <a href="' .$editUrl. '" class="btn btn-sm btn-outline-success px-1"><i class="bx bxs-edit"></i></a>&nbsp;
                       
                       <a href="javascript:;" class="ms-1 btn btn-sm btn-outline-danger px-1" data-bs-target="#deleteConfirm" data-bs-toggle="modal" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure, want to delete?\', \'Delete Homestay Confirmation\')"><i class="bx bxs-trash"></i></a>
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
                   
                   if($row->homestay_images->first()->file_path != ''){
                       $file_path_url = '<img height="50px" src='. $row->homestay_images->first()->file_path_url .' id="image_preview" alt="">';
                   }else{
                       $file_path_url = '<img height="50px" src='.asset('backend/assets/images/no-image.jpg').' id="image_preview" alt="">';
                   }
                   return $file_path_url;
               })
               ->addColumn('state', function ($row) {
                    
                    return $row->state->name;
                })
                ->addColumn('location', function ($row) {
                    
                    return $row->location->name;
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
                   if ($request['state_id']) {
                       $instance->where('state_id', $request['state_id']);
                   }
                   if (!empty($request['search'])) {
                       $instance->where(function($w) use($request){
                           $search = $request['search'];
                           $w->orWhere('title', 'LIKE', "%$search%")
                           ->orWhere('property_classification', 'LIKE', "%$search%")
                           ->orWhere('property_uniqueness', 'LIKE', "%$search%")
                           ->orWhere('tariff', 'LIKE', "%$search%")
                           ->orWhere('price_per_night', 'LIKE', "%$search%")
                           ->orWhereHas('location', function ($queryHas) use ($search) {
                                $queryHas->where('name', 'LIKE', "%{$search}%");
                            })
                           ->orWhereHas('state', function ($queryHas) use ($search) {
                               $queryHas->where('name', 'LIKE', "%{$search}%");
                           });
                       });
                   }
               })
           ->rawColumns(['action','checkbox','file_path_url','state','location','status'])
           ->toJson();
       }
       return view('admin.homestay.index',compact(
           'states'
       ));
    }

    public function create()
    {
        $states = State::where('status',1)->where('is_home_stay',1)->orderBy('name','asc')->get();
       
        return view('admin.homestay.create',compact(
            'states'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'state_id' => 'required',
            'location_id' => 'required',
            'files.*' => 'required'
        ]); 
        //dd($request->all());

        $homeStay = new HomeStay();
        $homeStay->title = $request->title;
        $homeStay->slug = Str::slug($request->title,'-');
        $homeStay->state_id = $request->state_id;
        $homeStay->location_id = $request->location_id;
        $homeStay->tariff = $request->traiff;
        $homeStay->price_per_night = $request->price;
        $homeStay->description = $request->description;
        $homeStay->property_classification = $request->property_classification;
        $homeStay->property_uniqueness = $request->property_uniqueness;
        $homeStay->booking_policy = $request->booking_policy;
        $homeStay->cancellation_policy = $request->cancellation_policy;
        $homeStay->benefits = $request->benefit; 
        $homeStay->save(); 

        if ($request->hasFile('file')) {
            $files = $request->file('file');
            foreach($files as $key => $file){
                if($key == 0){
                    $default_status = 1;
                }else{
                    $default_status = 0;
                }
                $file_path = $this->fileService->store($file, '/homestay');
                $homeStayImage = new HomeStayImage();
                $homeStayImage->file_path = $file_path;
                $homeStayImage->home_stay_id = $homeStay->id;
                $homeStayImage->default_status = $default_status;
                $homeStayImage->save();
            }
        }
       
        if($request->facilities){
            foreach($request->facilities as $rowFacility){
                $file = $rowFacility['facility_file'];
                $file_path = $this->fileService->store($file, '/pakages');
                $homeStayFacility = new HomeStayFacility();
                $homeStayFacility->home_stay_id = $homeStay->id;
                $homeStayFacility->title = $rowFacility['title_text'];
                $homeStayFacility->beds = $rowFacility['bed'];
                $homeStayFacility->occupancy = $rowFacility['occupancy'];
                $homeStayFacility->toilet_with_geyser = $rowFacility['toilet_with_geyser'];
                $homeStayFacility->view = $rowFacility['view'];
                $homeStayFacility->attached_toilet = $rowFacility['toilet'];
                $homeStayFacility->file_path = $file_path;
                $homeStayFacility->save();
            }
        }


        $redirect = route('admin.homestays.index');
        return $this->success($redirect, 'Homestay Created successfully');
    }

    public function edit(string $id)
    {
        $home_stay_id = Crypt::decrypt($id);
        $item = HomeStay::with('state','location','homestay_images','homestay_facilities')->findOrFail($home_stay_id);
        $states = State::where('status',1)->where('is_home_stay',1)->orderBy('name','asc')->get();
      
        return view('admin.homestay.edit',compact(
            'states',
            'item'
        ));
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
