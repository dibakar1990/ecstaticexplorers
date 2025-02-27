<?php

namespace App\Http\Controllers\Admin\State;

use App\FileService;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\State;
use App\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class StateController extends Controller
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
            $data = State::select('*');
            return DataTables::of($data)
                ->setRowId('id') 
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('admin.states.edit',['state' => Crypt::encrypt($row->id) ]);
                    $deleteUrl = route('admin.states.destroy',['state' => $row->id]);
                    $actionButton ='<div class="d-flex">
                        <a href="' .$editUrl. '" class="btn btn-sm btn-outline-success px-1"><i class="bx bxs-edit"></i></a>&nbsp;
                        <a href="javascript:;" class="ms-1 btn btn-sm btn-outline-danger px-1" data-bs-target="#deleteConfirm" data-bs-toggle="modal" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure, want to delete?\', \'Delete State Confirmation\')"><i class="bx bxs-trash"></i></a>
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
                ->addColumn('trending', function ($row) {
                    if($row->trending == 1){
                        $trending = '<span class="badge rounded-pill bg-success">Yes</span>';
                    }
                    if($row->trending == 0){
                        $trending = '<span class="badge rounded-pill bg-danger">No</span>';
                    }
                    
                    return $trending;
                })
                ->addColumn('explore_state', function ($row) {
                    if($row->explore_state == 1){
                        $explore_state = '<span class="badge rounded-pill bg-success">Yes</span>';
                    }
                    if($row->explore_state == 0){
                        $explore_state = '<span class="badge rounded-pill bg-danger">No</span>';
                    }
                    
                    return $explore_state; 
                })
                ->addColumn('explore_unexplore', function ($row) {
                    if($row->explore_unexplore == 1){
                        $explore_unexplore = '<span class="badge rounded-pill bg-success">Yes</span>';
                    }
                    if($row->explore_unexplore == 0){
                        $explore_unexplore = '<span class="badge rounded-pill bg-danger">No</span>';
                    }
                    
                    return $explore_unexplore; 
                }) 
                ->filter(function ($instance) use ($request) {
                    if ($request['status'] == '1' || $request['status'] == '0') {
                        $instance->where('status', $request['status']);
                    }
                    if ($request['trending'] == '1' || $request['trending'] == '0') {
                        $instance->where('trending', $request['trending']);
                    }
                    if ($request['explore_state'] == '1' || $request['explore_state'] == '0') {
                        $instance->where('explore_state', $request['explore_state']);
                    }
                    if ($request['explore_unexplore'] == '1' || $request['explore_unexplore'] == '0') {
                        $instance->where('explore_unexplore', $request['explore_unexplore']);
                    } 
                    if (!empty($request['search'])) {
                        $instance->where(function($w) use($request){
                            $search = $request['search'];
                            $w->orWhere('name', 'LIKE', "%$search%");
                        });
                    }
                })
            ->rawColumns(['action','checkbox','file_path_url','status','trending','explore_state','explore_unexplore'])
            ->toJson();     
        } 
        return view('admin.state.index');
    } 

    public function create()
    {
        return view('admin.state.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|unique:states,name',
            'starting_price' => 'required',
            'destination' => 'required',
            'hotels' => 'required',
            'tourist' => 'required',
            'tour' => 'required',
            'file' => 'required'
        ]);  

        if ($request->hasFile('file')) {
            $uploaded_file = $request->file('file');
            $file_path = $this->fileService->store($uploaded_file, '/state');
        }
        
        if($request->hasFile('trending_image')) 
        {
            $upload_trending_image = $request->file('trending_image');
            $trending_image_file_path = $this->fileService->store($upload_trending_image, '/state');
        } else {
            $trending_image_file_path = ''; 
        } 
        
        if($request->trending){
            $trending = $request->trending;
        }else{
            $trending = 0;
        }
        if($request->explore_state){
            $explore_state = $request->explore_state;
        }else{ 
            $explore_state = 0;
        }
        if($request->explore_unexplore){
            $explore_unexplore = $request->explore_unexplore;
        }else{ 
            $explore_unexplore = 0;
        }
        if($request->is_home_stay){
            $is_home_stay = $request->is_home_stay;
        }else{ 
            $is_home_stay = 0;
        }
        $state = new State();
        $state->sl_no = $request->sl_no;
        $state->name = $request->name;
        $state->starting_price = $request->starting_price;
        $state->slug = Str::slug($request->name,'-');
        $state->file_path = $file_path;
        $state->trending = $trending;
        $state->trending_image = $trending_image_file_path;       
        $state->explore_state = $explore_state;
        $state->explore_unexplore = $explore_unexplore;
        $state->is_home_stay = $is_home_stay;
        $state->destination = $request->destination;
        $state->hotels = $request->hotels;
        $state->tourist = $request->tourist;
        $state->tour = $request->tour;
        $state->save(); 
        $redirect = route('admin.states.index');
        return $this->success($redirect, 'State Created successfully');
    }

    public function edit(string $id)
    {
        $state_id = Crypt::decrypt($id);
        $item = State::findOrFail($state_id);
        return view('admin.state.edit',compact(
            'item',
        ));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:states,name,'.$id.',id',
            'starting_price' => 'required',
            'destination' => 'required',
            'hotels' => 'required',
            'tourist' => 'required',
            'tour' => 'required',
        ]);

        $filename = State::where('id',$id)->value('file_path');
        if ($request->hasFile('file')) {
            if($filename!='') {
                if(Storage::exists($filename)){
                    Storage::delete($filename);
                }
            }
            $uploaded_file = $request->file('file');
            $file_path = $this->fileService->store($uploaded_file, '/state');
            
        }else{
            $file_path = $filename;
        }
        
        $trending_image = State::where('id', $id)->value('trending_image'); 
        if($request->hasFile('trending_image')) 
        {
            if($trending_image != '') 
            {
                if(Storage::exists($trending_image))
                {
                    Storage::delete($trending_image);
                }
            } 
            $upload_trending_image = $request->file('trending_image'); 
            $trending_image_file_path = $this->fileService->store($upload_trending_image, '/state'); 
        } else {  
            $trending_image_file_path = $trending_image; 
        } 

        if($request->trending){
            $trending = $request->trending;
        }else{
            $trending = 0;
        }
        if($request->explore_state){
            $explore_state = $request->explore_state;
        }else{ 
            $explore_state = 0;
        }
        if($request->explore_unexplore){
            $explore_unexplore = $request->explore_unexplore;
        }else{ 
            $explore_unexplore = 0;
        }

        if($request->is_home_stay){
            $is_home_stay = $request->is_home_stay;
        }else{ 
            $is_home_stay = 0;
        }
        
        $state = State::findOrFail($id);
        $state->sl_no = $request->sl_no;
        $state->name = $request->name;
        $state->starting_price = $request->starting_price;
        $state->file_path = $file_path;
        $state->trending = $trending;
        $state->trending_image = $trending_image_file_path;  
        $state->explore_state = $explore_state;
        $state->explore_unexplore = $explore_unexplore;
        $state->is_home_stay = $is_home_stay;
        $state->destination = $request->destination;
        $state->hotels = $request->hotels;
        $state->tourist = $request->tourist;
        $state->tour = $request->tour;
        $state->save();
        $redirect = route('admin.states.index');
        return $this->success($redirect, 'State updated successfully');
    }

    public function destroy(string $id)
    {
        $filename = State::where('id',$id)->value('file_path');
        if($filename!='') {
            if(Storage::exists($filename)){
                Storage::delete($filename);
            }
        }
        
        $trending_image = State::where('id', $id)->value('trending_image');
        if($trending_image != '') {
            if(Storage::exists($trending_image))
            {
                Storage::delete($trending_image);
            }
        } 
         
        State::destroy($id);
        $redirect = route('admin.states.index');
        return $this->success($redirect, 'State deleted successfully');
    }

    public function status(Request $request)
    {
        $response = State::findOrFail($request->id);
        $response->status = $request->status;
        $response->save();
        if($response){
            return $this->ajaxSuccess($response, 'State status has been changed successfully');
        }else{
            return $this->ajaxError([]);
        }
    }

    public function action(Request $request)
    {
        if($request->action_value == 'is_delete'){
            foreach($request->ids as $id){
                $state = State::findOrFail($id);
                $state->delete();
            }
            $redirect = route('admin.states.index');
            return $this->ajaxSuccess(['response' => $redirect, 'success_msg' => 'State deleted successfully','status' => true]);
        }
    }
}
