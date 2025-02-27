<?php

namespace App\Http\Controllers\Admin\City;

use App\FileService;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use App\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class CityController extends Controller
{
    use ResponseTrait;
    public $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(Request $request)
    {
       
        if ($request->ajax()) {
            $data = City::select('*');
            return DataTables::of($data)
                ->setRowId('id') 
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('admin.cities.edit',['city' => Crypt::encrypt($row->id) ]);
                    $deleteUrl = route('admin.cities.destroy',['city' => $row->id]);
                    $actionButton ='<div class="d-flex">
                        <a href="' .$editUrl. '" class="btn btn-sm btn-outline-success px-1"><i class="bx bxs-edit"></i></a>&nbsp;
                        <a href="javascript:;" class="ms-1 btn btn-sm btn-outline-danger px-1" data-bs-target="#deleteConfirm" data-bs-toggle="modal" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure, want to delete?\', \'Delete City Confirmation\')"><i class="bx bxs-trash"></i></a>
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
                    if($row->file_path != ''){
                        $file_path_url = '<img height="50px" src='. $row->file_path_url .' id="image_preview" alt="">';
                    }else{
                        $file_path_url = '<img height="50px" src='.asset('backend/assets/images/no-image.jpg').' id="image_preview" alt="">';
                    }
                    return $file_path_url;
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
                ->addColumn('top_destination', function ($row) {
                    if($row->top_destination == 1){
                        $top_destination = '<span class="badge rounded-pill bg-success">Yes</span>';
                    }
                    if($row->top_destination == 0){
                        $top_destination = '<span class="badge rounded-pill bg-danger">No</span>';
                    }
                    
                    return $top_destination;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request['status'] == '1' || $request['status'] == '0') {
                        $instance->where('status', $request['status']);
                    }
                    if ($request['top_destination'] == '1' || $request['top_destination'] == '0') {
                        $instance->where('top_destination', $request['top_destination']);
                    }
                    if (!empty($request['search'])) {
                        $instance->where(function($w) use($request){
                            $search = $request['search'];
                            $w->orWhere('name', 'LIKE', "%$search%");
                        });
                    }
                })
            ->rawColumns(['action','checkbox','file_path_url','status','top_destination'])
            ->toJson();
        }
        return view('admin.city.index');
    }

    public function create()
    {
        $states = State::where('status',1)->orderBy('name','ASC')->get();
        return view('admin.city.create',compact('states'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|unique:cities,name',
            'file' => 'required|image'
        ]);

        if ($request->hasFile('file')) {
            $uploaded_file = $request->file('file');
            $file_path = $this->fileService->store($uploaded_file, '/city');
        }

        if ($request->hasFile('top_file')) {
            $uploaded_top_file = $request->file('top_file');
            $top_file_path = $this->fileService->store($uploaded_top_file, '/city');
        }else{
            $top_file_path  = null;
        }
        if($request->top_destination){
            $top_destinantion = $request->top_destination;
        }else{
            $top_destinantion = 0;
        }
        $city = new City();
        $city->name = $request->name;
        $city->slug = Str::slug($request->name,'-');
        $city->file_path = $file_path;
        $city->top_destination = $top_destinantion;
        $city->top_destination_file_path = $top_file_path;
        $city->title = $request->title;
        $city->state_id = $request->state_id;
        $city->save();
        $redirect = route('admin.cities.index');
        return $this->success($redirect, 'City Created successfully');
    }

    public function edit(string $id)
    {
        $city_id = Crypt::decrypt($id);
        $item = City::findOrFail($city_id);
        $states = State::where('status',1)->orderBy('name','ASC')->get();
        return view('admin.city.edit',compact(
            'item',
            'states'
        ));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:cities,name,'.$id.',id'
        ]);

        $filename = City::where('id',$id)->value('file_path');
        if ($request->hasFile('file')) {
            if($filename!='') {
                if(Storage::exists($filename)){
                    Storage::delete($filename);
                }
            }
            $uploaded_file = $request->file('file');
            $file_path = $this->fileService->store($uploaded_file, '/city');
            
        }else{
            $file_path = $filename;
        }
        $topDestinationFileName = City::where('id',$id)->value('top_destination_file_path');
        if ($request->hasFile('top_file')) {
            if($topDestinationFileName!='') {
                if(Storage::exists($topDestinationFileName)){
                    Storage::delete($topDestinationFileName);
                }
            }
            $uploaded_file_top = $request->file('top_file');
            $top_file_path = $this->fileService->store($uploaded_file_top, '/city');
            
        }else{
            $top_file_path = $topDestinationFileName;
        }

        if($request->top_destination == 1){
            $top_destination_file_path = $top_file_path;
            $title = $request->title;
        }else{
            $top_destination_file_path = null;
            $title = null;
        }

        $city = City::findOrFail($id);
        $city->name = $request->name;
        $city->file_path = $file_path;
        $city->top_destination = $request->top_destination;
        $city->top_destination_file_path = $top_destination_file_path;
        $city->title = $title;
        $city->state_id = $request->state_id;
        $city->save();
        $redirect = route('admin.cities.index');
        return $this->success($redirect, 'City updated successfully');
    }

    public function destroy(string $id)
    {
        $filename = City::where('id',$id)->value('file_path');
        if($filename!='') {
            if(Storage::exists($filename)){
                Storage::delete($filename);
            }
        }
        City::destroy($id);
        $redirect = route('admin.cities.index');
        return $this->success($redirect, 'City deleted successfully');
    }

    public function status(Request $request)
    {
        $response = City::findOrFail($request->id);
        $response->status = $request->status;
        $response->save();
        if($response){
            return $this->ajaxSuccess($response, 'City status has been changed successfully');
        }else{
            return $this->ajaxError([]);
        }
    }

    public function action(Request $request)
    {
        if($request->action_value == 'is_delete'){
            foreach($request->ids as $id){
                $city = City::findOrFail($id);
                $city->delete();
            }
            $redirect = route('admin.cities.index');
            return $this->ajaxSuccess(['response' => $redirect, 'success_msg' => 'City deleted successfully','status' => true]);
        }
    }

    public function fetch_city(Request $request)
    {
        $cities = City::where('status',1)->where('state_id',$request->id)->get();
        $data = view('admin.state.fetch-city',compact('cities'))->render();
        return $this->ajaxSuccess(['status' => true, 'cities' => $cities, 'response' => $data,'success_msg' => 'State wise city fetch Successfully']);
    }
}
